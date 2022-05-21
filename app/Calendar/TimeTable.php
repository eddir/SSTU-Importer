<?php

namespace App\Calendar;

use App\Helpers\Helper;
use App\Models\Auditory;
use App\Models\Group;
use App\Models\Teacher;
use DateTimeImmutable;
use DateTimeZone;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\Location;
use Eluceo\iCal\Domain\ValueObject\TimeSpan;
use Illuminate\Database\Eloquent\Collection;

class TimeTable
{
    private const LOCATION = "Политехническая ул., 77, Главный к., Саратов, Саратовская обл., 410054";
    public const TITLE_FORMAT_DEFAULT = '(%type%) %auditory% %title%';

    /**
     * Список будущих пар группы
     *
     * @param Group $group
     * @param string $format
     * @return iterable
     */
    public static function getGroupEvents(Group $group, string $format = self::TITLE_FORMAT_DEFAULT): iterable
    {
        return self::asEvents($group->hours()
            ->where('date', '>=', date("Y-m-d"))
            ->with('auditory', 'subject', 'type', 'group', 'teacher')
            ->get(), $format
        );
    }

    /**
     * Преобразовать пары в события календаря
     *
     * @param Collection $hours
     * @param string $format
     * @return iterable
     */
    public static function asEvents(Collection $hours, string $format = self::TITLE_FORMAT_DEFAULT): iterable
    {
        $timezone = new DateTimeZone('UTC');
        $location = new Location(self::LOCATION);
        $events = [];

        foreach ($hours as $hour) {
            $events[] = (new Event())
                ->setSummary(str_replace(
                    ['%type%', '%type_full%', '%auditory%', '%title%', '%group%', '%teacher%'],
                    [$hour->type->short_name, $hour->type->full_name, $hour->auditory->name, $hour->subject->name,
                        $hour->group->name, $hour->teacher->name],
                    $format))
                ->setLocation($location)
                ->setOccurrence(
                    new TimeSpan(
                        new DateTime(DateTimeImmutable::createFromFormat('Y-m-d G:i',
                            $hour->date . " " . Helper::getLessonStartTime($hour->time)
                        )->setTimezone($timezone), false),
                        new DateTime(DateTimeImmutable::createFromFormat('Y-m-d G:i',
                            $hour->date . " " . Helper::getLessonEndTime($hour->time)
                        )->setTimezone($timezone), false)
                    ))
                ->setDescription(str_replace(
                    ['%type%', '%type_full%', '%auditory%', '%title%', '%group%', '%teacher%'],
                    [$hour->type->short_name, $hour->type->full_name, $hour->auditory->name, $hour->subject->name,
                        $hour->group->name, $hour->teacher->name],
                    "%type_full%\nГруппа: %group%\nПреподаватель: %teacher%\nАудитория: %auditory%"
                ));
        }

        return $events;
    }

    /**
     * Список будущих пар преподавателя
     *
     * @param Teacher $teacher
     * @param string $format
     * @return iterable
     */
    public static function getTeacherEvents(Teacher $teacher, string $format = self::TITLE_FORMAT_DEFAULT): iterable
    {
        //TODO: а может сделать один общий метод и принимать на вход Scheduleable?
        return self::asEvents($teacher->hours()
            ->where('date', '>=', date("Y-m-d"))
            ->with('auditory', 'subject', 'type', 'group', 'teacher')
            ->get(), $format
        );
    }

    /**
     * Список будущих пар в указанной аудитории
     *
     * @param Teacher $teacher
     * @param string $format
     * @return iterable
     */
    public static function getAuditoryEvents(Auditory $auditory, string $format = self::TITLE_FORMAT_DEFAULT): iterable
    {
        return self::asEvents($auditory->hours()
            ->where('date', '>=', date("Y-m-d"))
            ->with('auditory', 'subject', 'type', 'group', 'teacher')
            ->get(), $format
        );
    }
}