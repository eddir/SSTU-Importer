<?php

namespace App\Http\Controllers;

use App\Calendar\TimeTable;
use App\Calendar\TimeTableCalendarFactory;
use App\Models\Group;
use App\Models\Teacher;
use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Domain\Entity\Event;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index(): Response
    {
        return response("Hello");
    }

    /**
     * Выводит календарь в формате iCall с расписанием группы
     *
     * @param Group $group
     * @param string $format
     * @return Response
     */
    public function groupCalendar(Group $group, string $format = TimeTable::TITLE_FORMAT_DEFAULT): Response
    {
        $title = "Расписание пар " . $group->name;
        return $this->printCalendar(TimeTable::getGroupEvents($group, $format), $title);
    }

    /**
     * Создание и вывод календаря из массива событий
     *
     * @param Event[] $events массив событий
     * @param string $title название календаря
     * @return Response
     */
    private function printCalendar(iterable $events, string $title): Response
    {
        $calendar = new Calendar($events);

        $componentFactory = new TimeTableCalendarFactory(null, null, $title);
        $calendarComponent = $componentFactory->createCalendar($calendar);

        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="cal.ics"');

        return response($calendarComponent);
    }

    /**
     * Выводит календарь в формате iCall с расписанием преподавателя
     *
     * @param Teacher $teacher
     * @param string $format
     * @return Response
     */
    public function teacherCalendar(Teacher $teacher, string $format = TimeTable::TITLE_FORMAT_DEFAULT): Response
    {
        $title = "Расписание пар " . $teacher->name;
        return $this->printCalendar(TimeTable::getTeacherEvents($teacher, $format), $title);
    }
}