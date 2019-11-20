<?php

class ConfigurationPath{
    private $var_list = 
    [
        'path',
        'trace'
    ];
    private $data = [];

    public function __construct(MappingTrace $trace, string $config_path)
    {
        $this->set('trace', $trace);
        $this->set('path', $config_path);
    }

    public function __set($name, $value){
        if($this->exist($name))
        {
            $this->set($name, $value);
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

    private function set(string $key, $value){
        switch ($key) {
            case 'path':
                ErrorHandler::wrongDataType($value, 'string');
                break;
            case 'trace':
                ErrorHandler::wrongObjectDataType($value, 'MappingTrace');
                break;
        }
        $this->data[$key] = $value;
    }

    private function exist(string $name){
        return in_array($name, $this->var_list);
    }
}