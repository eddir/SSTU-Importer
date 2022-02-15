<?php

namespace App\Helpers;

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
}