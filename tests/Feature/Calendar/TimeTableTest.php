<?php

namespace Calendar;

use App\Models\Hour;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TimeTableTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testGetGroupEvents()
    {
        dd(Hour::all()->last()->group->name);
        $this->assertLessThan(Hour::all()->count(), 10);
    }

    public function testGetTeacherEvents()
    {

    }

    public function testAsEvents()
    {

    }

    public function testGetAuditoryEvents()
    {

    }
}
