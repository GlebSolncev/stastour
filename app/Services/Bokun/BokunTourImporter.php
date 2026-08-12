<?php

namespace App\Services\Bokun;

use App\Models\Tours;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Orchid\Attachment\File;

class BokunTourImporter
{
    public function __construct(
        private readonly BokunBookingService $bokun
    ) {}

    /**
     * Import tours and return a summary suitable for CLI and the admin panel.
     *
     * @return array{created:int, updated:int, failed:int, errors:array<int|string, string>}
     */
    public function import(
        array $activityIds = [],
        bool $downloadImages = true,
        bool $refreshImages = false,
        ?callable $progress = null
    ): array {
        $result = ['created' => 0, 'updated' => 0, 'failed' => 0, 'errors' => []];

        if (!$activityIds) {
            $activityIds = $this->activeActivityIds();
        }

        foreach (array_values(array_unique(array_map('intval', $activityIds))) as $activityId) {
            if ($activityId < 1) {
                continue;
            }

            try {
                if ($progress) {
                    $progress("Importing Bokun activity {$activityId}...");
                }
                $data = $this->bokun->getCat($activityId);
                $existing = Tours::where('bokun_id', $activityId)->first();
                $attributes = $this->tourAttributes($data, $activityId, $existing);

                $existingImageIds = $existing
                    ? array_values(array_filter(explode(',', (string) $existing->image), 'is_numeric'))
                    : [];

                if ($existing && $existingImageIds) {
                    $firstImage = json_encode([(int) $existingImageIds[0]]);
                    if ($this->photoIsEmpty($existing->preview_photo)) {
                        $attributes['preview_photo'] = $firstImage;
                    }
                    if ($this->photoIsEmpty($existing->detail_photo)) {
                        $attributes['detail_photo'] = $firstImage;
                    }
                }

                $needsInitialImages = !$existing || (!$existingImageIds && (
                    $this->photoIsEmpty($existing->preview_photo)
                    || $this->photoIsEmpty($existing->detail_photo)
                ));

                if ($downloadImages && ($needsInitialImages || $refreshImages)) {
                    $imageIds = $this->importImages(Arr::get($data, 'photos', []));
                    if ($imageIds) {
                        $attributes['image'] = implode(',', $imageIds);
                        $firstImage = json_encode([(int) $imageIds[0]]);

                        if (!$existing || $this->photoIsEmpty($existing->preview_photo)) {
                            $attributes['preview_photo'] = $firstImage;
                        }

                        if (!$existing || $this->photoIsEmpty($existing->detail_photo)) {
                            $attributes['detail_photo'] = $firstImage;
                        }
                    }
                }

                if ($existing) {
                    $existing->fill($attributes)->saveOrFail();
                    $result['updated']++;
                    if ($progress) {
                        $progress("  Updated: {$existing->name}");
                    }
                } else {
                    $tour = Tours::create($attributes);
                    if (!$tour) {
                        throw new \RuntimeException('The tour model rejected the imported data.');
                    }
                    $result['created']++;
                    if ($progress) {
                        $progress("  Created: {$tour->name}");
                    }
                }
            } catch (\Throwable $exception) {
                report($exception);
                $result['failed']++;
                $result['errors'][$activityId] = $exception->getMessage();
                if ($progress) {
                    $progress('  Failed.');
                }
            }
        }

        return $result;
    }

    private function photoIsEmpty(?string $value): bool
    {
        if (!$value) {
            return true;
        }

        $decoded = json_decode($value, true);

        return !is_array($decoded) || count(array_filter($decoded, 'is_numeric')) === 0;
    }

    /** @return int[] */
    private function activeActivityIds(): array
    {
        $response = $this->bokun->getTourIds();
        $ids = [];

        foreach (Arr::get($response, 'suppliers', []) as $supplier) {
            foreach (Arr::get($supplier, 'activityIds', []) as $activityId) {
                if ((int) $activityId > 0) {
                    $ids[] = (int) $activityId;
                }
            }
        }

        if (!$ids) {
            throw new \RuntimeException('Bokun returned no active activity IDs.');
        }

        return array_values(array_unique($ids));
    }

    private function tourAttributes(array $data, int $activityId, ?Tours $existing): array
    {
        $name = trim((string) Arr::get($data, 'title', ''));
        if ($name === '') {
            throw new \RuntimeException('Bokun activity has no title.');
        }

        $priceRules = Arr::get($data, 'pricing.experiencePriceRules', []);
        $price = Arr::get($priceRules, '0.amount', Arr::get($data, 'nextDefaultPrice', 0));
        $preview = (string) Arr::get($data, 'shortDescription', '');
        $description = (string) Arr::get($data, 'description', $preview);

        $attributes = [
            'bokun_id' => $activityId,
            'price' => is_numeric($price) ? (float) $price : 0,
            'preview_text' => $preview,
            'description' => $description,
        ];

        $location = $this->locationValue($data);
        if ($location !== '') {
            $attributes['road'] = $location;
        }

        if (!$existing) {
            $attributes += [
                'name' => $name,
                'name_fr' => '',
                'name_es' => '',
                'preview_text_fr' => '',
                'preview_text_es' => '',
                'description_fr' => '',
                'description_es' => '',
                'code' => $this->uniqueCode($name, $activityId),
                'type_tour' => $this->bokunTourType($data),
                'image' => '',
                'person_count' => $this->capacityValue(Arr::get($data, 'capacity', 1)),
                'duration_of_the_tour' => $this->durationInHours(Arr::get($data, 'duration')),
                'road' => $location,
                'time_slot' => '',
                'map_file' => '',
                'preview_photo' => '',
                'detail_photo' => '',
                'type_road_tour' => '',
                'label_color' => '',
                'sort' => '500',
            ];
        }

        return $attributes;
    }

    private function bokunTourType(array $data): string
    {
        return Arr::get($data, 'privateActivity') === true ? 'private' : 'group';
    }

    private function locationValue(array $data): string
    {
        $startPoint = Arr::get(
            $data,
            'meetingType.meetingPointAddresses.0',
            Arr::get($data, 'startPoints.0', [])
        );
        $address = Arr::get($startPoint, 'address', []);

        if (is_array($address)) {
            $parts = array_filter([
                Arr::get($address, 'addressLine1'),
                Arr::get($address, 'city'),
                Arr::get($address, 'postalCode'),
                Arr::get($address, 'countryCode'),
            ], fn ($value) => is_scalar($value) && trim((string) $value) !== '');

            if ($parts) {
                return implode(', ', array_values(array_unique(array_map(
                    fn ($value) => trim((string) $value),
                    $parts
                ))));
            }
        }

        foreach ([
            'startPoints.0.location.wholeAddress',
            'startPoints.0.title',
            'meetingType.meetingPointAddresses.0.title',
            'location.wholeAddress',
            'meetingPoint',
        ] as $path) {
            $value = Arr::get($data, $path);
            if (is_scalar($value) && trim((string) $value) !== '') {
                return trim((string) $value);
            }
        }

        return '';
    }

    private function capacityValue(mixed $capacity): string
    {
        if (is_numeric($capacity)) {
            return (string) $capacity;
        }

        if (is_array($capacity)) {
            foreach (['maximum', 'max', 'value', 'capacity'] as $key) {
                if (is_numeric(Arr::get($capacity, $key))) {
                    return (string) Arr::get($capacity, $key);
                }
            }
        }

        return '1';
    }

    private function durationInHours(mixed $duration): string
    {
        if (is_numeric($duration)) {
            return $this->decimalString((float) $duration);
        }

        if (!is_array($duration)) {
            return '';
        }

        $hours = (float) Arr::get($duration, 'hours', 0);
        $minutes = (float) Arr::get($duration, 'minutes', 0);
        $seconds = (float) Arr::get($duration, 'seconds', 0);
        $days = (float) Arr::get($duration, 'days', 0);

        if ($days || $hours || $minutes || $seconds) {
            return $this->decimalString(($days * 24) + $hours + ($minutes / 60) + ($seconds / 3600));
        }

        $value = Arr::get($duration, 'duration', Arr::get($duration, 'value'));
        if (!is_numeric($value)) {
            return '';
        }

        return match (strtoupper((string) Arr::get($duration, 'durationType', Arr::get($duration, 'unit', 'HOURS')))) {
            'DAYS', 'DAY' => $this->decimalString((float) $value * 24),
            'MINUTES', 'MINUTE' => $this->decimalString((float) $value / 60),
            'SECONDS', 'SECOND' => $this->decimalString((float) $value / 3600),
            default => $this->decimalString((float) $value),
        };
    }

    private function decimalString(float $value): string
    {
        return rtrim(rtrim(number_format($value, 2, '.', ''), '0'), '.');
    }

    private function uniqueCode(string $name, int $activityId): string
    {
        $base = Str::slug($name) ?: 'bokun-tour-' . $activityId;
        $code = $base;

        if (Tours::where('code', $code)->exists()) {
            $code = $base . '-' . $activityId;
        }

        return $code;
    }

    /** @return int[] */
    private function importImages(array $photos): array
    {
        $ids = [];
        $attachments = [];
        $errors = [];

        foreach ($photos as $photo) {
            $url = Arr::get($photo, 'originalUrl');
            if (!$url) {
                continue;
            }

            try {
                $attachment = $this->saveImage($url);
                $ids[] = $attachment->id;
                $attachments[] = $attachment;
            } catch (\Throwable $exception) {
                report($exception);
                Log::warning('Unable to import Bokun tour image', [
                    'url' => $url,
                    'message' => $exception->getMessage(),
                ]);
                $errors[] = $url . ': ' . $exception->getMessage();
            }
        }

        if ($errors) {
            foreach ($attachments as $attachment) {
                try {
                    $attachment->delete();
                } catch (\Throwable $cleanupException) {
                    report($cleanupException);
                }
            }

            throw new \RuntimeException(
                count($errors) . ' Bokun image(s) failed. ' . implode('; ', array_slice($errors, 0, 3))
            );
        }

        return $ids;
    }

    private function saveImage(string $url): mixed
    {
        $response = Http::timeout(120)
            ->retry(3, 500)
            ->accept('*/*')
            ->withHeaders(['User-Agent' => 'Stastour-Bokun-Importer/1.0'])
            ->withOptions(['allow_redirects' => ['max' => 10, 'track_redirects' => true]])
            ->get($url)
            ->throw();
        $body = $response->body();
        if ($body === '') {
            throw new \RuntimeException('Bokun returned an empty image file.');
        }

        $responseType = strtolower(trim(explode(';', (string) $response->header('Content-Type'))[0]));
        $urlPath = (string) parse_url($url, PHP_URL_PATH);
        $headerName = $this->contentDispositionFilename((string) $response->header('Content-Disposition'));
        $sourceName = $headerName ?: (basename($urlPath) ?: 'bokun-image');
        $format = $this->detectImageFormat($body);
        if (!$format) {
            throw new \RuntimeException("Bokun response is not a supported image (Content-Type: {$responseType}).");
        }

        [$contentType, $extension] = $format;
        $baseName = pathinfo($sourceName, PATHINFO_FILENAME) ?: 'bokun-image';
        $originalName = $baseName . '.' . $extension;

        $originalName = Str::limit(preg_replace('/[^A-Za-z0-9._-]/', '-', $originalName), 180, '');
        $tempPath = tempnam(sys_get_temp_dir(), 'bokun_');

        if ($tempPath === false) {
            throw new \RuntimeException('Unable to create a temporary image file.');
        }

        try {
            if (file_put_contents($tempPath, $body) === false) {
                throw new \RuntimeException('Unable to write a temporary image file.');
            }

            $uploadedFile = new UploadedFile(
                $tempPath,
                $originalName,
                $contentType,
                null,
                true
            );

            $attachment = (new File($uploadedFile))->allowDuplicates()->load();
            $storedPath = $attachment->path . $attachment->name . '.' . $attachment->extension;
            $storage = Storage::disk($attachment->disk);

            // Orchid writes the temporary upload to storage as a stream. Do not read and
            // rewrite large files here: a long-running queue worker can exhaust memory and
            // report a false truncation even though the first streamed write succeeded.
            if (!$storage->exists($storedPath)) {
                $attachment->delete();
                throw new \RuntimeException('The Bokun image was not written to attachment storage.');
            }

            return $attachment;
        } finally {
            if (is_file($tempPath)) {
                unlink($tempPath);
            }
        }
    }

    /** @return array{string, string}|null */
    private function detectImageFormat(string $contents): ?array
    {
        if (str_starts_with($contents, "\xFF\xD8\xFF")) {
            return ['image/jpeg', 'jpg'];
        }
        if (str_starts_with($contents, "\x89PNG\r\n\x1A\n")) {
            return ['image/png', 'png'];
        }
        if (str_starts_with($contents, 'GIF87a') || str_starts_with($contents, 'GIF89a')) {
            return ['image/gif', 'gif'];
        }
        if (strlen($contents) >= 12 && substr($contents, 0, 4) === 'RIFF' && substr($contents, 8, 4) === 'WEBP') {
            return ['image/webp', 'webp'];
        }
        if (strlen($contents) >= 12 && substr($contents, 4, 4) === 'ftyp') {
            $brands = substr($contents, 8, 32);
            if (str_contains($brands, 'avif') || str_contains($brands, 'avis')) {
                return ['image/avif', 'avif'];
            }
            foreach (['heic', 'heix', 'hevc', 'hevx', 'mif1', 'msf1'] as $brand) {
                if (str_contains($brands, $brand)) {
                    return ['image/heic', 'heic'];
                }
            }
        }

        return null;
    }

    private function contentDispositionFilename(string $header): ?string
    {
        if (preg_match("/filename\\*=UTF-8''([^;]+)/i", $header, $match)) {
            return basename(rawurldecode(trim($match[1], " \t\n\r\0\x0B\"'")));
        }
        if (preg_match('/filename="?([^";]+)"?/i', $header, $match)) {
            return basename(trim($match[1]));
        }

        return null;
    }
}
