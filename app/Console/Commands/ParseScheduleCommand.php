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
    protected $description = 'Parse the whole schedule and save all data.';

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
            echo $group->name;
            $time_start = microtime(true);

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
                    $date = date("Y-$date[1]-$date[0]");

                    $know_hours = Hour::where('date', $date)->where('group_id', $group->id)->get();

                    # Перебор часов
                    foreach ($day->find('.day-lesson') as $hour_html) {

                        $rooms_raw = $hour_html->find('.lesson-room');
                        $rooms = [];

                        foreach ($rooms_raw as $room) {
                            if (!empty($room->text()) && !str_contains($room->text(), "Подгр.")) {
                                $rooms[] = trim($room->text());
                            }
                        }

                        $teachers = $hour_html->find(".lesson-teacher");

                        $teachers_current = array_map(function ($teacher) {
                            return trim($teacher->text());
                        }, iterator_to_array($teachers));

                        $time = explode('n', $hour_html->getAttribute('data-lesson'))[1];

                        # Занятия группы в данной паре (могут быть разделения по подгруппам)
                        $hours = [];
                        for ($i = 0; $i < count($teachers_current); $i++) {
                            $hour = new Hour;

                            # Порядковый номер пары
                            $hour->time = $time;

                            # Дата проведения пары в формате Y-m-d
                            $hour->date = $date;

                            # Группа, у которой будет занятие
                            $hour->group()->associate($group);

                            # Если такая аудитория ещё не существует в бд, то добавляем её. В любом случае мы
                            # должны получить id и вставить его вместе с другими данными в таблицу часов.
                            $hour->auditory()->associate(Auditory::firstOrCreate(['name' => trim($rooms[$i])]));

                            # Учебная дисциплина
                            $hour->subject()->associate(Subject::firstOrCreate(
                                ['name' => trim($hour_html->find('.lesson-name', 0)->text())]
                            ));

                            # Тип пары - практика, лекция или лабораторная работа
                            $hour->type()->associate(Type::firstOrCreate([
                                'name' => trim(substr($hour_html->find('.lesson-type', 0)->text(), 1, -1)),
                            ]));

                            # Преподаватель
                            $hour->teacher()->associate(Teacher::firstOrCreate(['name' => $teachers_current[$i]]));

                            $hours[] = $hour;
                        }

                        # Исключаем дубликаты из бд, если мы получили известные ранее даты.
                        # Здесь нет отслеживания изменений, поскольку это бы сильно раздуло код. Для отслеживания нужно
                        # перед запуском этой команды запускать команду schedule:parse-changes.
                        foreach ($hours as $hour) {
                            foreach ($know_hours as $know_hour) {

                                # Не нужно сохранять в бд дубликаты
                                if ($hour->compareTo($know_hour)) {
                                    continue 2;
                                }
                            }
                            # Дубликат не найден
                            $hour->save();
                        }
                    }
                }
            }

            echo " (", round((microtime(true) - $time_start)/60, 3), ")", PHP_EOL;
            usleep(0.3 * 10**6);
        }

        return 0;
    }
}
