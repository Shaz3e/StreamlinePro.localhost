<?php

use Carbon\Carbon;

function calcTime($startTime, $endTime)
{
    $start_time = Carbon::parse($startTime);
    $complete_time = Carbon::parse($endTime);

    $time_diff = $complete_time->diff($start_time);

    if ($time_diff->days > 0) {
        $days = $time_diff->format('%d');
        $hours = $time_diff->format('%h');
        $minutes = $time_diff->format('%i');
        return "$days days $hours hrs $minutes minutes";
    } elseif ($time_diff->hours > 0) {
        $hours = $time_diff->format('%h');
        $minutes = $time_diff->format('%i');
        return "$hours hrs $minutes minutes";
    } else {
        $minutes = $time_diff->format('%i');
        return "$minutes minutes";
    }
}

function currencyFormat($value)
{
    return number_format($value,2);
}