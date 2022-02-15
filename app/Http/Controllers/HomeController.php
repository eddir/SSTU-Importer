<?php

namespace App\Http\Controllers;

use App\Calendar\TimeTableCalendarFactory;
use App\Helpers\Helper;
use App\Models\Group;
use Eluceo\iCal\Domain\ValueObject\Location;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\NoReturn;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\TimeSpan;
use Eluceo\iCal\Domain\Entity\Calendar;

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
     * Returns the iCall data for calendars like Google calendar.
     *
     * @param Group $group
     * @return Response
     */
    #[NoReturn] public function calendar(Group $group): Response
    {
        $hours = $group->hours()
            ->where('date', '>=', date("Y-m-d"))
            ->with('subject')
            ->with('type')
            ->get();

        $timezone = new \DateTimeZone('UTC');
        $location = new Location("Политехническая ул., 77, Главный к., Саратов, Саратовская обл., 410054");
        $events = [];

        foreach ($hours as $hour) {
            $events[] = (new Event())
                ->setSummary(sprintf("(%s) %s", $hour->type->short_name, $hour->subject->name))
                ->setLocation($location)
                ->setOccurrence(
                    new TimeSpan(
                        new DateTime(\DateTimeImmutable::createFromFormat('Y-m-d G:i',
                            $hour->date . " " . Helper::getLessonStartTime($hour->time)
                        )->setTimezone($timezone), false),
                        new DateTime(\DateTimeImmutable::createFromFormat('Y-m-d G:i',
                            $hour->date . " " . Helper::getLessonEndTime($hour->time)
                        )->setTimezone($timezone), false)
                    )
                );
        }

        $calendar = new Calendar($events);

        $componentFactory = new TimeTableCalendarFactory(null, null,
            "Расписание пар " . $group->name);
        $calendarComponent = $componentFactory->createCalendar($calendar);

        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="cal.ics"');

        return response($calendarComponent);
    }
}