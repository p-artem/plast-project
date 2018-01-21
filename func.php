<?php

function dump($data, $die = false){
    ob_start();
    var_dump($data);
    $output = ob_get_clean();
    $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
    echo '<pre>'.($output).'</pre>';
    if ($die){
        exit;
    }
    return false;
}

function dd($data, $die = true){
    echo '<pre>'.print_r($data, true).'</pre>';
    if ($die){
        exit;
    }
    return false;
}