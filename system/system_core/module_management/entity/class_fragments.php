<?php

abstract class aClassFragments{
    public $option;
    public $class_name;
    public $module_path;
    public $method_name;
    public $class_path;
    public $trace;

    abstract public function __construct(ConfigurationPath $config, string $module_path = null);

    protected function do(ConfigurationPath $config) : string{
        $method_char = SystemConfig::get('METHOD_CHAR');
        $option_char = SystemConfig::get('OPTION_CHAR');
        $config_path = $config->path;
        $this->trace = $config->trace;
        //get & cut the option from $config_path
        if(stripos($config_path, $option_char) !== false)//  Login/NormalLoginController@return # print
        {
            $this->option = substr($config_path, stripos($config_path, $option_char) + 1);
            $config_path = substr($config_path, 0, stripos($config_path, $option_char));
        }
        else
        {
            $this->option = null;
        }
        //get & cut the method from $config_path
        if(stripos($config_path, $method_char) !== false)//  Login/NormalLoginController @ return
        {
            $this->method_name = substr($config_path, stripos($config_path, $method_char) + 1);
            $config_path = substr($config_path, 0, stripos($config_path, $method_char));
        }
        else
        {
            $this->method_name = null;
        }
        //get class name
        if(strrpos($config_path, '/') !== false)//  Login/ NormalLoginController
        {
            $this->class_name = substr($config_path, strrpos($config_path, '/') + 1);
        }
        else
        {
            $this->class_name = $config_path;
        }
        return $config_path;
    }
}

//ex: Login/NormalLoginController@return#print
class ControllerFragments extends aClassFragments{
    public function __construct(ConfigurationPath $config, string $module_path = null){
        $this->module_path = SystemConfig::get('MODULE_FOLDER') . $module_path;
        
        $config_path = parent::do($config);

        //get class path
        if(empty($module_path) && empty(str_replace(' ', '', $module_path)))
        {
            ErrorHandler::echo('not found module path of the ' . $this->class_name . 'controller');
        }
        else
        {
            $this->class_path = SystemConfig::get('DIRECTION_EXTENSION') . $this->module_path . '/' . SystemConfig::get('CONTROLLER_FOLDER') . $config_path . '.php';
        }
    }
}

//ex: Login/NormalLoginController@return#print
class MiddlewareFragments extends aClassFragments{
    public function __construct(ConfigurationPath $config, string $module_path = null){
        $config_path = parent::do($config);
        //get class path
        $this->class_path = SystemConfig::get('DIRECTION_EXTENSION') . SystemConfig::get('MIDDLEWARE_FOLDER') . $config_path . '.php';
    }
}