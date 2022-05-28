<?php

use App\Models\Group;
use App\Models\Hour;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class HourTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testHourCompareToThemself()
    {

        $hours = Hour::factory()->create(['group_id' => Group::factory()->create()->id]);
        $this->assertTrue($hours->compareTo($hours));
    }


}