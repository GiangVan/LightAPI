<?php

class RoutingData{
    public $request;
    public $controller;
    public $middleware;
    public $module_path;
    public $top_middleware;
    public $bot_middleware;
    public $cookie;

    public function __construct(array $request, $controller = null, $middleware = null, $top_middleware = null, $bot_middleware = null){
        $this->request = $request;
        $this->cookie = $_COOKIE;
        $this->controller = $controller;
        $this->middleware = $middleware;
        $this->top_middleware = $top_middleware;
        $this->bot_middleware = $bot_middleware;
    }

    public static function getHttpMethodData(string $method) : array{
        if($method === 'POST')
        {
            return $_POST;
        }
        elseif($method === 'GET')
        {
            return $_GET;
        }
        else
        {
            ErrorHandler::echo('this http method not have any data', -1);
        }
    }
}