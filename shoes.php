<?php
include_once 'functions.php';
$shoes = array();
$term  = (isset($_GET['term'])) ? getKey($_GET['term']) : null;
$good  = (empty($term)) ? true : false;

if ($handle = opendir('db')) {
    while (false !== ($file = readdir($handle))) {
        if (stristr($file, '.json')) {
            $obj = json_decode(file_get_contents('db/' . $file));
            if (! empty($term)) {
                $good = (substr($file, 0, strlen($term)) == $term) ? true : false;
            }

            if ($good === true) {
                $shoe                      = $obj->shoe;
                $shoes[$shoe]              = array();
                $shoes[$shoe]['miles']     = $obj->miles;
                $shoes[$shoe]['key']       = getKey($shoe);
                $shoes[$shoe]['percent']   = findPercent($obj->miles);
                $shoes[$shoe]['file']      = 'db/' . $file;
                $shoes[$shoe]['value']     = $shoe;
                $shoes[$shoe]['label']     = $shoe;
            }
        }
    }
    closedir($handle);
}

if (! empty($term)) {
    print header('Content-Type: application/json');
    print json_encode(array_values($shoes));
}