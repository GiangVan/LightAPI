<?php

class SpecialMiddlewareMapping{
    private $mapper = [];

    public function set(string $name, string $value){
        pushArray($this->mapper[$name], new ConfigurationPath(new MappingTrace(3), $value));
    }

    public function getAll(string $method) : array{
        if(isset($this->mapper['ALL']))//push data of 'all' to data of this method 
        {
            for ($i=0; $i < count($this->mapper['ALL']); $i++) { 
                pushArray($this->mapper[$method], $this->mapper['ALL'][$i]);
            }
        }
        if(!isset($this->mapper[$method]))
        {
            $this->mapper[$method] = [];
        }
        return $this->mapper[$method];
    }
}

class TopMiddlewareMapping{
    private static $special_middleware_mapping;

    public static function __callStatic($name, $arguments)
    {
        $upped_name = strtoupper($name);
        if($upped_name === 'ALL')
        {
            ErrorHandler::checkArgType($arguments[0], 'string', 1);
            self::set($upped_name, $arguments[0]);
        }
        else
        {
            ErrorHandler::checkSupportedHttpMethodFunction($name);
            ErrorHandler::checkArgType($arguments[0], 'string', 1);
            self::set($upped_name, $arguments[0]);
        }
    }

    private static function check(){
        if(!isset(self::$special_middleware_mapping))
        {
            self::$special_middleware_mapping = new SpecialMiddlewareMapping();
        }
    }

    private static function set($key, $value){
        self::check();
        self::$special_middleware_mapping->set($key, $value);
    }

    public static function getAll(string $method) : array{
        self::check();
        return self::$special_middleware_mapping->getAll($method);
    }
}

class BotMiddlewareMapping{
    private static $special_middleware_mapping;

    public static function __callStatic($name, $arguments)
    {
        $upped_name = strtoupper($name);
        if($upped_name === 'ALL')
        {
            ErrorHandler::checkArgType($arguments[0], 'string', 1);
            self::set($upped_name, $arguments[0]);
        }
        else
        {
            ErrorHandler::checkSupportedHttpMethodFunction($name);
            ErrorHandler::checkArgType($arguments[0], 'string', 1);
            self::set($upped_name, $arguments[0]);
        }
    }

    private static function check(){
        if(!isset(self::$special_middleware_mapping))
        {
            self::$special_middleware_mapping = new SpecialMiddlewareMapping();
        }
    }

    private static function set($key, $value){
        self::check();
        self::$special_middleware_mapping->set($key, $value);
    }

    public static function getAll(string $method) : array{
        self::check();
        return self::$special_middleware_mapping->getAll($method);
    }
}

class TopMiddleware extends TopMiddlewareMapping{}
class BotMiddleware extends BotMiddlewareMapping{}