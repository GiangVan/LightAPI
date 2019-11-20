<?php

function pushArray(&$array, $value){
    if(is_array($array))
    {
        array_push($array, $value);
    }
    else
    {
        $array = [$value];
    }
}

function getPushingArray($array, $value) : array{
    pushArray($array, $value);
    return $array;
}

