<?php

namespace Tests\Unit;

use App\Helpers\Helper;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_lessons_has_correct_time_set()
    {
        for ($i = 0; $i <= 8; $i++) {
            $this->assertLessThan(
                strtotime(Helper::getLessonEndTime($i)),
                strtotime(Helper::getLessonStartTime($i)));
        }
    }
}
