<?php

use App\Models\AppSetting;
use App\Models\Currency;
use Carbon\Carbon;

function DiligentCreators($appSettingName){
    return AppSetting::where('name', $appSettingName)->value('value');
}

function currency($currencyId, $fields = ['id', 'name', 'symbol']){
    $currency = Currency::find($currencyId);
    return $currency->getData($fields);
}

function getAllTimeZonesSelectBox($selectedValue)
{
	echo '<select name="site_timezone" class="form-control select2" id="site_timezone" required="required">';
	echo '<option value="">-- Select Time Zone --</option>';
	$tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
	foreach ($tzlist as $value) {
		$selected = ($value === $selectedValue) ? 'selected="selected"' : '';
		echo '<option value="' . $value . '" ' . $selected . '>' . $value . '</option>';
	}
	echo '</select>';
}

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