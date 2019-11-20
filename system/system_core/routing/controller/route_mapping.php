<?php

class MiddlewareMapping{
    private $method, $uri, $index;

    public function __construct(string $method, string $uri, int $index){
        $this->method = $method;
        $this->uri = $uri;
        $this->index = $index;
    }

    public function middleware(string $config_path) : MiddlewareMapping{
        ErrorHandler::checkArgType($config_path, 'string', 1);
        return RouteMapping::mapMiddleware($this->method, $this->uri, $this->index, $config_path);
    }
}

class RouteMapping{
    private static $mapper;

    // public static function getMapper() : ?RoutingMappingTree{
    //     return self::$mapper;
    // }
    
    public static function getAllMappedData(string $method, FormattedURI $formatted_uri) : ?array{
        return self::$mapper->$method->uri_mapping[$formatted_uri->uri];
    }

    public static function getMiddlewareList(string $method, string $uri, int $index) : array{
        return self::$mapper->$method->uri_mapping[$uri][$index]->extension->getMiddlewareConfigPathList();
    }

    public static function __callStatic($name, $arguments)
    {
        ErrorHandler::checkSupportedHttpMethodFunction($name);
        ErrorHandler::checkArgType($arguments[0], 'string', 1);
        ErrorHandler::checkArgType($arguments[1], 'string', 2);
        ErrorHandler::checkArgType($arguments[2], 'string', 3);
        return self::mapController($name, $arguments[0], $arguments[1], $arguments[2]);
    }
    private static function mapController(string $method, string $uri, string $config_path, string $module_path) : MiddlewareMapping{
        self::checkMapper();
        $routing_mapped_data_extension = new RoutingMappedDataExtension(new MappingTrace(2));
        self::$mapper->$method->uri_mapping->push($uri, new RoutingMappedData($config_path, $module_path, $routing_mapped_data_extension));
        return new MiddlewareMapping($method, $uri, count(self::$mapper->$method->uri_mapping[$uri]) - 1);
    }

    public static function mapMiddleware(string $method, string $uri, int $index, string $config_path) : MiddlewareMapping{
        self::checkMapper();
        self::$mapper->$method->uri_mapping[$uri][$index]->extension->pushMiddlewareConfigPathList($config_path);
        return new MiddlewareMapping($method, $uri, $index);
    }

    private static function checkMapper(){
        if(!isset(self::$mapper))
        {
            self::$mapper = new RoutingMappingTree();
        }
    }
}

class Mapping extends RouteMapping{}