<?php

namespace Calendar;

use App\Calendar\TimeTable;
use App\Models\Group;
use App\Models\Hour;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TimeTableTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_that_migrations_pass_successfully()
    {
        $this->assertLessThan(Hour::all()->count(), 99);
    }

    public function test_get_events_return_right_count_of_events()
    {
        $events = TimeTable::getEvents(Group::all()->first());
        $this->assertIsArray($events);
        $this->assertCount(20, $events);
    }

    public function test_that_get_events_returns_events()
    {
        $events = TimeTable::getEvents(Group::all()->first());
        $this->assertInstanceOf("\Eluceo\iCal\Domain\Entity\Event", $events[0]);
        $this->assertNotEmpty($events[0]->getSummary());
    }

//    public function testGetTeacherEvents()
//    {
//
//    }
//
//    public function testAsEvents()
//    {
//
//    }
//
//    public function testGetAuditoryEvents()
//    {
//
//    }
}
