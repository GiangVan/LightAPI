<?php

class Configuration{
    private $configuration = [];

    public function add($key, $value){
        ErrorHandler::checkKeyType($key, 1);
        $this->configuration[$key] = $value;
    }
    public function addRange($array){
        ErrorHandler::checkArgType($array, 'array', 1, 1);
        foreach ($array as $key => $value) 
        {
            $this->configuration[$key] = $value;
        }
    }
    public function get($key){
        ErrorHandler::checkKeyType($key, 1);
        ErrorHandler::checkExistKeyValue($this->configuration, $key, 1);
        return $this->configuration[$key];
    }
    public function getAll() : array{
        return $this->configuration;
    }
}