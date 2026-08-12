<?php

namespace App\Jobs;

use App\Models\BokunImport;
use App\Services\Bokun\BokunTourImporter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class ImportBokunTours implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 900;
    public int $tries = 1;
    public bool $failOnTimeout = true;

    public function __construct(public readonly int $importId)
    {
        $this->onQueue('bokun-imports');
    }

    public function handle(BokunTourImporter $importer): void
    {
        $record = BokunImport::findOrFail($this->importId);
        $record->update(['status' => 'in_progress', 'started_at' => now()]);

        try {
            $result = $importer->import();
            $record->update([
                'status' => $result['failed'] > 0 ? 'completed_with_errors' : 'completed',
                'created_count' => $result['created'],
                'updated_count' => $result['updated'],
                'failed_count' => $result['failed'],
                'errors' => $result['errors'] ?: null,
                'finished_at' => now(),
            ]);
        } catch (Throwable $exception) {
            $this->markFailed($exception);
            throw $exception;
        }
    }

    public function failed(?Throwable $exception): void
    {
        if ($exception) {
            $this->markFailed($exception);
        }
    }

    private function markFailed(Throwable $exception): void
    {
        BokunImport::whereKey($this->importId)->update([
            'status' => 'failed',
            'failed_count' => 1,
            'errors' => json_encode(['job' => $exception->getMessage()]),
            'finished_at' => now(),
        ]);
    }
}
