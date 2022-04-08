<?php

namespace App\appLogic;

use phpDocumentor\Reflection\Types\Array_;

class TimeLogic
{
    public static function getArrivalTime($departureTime, $travelTime): ?string
    {
        $travelTimeNumbers = self::getNumbers($travelTime);
        if($travelTimeNumbers[0] == 0 && $travelTimeNumbers[1] == 0)
        {
            return null;
        }
        $departureTimeNumbers = self::getNumbersFromDepartureTime($departureTime);

        $hours = $travelTimeNumbers[0] + $departureTimeNumbers[0];
        $minutes = $travelTimeNumbers[1] + $departureTimeNumbers[1];
        $minutesToHours = self::minutesToHours($minutes);
        $hours += $minutesToHours[0];
        $minutes = $minutesToHours[1];
        $minutes = strval($minutes);
        if(strlen($minutes) == 1)
        {
            $minutes = '0' . $minutes;
        }
        $nextDay = '';
        if($hours >= 24)
        {
            $hours = $hours%24;
            $nextDay = ' one day later';
        }

        return $hours . ':' . $minutes . $nextDay;
    }

    private static function getNumbersFromDepartureTime($departureTime)
    {
        return explode(':', $departureTime);
    }


    public static function addTime($timesList)
    {
        // jeśli w danym kursie nie ma podanego czasu, to sumuje czas bez niego (ostatni return w getNumbers())

        $hours = 0;
        $minutes = 0;
        foreach($timesList as $time)
        {
            $numbers = self::getNumbers($time);
            $hours += $numbers[0];
            $minutes += $numbers[1];
        }

        $minutesToHours = self::minutesToHours($minutes);
        $hours += $minutesToHours[0];
        $minutes = $minutesToHours[1];
        return [$hours . ' godz. ' . $minutes . 'min'];
    }

    public static function createTimeFromHoursAndMinutes($hours, $minutes)
    {
        if($hours != '')
        {
            $travelTime = $hours.' godz.';
            if($minutes != '')
            {
                $travelTime .= ' '.$minutes.' min';
            }
            return $travelTime;
        }
        if($minutes != '')
        {
            return $minutes.' min';
        }
        return '';
    }

    public static function getNumbers($time): array
    {
        preg_match_all('/[0-9]+/', $time, $matches);
        if(str_contains($time, 'godz.'))
        {
            $hours = $matches[0][0];
            if(str_contains($time, 'min'))
            {
                $minutes = $matches[0][1];
                return [$hours, $minutes];
            }
            return [$hours, 0];
        }
        if(str_contains($time, 'min'))
        {
            $minutes = $matches[0][0];
            return [0, $minutes];
        }
        return [0,0];
    }

    private static function minutesToHours($minutes): array
    {
        return [floor($minutes/60), $minutes%60];
    }
}
