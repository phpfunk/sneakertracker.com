<?php
include_once 'functions.php';
$token = writeCookie();
$shoe  = urldecode(trim($_POST['shoe']));
$miles = urldecode(trim($_POST['miles']));
$file  = 'db/' . $token . '.json';

$arr = array();
$c_key = getKey($shoe);
if (file_exists($file)) {
    $shoes = json_decode(file_get_contents($file));
    foreach ($shoes as $key => $obj) {
        $arr[$key] = fromObject($obj);
    }
}

if (isset($arr[$c_key])) {
    $arr[$c_key]['miles'] += $miles;
    $arr[$c_key]['percent'] = findPercent($arr[$c_key]['miles']);
}
else {
    $arr[$c_key] = array();
    $arr[$c_key]['key'] = $c_key;
    $arr[$c_key]['shoe'] = $shoe;
    $arr[$c_key]['miles'] = $miles;
    $arr[$c_key]['percent'] = findPercent($miles);
}

ksort($arr);

$json = json_encode($arr, JSON_FORCE_OBJECT);
file_put_contents($file, $json);
print header('Content-Type: application/json');
print json_encode($arr[$c_key]);