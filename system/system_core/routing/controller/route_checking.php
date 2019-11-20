<?php

class RouteChecking{
    public static function httpMethodSupported(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'GET')
        {
            ErrorHandler::echo('This HTTP Method is not supported', -1);
        }
    }

    public static function existMappedData(?array $mappedData){
        if($mappedData === null)
        {
            ErrorHandler::echo('This URI has not been configured', -1);
        }
    }
}