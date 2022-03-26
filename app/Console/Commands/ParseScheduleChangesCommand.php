<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ParseScheduleChangesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:parse-changes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if there are changes in the scheduler and save them';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
