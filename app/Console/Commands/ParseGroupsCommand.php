<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
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
    protected $description = 'Update the list of groups from the schedule';

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

        $audiences = Auditory::all();
        $groups = Group::all();
        $teachers = Teacher::all();
        $subjects = Subject::all();

        $accordion = Helper::requestFromSSTU('https://rasp.sstu.ru/')->find('div[id=raspStructure]', 0);

        # Перебор институтов
        foreach ($accordion->children() as $fac) {
            $facName = trim($fac->find('.card-header', 0)->text());

            # перебор групп
            foreach ($fac->find('a') as $group) {
                $groupName = $group->text();
                $url = explode("group/", $group->getAttribute('href'))[1];
                $group = $groups->firstWhere('name', $groupName);

                if ($group === null) {
                    try {
                        $group_data = [
                            'name' => $groupName,
                            'faculty' => $facName,
                            'url' => $url
                        ];

                        $group = Group::create($group_data);
                        $group->save();
                        $groups->push($group);
                    } catch (Exception $error) {
                        echo $error->getMessage(), PHP_EOL;
                    }
                } elseif ($url != $group->url) {
                    try {
                        $group->url = $url;
                        $group->save();
                    } catch (Exception $error) {
                        echo $error->getMessage(), PHP_EOL;
                    }
                }
            }
        }
        return 0;
    }
}
