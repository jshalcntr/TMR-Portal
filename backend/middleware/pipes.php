<?php
function convertToDate($date)
{
    if ($date == "0000-00-00" || $date == null) {
        return date("Y-m-d", strtotime("0000-00-00"));
    } else {
        return date("Y-m-d", strtotime($date));
    }
}

function convertToReadableDate($date)
{
    if ($date == "0000-00-00" || $date == null) {
        return "No Date Recorded Yet";
    } else {
        return date("M d, Y", strtotime($date));
    }
    return date("M d, Y", strtotime($date));
}
function convertFromReadableDate($date)
{
    $date = DateTime::createFromFormat("M d, Y", $date);
    return $date->format("Y-m-d");
}

function convertToPhp($integer)
{
    return "Php " . number_format($integer, 2);
}

function convertFromPhp($amount)
{
    return (float) str_replace(array('Php ', ','), '', $amount);
}
