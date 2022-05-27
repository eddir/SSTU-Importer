<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Models\Auditory;
use App\Models\Group;
use App\Models\Hour;
use App\Models\Subject;
use App\Models\Teacher;
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
    protected $description = 'Check if there are changes in the scheduler and save them.';

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
        exit("Этот код не протестирован!");
        # Проходим по всем парам и проверяем наличие изменений
        # Вариант 1 - пары больше нет
        # Вариант 2 - новая пара
        # Вариант 3 - изменились атрибуты (кабинет, дисциплина, преподаватель)
        #
        # Формируем список с событиями и только после внесения всех изменений в бд объявляем их всех разом

        # 1. получили [Дисциплина, препод, аудитория, время]
        # 2. получаем по этим данным [группы] из room/0
        $department_html = Helper::getHtmlFromURL('https://rasp.sstu.ru/rasp/department/0');
        $room_html = Helper::getHtmlFromURL('https://rasp.sstu.ru/rasp/room/0');

        # Для каждого препода пройтись по каждой паре. Проверить наличие этой пары в бд.
        # Пара есть: проверить атрибуты
        # Пары нет: добавить пару
        # Если что-то поменялось - добавить событие

        $date = null;
        $date_formatted = null;
        $teacher = null;
        $time = null;
        $auditory = null;

        $item = $department_html->find('.calendar', 0)->firstChild();

        # Смотрим весь календарь, ищем преподов и их занятия
        while ($item = $item->nextSibling()) {
            if ($item->getTag() == 'h5') {
                $teacher = Teacher::firstOrCreate(['name' => trim($item->text())]);
                continue;
            }

            $raw = $item->find('td', 0);

            # Проходим по всем занятиям препода
            while ($raw = $raw->nextSibling()) {
                $className = explode(" ", $raw->getAttribute('class'))[0];
                switch ($className) {
                    case "day":
                        # Ищем дату
                        preg_match("/\d.\.\d./", $raw->text(), $matched_date);
                        $date = $matched_date[0];
                        // C датой лучше пока работать в сыром виде, так как в будущем будут ещё манипуляции с
                        // сайтом расписания
                        $date_formatted = explode(".", $matched_date[0]);
                        $date_formatted = date("Y-$date_formatted[1]-$date_formatted[0]");
                        break;
                    case "hour":
                        # Ищем порядковый номер пары
                        $time = trim($raw->text());
                        break;
                    case "room":
                        # Ищем аудиторию
                        $auditory = Auditory::firstOrCreate(['name' => trim($raw->text())]);
                        break;
                }

                if ($className == "lesson") {
                    foreach ($raw->children as $child) {
                        $child->outertext = "";
                    }
                    $subject = Subject::firstOrCreate([
                        'name' => trim($raw->innertext)
                    ]);

                    # На этом этапе у нас есть препод, время, аудитория и дисциплина. Пора перейти к поиску групп.
                    $groups = [];

                    # Целимся: Дата - Номер пары - [Группа, аудитория, препод]
                    # Когда найдём все подходящие под описание группы, будем сравнивать это с бд.

                    $dep_days = $department_html->find('.day-header');
                    foreach ($dep_days as $dep_day) {
                        if (str_contains($dep_day->text(), $date)) {
                            # Нашли дату. Ищем пару.
                            $dep_hour = $dep_day->parent()->find('.day-lesson', $time - 1)->firstChild()->firstChild();

                            while ($dep_hour = $dep_hour->nextSibling()) {
                                if ($dep_hour->getAttribute('class') == "lesson-teacher"
                                    and $dep_hour->text() == $teacher->name) {
                                    $group_name = explode(": ",
                                        $dep_hour->previousSibling()->previousSibling()->text())[0];
                                    $groups[] = Group::firstOrFail(['name' => $group_name]);
                                    dd($groups);
                                }
                            }
                            $groups_ids = [];
                            foreach ($groups as $group) {
                                $groups_ids[] = $group->id;
                            }

                            # На этом этапе у нас есть вся информация о паре?
                            if (!Hour::where('date', $date_formatted)
                                ->where('time', $time)
                                ->whereIn('group_id', $groups_ids)
                                ->where('auditory_id', $auditory->id)
                                ->where('subject_id', $subject->id)
                                ->where('teacher_id', $teacher->id)
                                ->exists()) {
                                echo "ПЕРЕМОГА. Здесь нет нашей пары!";
                                die();
                            } else {
                                dd("Всё норм");
                            }

                            # Здесь нужно будет покинуть цикл поиска во второй странице расписания
                            break;
                        }
                    }
                }
            }
        }
        return 0;
    }
}
