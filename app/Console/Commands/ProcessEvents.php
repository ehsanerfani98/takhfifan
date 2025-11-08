<?php

namespace App\Console\Commands;

use App\Services\EventService;
use Illuminate\Console\Command;

class ProcessEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        app(EventService::class)->processEvents();
    }
}
