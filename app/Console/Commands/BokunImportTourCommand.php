<?php

namespace App\Console\Commands;

use App\Services\Bokun\BokunTourImporter;
use Illuminate\Console\Command;

class BokunImportTourCommand extends Command
{
    protected $signature = 'bokun:import
        {--id=* : Import only the specified Bokun activity ID(s)}
        {--without-images : Do not download images for new tours}
        {--refresh-images : Replace images for tours that already exist}';

    protected $description = 'Import or update active tours from Bokun';

    public function handle(BokunTourImporter $importer): int
    {
        $ids = array_values(array_unique(array_map('intval', $this->option('id'))));
        $ids = array_values(array_filter($ids, fn (int $id) => $id > 0));

        if ($this->option('without-images') && $this->option('refresh-images')) {
            $this->error('Options --without-images and --refresh-images cannot be used together.');

            return self::INVALID;
        }

        $this->info($ids
            ? 'Importing selected Bokun tours: ' . implode(', ', $ids)
            : 'Loading active tours from Bokun...');

        $result = $importer->import(
            $ids,
            !$this->option('without-images'),
            (bool) $this->option('refresh-images'),
            function (string $message): void {
                $this->line($message);
            }
        );

        $this->newLine();
        $this->table(
            ['Created', 'Updated', 'Failed'],
            [[$result['created'], $result['updated'], $result['failed']]]
        );

        foreach ($result['errors'] as $id => $message) {
            $this->error("Bokun activity {$id}: {$message}");
        }

        if ($result['failed'] > 0) {
            $this->warn('Import completed with errors. Successful tours were saved.');

            return self::FAILURE;
        }

        $this->info('Bokun import completed successfully.');

        return self::SUCCESS;
    }
}
