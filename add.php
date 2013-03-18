<?php
include_once 'functions.php';
$shoe  = urldecode(trim($_POST['shoe']));
$miles = urldecode(trim($_POST['miles']));
$file  = 'db/' . str_replace(' ', '-', strtolower($shoe)) . '.json';

if (file_exists($file)) {
    $obj   = json_decode(file_get_contents($file));
    $miles = $obj->miles + $miles;
}

$json = json_encode(array(
    'shoe'     => $shoe,
    'key'      => getKey($shoe),
    'miles'    => $miles,
    'percent'  => findPercent($miles)
));

file_put_contents($file, $json);

print header('Content-Type: application/json');
print $json;