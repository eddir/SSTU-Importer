<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Helpers\Parser;
use App\Models\Auditory;
use App\Models\Group;
use App\Models\Subject;
use App\Models\Teacher;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ParseGroupsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:groups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the list of groups from the schedule.';

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
    public function handle(): int
    {
        Log::info("Запускается сбор данных о группах в университете.");

        Parser::parseGroups(Helper::getHtmlFromURL(config('services.sstu.homepage_url')));
        return 0;
    }
}
