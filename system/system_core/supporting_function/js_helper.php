<?php

function jsGet(string $code) : string{
    return "<script>{$code}</script>";
}

function jsAlert(string $text, bool $is_exit = true){
    echo "<script>alert(`{$text}`)</script>";
    if($is_exit)
    {
        exit;
    }
}

function jsDo(string $text, bool $is_exit = true){
    echo jsGet($text);
    if($is_exit)
    {
        exit;
    }
}


