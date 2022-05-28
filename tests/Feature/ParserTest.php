<?php

use App\Helpers\Parser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Http;
use Tests\mock\HtmlMock;
use Tests\TestCase;

class ParserTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testParseGroupFindsGroups()
    {
        Http::fake([
            "rasp.sstu.ru" => Http::response(HtmlMock::SSTU_HOMEPAGE_HTML)
        ]);

        $groups = Parser::parseGroups(\App\Helpers\Helper::getHtmlFromURL("rasp.sstu.ru"));
        $this->assertCount(19, $groups);
        $this->assertEquals("б-АТПП-11", $groups[0]->name);
        $this->assertEquals("Институт машиностроения, материаловедения и транспорта", $groups[0]->faculty);
        $this->assertEquals("303", $groups[0]->url);
    }

}