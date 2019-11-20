<?php

function dd($value, bool $is_not_exit = false) : string{
    $result = '<pre> ' . print_r($value, true);

    if($is_not_exit)
    {
        return $result;
    }
    else
    {
        exit($result);
    }
}

function dump($value){
    echo '<pre>';
    var_dump($value);
    exit;
}