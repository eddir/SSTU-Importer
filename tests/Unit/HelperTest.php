<?php

namespace Tests\Unit;

use App\Helpers\Helper;
use RuntimeException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Tests\mock\HtmlMock;

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

    public function test_that_get_html_from_url_returns_html()
    {
        Http::fake([
            "mock.com" => Http::response(HtmlMock::RAW_HTML)
        ]);

        $this->assertEquals("world", Helper::getHtmlFromURL("mock.com")->getElementById("world")->text());
    }

    public function test_that_get_html_handle_server_errors()
    {
        Http::fake([
            "mock.com" => Http::response("error", 500)
        ]);

        $this->expectException(RuntimeException::class);
        Helper::getHtmlFromURL("mock.com");
    }
}
