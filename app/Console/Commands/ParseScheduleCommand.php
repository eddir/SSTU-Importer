<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Models\Auditory;
use App\Models\Group;
use App\Models\Hour;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Type;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ParseScheduleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse the whole schedule and save all data';

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
        Log::info("Запускается сбор данных о занятиях.");

        $groups = Group::all();

        foreach ($groups as $group) {
            $html = Helper::requestFromSSTU('https://rasp.sstu.ru/rasp/group/' . $group->url);

            # Не пустой ли календарь
            $weeks = $html->find('.week');
            foreach ($weeks as $week) {

                # Перебор всех дней
                foreach ($week->find('.day') as $day) {
                    if (str_contains($day->getAttribute('class'), "header")) {
                        continue;
                    }

                    # Ищем дату
                    $row_date = $day->find('.day-header', 0)->text();
                    preg_match("/\d.\.\d./", $row_date, $matched_date);
                    $date = explode(".", $matched_date[0]);

                    # Перебор часов
                    foreach ($day->find('.day-lesson') as $hour_html) {
                        # Попробую объединить в одно ветвление без повторения кода

                        $rooms_raw = $hour_html->find('.lesson-room');
                        $rooms = [];

                        foreach ($rooms_raw as $room) {
                            if (!empty($room->text()) && !str_contains($room->text(), "Подгр.")) {
                                $rooms[] = $room->text();
                            }
                        }

                        $teachers = $hour_html->find(".lesson-teacher");

                        $teachers_current = array_map(function ($teacher) {
                            return $teacher->text();
                        }, iterator_to_array($teachers));

                        for ($i = 0; $i < count($teachers_current); $i++) {
                            $hour = new Hour;

                            # Порядковый номер пары
                            $hour->time = explode('n', $hour_html->getAttribute('data-lesson'))[1];

                            # Дата проведения пары в формате Y-m-d
                            $hour->date = date("Y-$date[1]-$date[0]");

                            # Группа, у которой будет занятие
                            $hour->group()->associate($group);

                            # Если такая аудитория ещё не существует в бд, то добавляем её. В любом случае мы
                            # должны получить id и вставить его вместе с другими данными в таблицу часов.
                            $hour->auditory()->associate(Auditory::firstOrCreate(['name' => $rooms[$i]]));

                            # Учебная дисциплина
                            $hour->subject()->associate(Subject::firstOrCreate(
                                ['name' => $hour_html->find('.lesson-name', 0)->text()]
                            ));

                            # Тип пары - практика, лекция или лабораторная работа
                            $hour->type()->associate(Type::firstOrCreate([
                                'name' => trim(substr($hour_html->find('.lesson-type', 0)->text(), 1, -1)),
                            ]));

                            # Преподаватель
                            $hour->teacher()->associate(Teacher::firstOrCreate(['name' => $teachers_current[$i]]));

                            $hour->save();
                        }

                    }
                }
            }

            usleep(300000);
            echo "next";
        }

        return 0;
    }
}
