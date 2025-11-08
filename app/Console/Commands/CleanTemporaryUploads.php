<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class CleanTemporaryUploads extends Command
{
    protected $signature = 'cleanup:temp-uploads';
    protected $description = 'Delete temporary uploaded files older than 1 hour';

    public function handle()
    {
        $tempDir = public_path('temp_uploads');

        if (!File::exists($tempDir)) {
            $this->info("No temporary upload directory found.");
            return;
        }

        $folders = File::directories($tempDir);
        $deleted = 0;

        foreach ($folders as $folder) {
            $lastModified = Carbon::createFromTimestamp(File::lastModified($folder));

            if ($lastModified->lt(now()->subHours(1))) {
                File::deleteDirectory($folder);
                $deleted++;
            }
        }

        $this->info("Cleanup complete. $deleted temporary folder(s) deleted.");
    }

}
