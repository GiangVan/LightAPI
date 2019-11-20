<?php

class RoutingMappingTree{
    private $data;

    public function __set($name, $value){
        ErrorHandler::checkSupportedHttpMethod($name);
        ErrorHandler::wrongObjectDataType($value, 'ToRoutingURIMapping');
        $name = strtoupper($name);
        $this->data[$name] = $value;
    }

    public function __get($name){
        ErrorHandler::checkSupportedHttpMethod($name);
        $name = strtoupper($name);
        if(!isset($this->data[$name]))
        {
            $this->data[$name] = new ToRoutingURIMapping();
        }
        return $this->data[$name];
    }
}

class ToRoutingURIMapping{
    public $uri_mapping;

    public function __construct(){
        $this->uri_mapping = new RoutingURIMapping();
    }
}

class RoutingURIMapping implements ArrayAccess{
    private $container = [];

    public function push($key, $value){
        ErrorHandler::wrongDataKeyType($key, 'string');
        ErrorHandler::wrongObjectDataType($value, 'RoutingMappedData');
        pushArray($this->container[$key], $value);
    }

    public function offsetSet($key, $value){
        $class_name = 'RoutingMappedData';
        ErrorHandler::wrongDataKeyType($key, 'string');
        ErrorHandler::wrongDataValueType($value, 'array');
        $array = $value;
        if(empty($array))
        {
            ErrorHandler::echo("your data is not allowed empty");
        }
        else
        {
            foreach ($array as $k => $v) 
            {
                if(gettype($k) !== 'integer')
                {
                    ErrorHandler::echo("the key type of your array is not a integer type");
                }
                if(gettype($v) !== 'object' || get_class($v) !== $class_name)
                {
                    ErrorHandler::echo("the value type of your array is not a/an {$class_name} type");
                }
            }
            $this->container[$key] = $value;
        }
    }

    public function offsetExists($key){
        return isset($this->container[$key]);
    }

    public function offsetUnset($key){
        unset($this->container[$key]);
    }

    public function offsetGet($key){
        return isset($this->container[$key]) ? $this->container[$key] : null;
    }
}

class RoutingMappedData{
    private $string_var_list = 
    [
        'controller_config_path',
        'module_path'
    ];
    private $object_var_list = 
    [
        'extension'
    ];
    private $data;

    public function __construct(string $controller_config_path, string $module_path, RoutingMappedDataExtension $extension){
        $this->checkModulePath($module_path);

        $this->data['controller_config_path'] = $controller_config_path;
        $this->data['extension'] = $extension;
        $this->data['module_path'] = $module_path;
    }

    public function __set($name, $value){
        if($this->exist($name))
        {
            if(in_array($name, $this->string_var_list))
            {
                ErrorHandler::wrongDataType($value, 'string');
                if($name === 'module_path')
                {
                    $this->checkModulePath($value);
                }
                $this->data[$name] = $value;
            }
            else if($name === 'extension')
            {
                ErrorHandler::wrongObjectDataType($value, 'RoutingMappedDataExtension');
                if($name === 'module_path')
                {
                    $this->checkModulePath($value);
                }
                $this->data[$name] = $value;
            }
        }
        else
        {
            ErrorHandler::echo("the variable {$name} is not exist");
        }
    }

    public function __get($name){
        if($this->exist($name))
        {
            return $this->data[$name];
        }
        else
        {
            ErrorHandler::echo("the variable {$name} is not exist");
        }
    }

    private function exist(string $name){
        return in_array($name, $this->string_var_list) || in_array($name, $this->object_var_list);
    }

    private function checkModulePath(string $path){
        $path = SystemConfig::get('DIRECTION_EXTENSION') . SystemConfig::get('MODULE_FOLDER') . $path . '/';
        if(!file_exists($path))
        {
            ErrorHandler::echo("module_path <b>{$path}</b> not exist", 3);
        }

        $controller_path = $path . SystemConfig::get('CONTROLLER_FOLDER');
        if(!file_exists($controller_path))
        {
            ErrorHandler::echo("module <b>{$path}</b> must have a <u>controller folder</u>", 3);
        }
        $model_path = $path . SystemConfig::get('MODEL_FOLDER');
        if(!file_exists($model_path))
        {
            ErrorHandler::echo("module <b>{$path}</b> must have a <u>model folder</u>", 3);
        }
    }
}

class RoutingMappedDataExtension{
    private $middleware_config_path_list = [];
    private $trace;

    public function __construct(MappingTrace $trace, array $middleware_config_path_list = []){
        $this->trace = $trace;
        $this->middleware_config_path_list = $middleware_config_path_list;
    }

    public function pushMiddlewareConfigPathList(string $value){
        pushArray($this->middleware_config_path_list, $value);
    }

    public function getMiddlewareConfigPathList() : array{
        return $this->middleware_config_path_list;
    }

    public function getTrace() : MappingTrace{
        return $this->trace;
    }
}


