<?php
function findPercent($miles)
{
    $max = 300;
    return number_format(100 - (($miles / $max) * 100), 2, '.', ',');
}

function fromObject($obj)
{
    return (is_object($obj)) ? json_decode(json_encode($obj), true) : $obj;
}

function generateToken()
{
    $len      = 50;
    $token    = NULL;
    $chars    = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $i        =    1;

    while ($i <= $len) {
        $token    .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        $i        += 1;
    }

    return $token;
}

function getKey($str)
{
    return str_replace(' ', '-', strtolower(urldecode(trim($str))));
}

function readCookie()
{
    return (isset($_COOKIE['token']) && ! empty($_COOKIE['token'])) ? $_COOKIE['token'] : null;
}

function writeCookie($token=null)
{
    if (empty($token) || strlen($token) != 50) {
        $token = readCookie();
        $token = (empty($token)) ? generateToken() : $token;
    }
    setcookie('token', $token, time() + (86400 * (365 * 10)), '/', '.' . $_SERVER['HTTP_HOST'], 0);
    return $token;
}