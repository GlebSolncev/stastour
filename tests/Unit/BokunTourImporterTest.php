<?php

namespace Tests\Unit;

use App\Services\Bokun\BokunTourImporter;
use ReflectionClass;
use Tests\TestCase;

class BokunTourImporterTest extends TestCase
{
    public function test_it_builds_road_from_bokun_meeting_point_address(): void
    {
        $reflection = new ReflectionClass(BokunTourImporter::class);
        $importer = $reflection->newInstanceWithoutConstructor();
        $method = $reflection->getMethod('locationValue');
        $method->setAccessible(true);

        $road = $method->invoke($importer, [
            'meetingType' => ['meetingPointAddresses' => [[
                'address' => [
                    'addressLine1' => 'Hard Rock Cafe | Lisbon, Avenida da Liberdade, Lisbon, Portugal',
                    'city' => 'Lisboa',
                    'state' => 'Lisboa',
                    'postalCode' => '1250-144',
                    'countryCode' => 'PT',
                ],
            ]]],
        ]);

        $this->assertSame(
            'Hard Rock Cafe | Lisbon, Avenida da Liberdade, Lisbon, Portugal, Lisboa, 1250-144, PT',
            $road
        );
    }

    public function test_it_detects_original_image_format_without_conversion(): void
    {
        $source = new \Imagick();
        $source->newImage(2, 2, new \ImagickPixel('transparent'), 'png');
        $png = $source->getImageBlob();
        $source->clear();
        $source->destroy();
        $reflection = new ReflectionClass(BokunTourImporter::class);
        $importer = $reflection->newInstanceWithoutConstructor();
        $method = $reflection->getMethod('detectImageFormat');
        $method->setAccessible(true);

        $format = $method->invoke($importer, $png);

        $this->assertSame(['image/png', 'png'], $format);
        $this->assertStringStartsWith("\x89PNG\r\n\x1A\n", $png);
    }
}
