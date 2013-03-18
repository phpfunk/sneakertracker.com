<?php
function findPercent($miles)
{
    $max = 300;
    return number_format(100 - (($miles / $max) * 100), 2, '.', ',');
}

function getKey($str)
{
    return str_replace(' ', '-', strtolower(urldecode(trim($str))));
}