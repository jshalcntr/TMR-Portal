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
        return date("F d, Y", strtotime($date));
    }
    return date("F d, Y", strtotime($date));
}

function convertToPhp($integer)
{
    return "Php " . number_format($integer, 2);
}
