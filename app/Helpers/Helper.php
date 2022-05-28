<?php

namespace App\Helpers;

use RuntimeException;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Collection;
use voku\helper\HtmlDomParser;

class Helper
{
    public static function getLessonStartTime(int $number): string
    {
        return match ($number) {
            2 => "9:45",
            3 => "11:30",
            4 => "13:40",
            5 => "15:20",
            6 => "17:00",
            7 => "18:40",
            8 => "20:20",
            default => "8:00",
        };
    }

    public static function getLessonEndTime(int $number): string
    {
        return match ($number) {
            2 => "11:15",
            3 => "13:00",
            4 => "15:10",
            5 => "16:50",
            6 => "18:30",
            7 => "20:10",
            8 => "21:50",
            default => "9:30",
        };
    }

    public static function getHtmlFromURL($url): HtmlDomParser
    {
//        $address = match ($url) {
//            "https://rasp.sstu.ru/rasp/department/0" => "/var/www/rasp.rostkov.pro/public/3.html",
//            "https://rasp.sstu.ru/rasp/room/0" => "/var/www/rasp.rostkov.pro/public/4.html",
//        };
//        return HtmlDomParser::str_get_html(file_get_contents($address));

        $response = Http::get($url);

        if ($response->failed()) {
            throw new RuntimeException($response->reason());
        }

        return HtmlDomParser::str_get_html($response->body());
    }
}