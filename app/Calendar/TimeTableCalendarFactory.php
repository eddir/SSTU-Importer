<?php

namespace App\Calendar;

use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Presentation\Component;
use Eluceo\iCal\Presentation\Component\Property;
use Eluceo\iCal\Presentation\Component\Property\Value\TextValue;
use Eluceo\iCal\Presentation\Factory\EventFactory;
use Eluceo\iCal\Presentation\Factory\TimeZoneFactory;
use Generator;

class TimeTableCalendarFactory
{
    private EventFactory $eventFactory;
    private TimeZoneFactory $timeZoneFactory;
    private string $calendarName;

    public function __construct(?EventFactory $eventFactory = null, ?TimeZoneFactory $timeZoneFactory = null, $calendarName = "")
    {
        $this->eventFactory = $eventFactory ?? new EventFactory();
        $this->timeZoneFactory = $timeZoneFactory ?? new TimeZoneFactory();
        $this->calendarName = $calendarName;
    }

    public function createCalendar(Calendar $calendar): Component
    {
        $components = $this->createCalendarComponents($calendar);
        $properties = iterator_to_array($this->getProperties($calendar), false);

        return new Component('VCALENDAR', $properties, $components);
    }

    /**
     * @return iterable<Component>
     */
    protected function createCalendarComponents(Calendar $calendar): iterable
    {
        yield from $this->eventFactory->createComponents($calendar->getEvents());
        yield from $this->timeZoneFactory->createComponents($calendar->getTimeZones());
    }

    /**
     * @return Generator<Property>
     */
    public function getProperties(Calendar $calendar): Generator
    {
        yield new Property('X-WR-CALNAME', new TextValue($this->calendarName));
        /* @see https://www.ietf.org/rfc/rfc5545.html#section-3.7.3 */
        yield new Property('PRODID', new TextValue('-//rasp-sstu.ru//v0.1//RU'));
        /* @see https://www.ietf.org/rfc/rfc5545.html#section-3.7.4 */
        yield new Property('VERSION', new TextValue('2.0'));
        /* @see https://www.ietf.org/rfc/rfc5545.html#section-3.7.1 */
        yield new Property('CALSCALE', new TextValue('GREGORIAN'));
    }
}