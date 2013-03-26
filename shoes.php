<?php
include_once 'functions.php';
$token = writeCookie();
$file  = 'db/' . $token . '.json';
$shoes = array();
$term  = (isset($_GET['term'])) ? $_GET['term'] : null;
$good  = (empty($term)) ? true : false;

if (file_exists($file)) {
    $shuze = json_decode(file_get_contents($file));
    foreach ($shuze as $key => $obj) {
        if (substr($obj->shoe, 0, strlen($term)) == $term || ! isset($_GET['term'])) {
            $shoe                      = $obj->shoe;
            $shoes[$shoe]              = array();
            $shoes[$shoe]['miles']     = $obj->miles;
            $shoes[$shoe]['key']       = $key;
            $shoes[$shoe]['percent']   = findPercent($obj->miles);
            $shoes[$shoe]['file']      = $file;
            $shoes[$shoe]['value']     = $shoe;
            $shoes[$shoe]['label']     = $shoe;
        }
    }
}

if (! empty($term)) {
    print header('Content-Type: application/json');
    print json_encode(array_values($shoes));
}