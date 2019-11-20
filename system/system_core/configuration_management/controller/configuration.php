<?php

class GlobalConfig{
    private static $conf;
    private static function check(){
        if(self::$conf === null)
        {
            self::$conf = new Configuration();
        }
    }
    
    public static function add($key, $value){
        self::check();
        self::$conf->add($key, $value);
    }
    public static function addRange($array){
        self::check();
        self::$conf->addRange($array);
    }
    public static function get($key){
        self::check();
        return self::$conf->get($key);
    }
    public static function getAll() : array{
        self::check();
        return self::$conf->getAll($key);
    }
}

class SystemConfig{
    private static $conf;
    private static function check(){
        if(self::$conf === null)
        {
            self::$conf = new Configuration();
        }
    }
    
    public static function add($key, $value){
        self::check();
        self::$conf->add($key, $value);
    }
    public static function addRange($array){
        self::check();
        self::$conf->addRange($array);
    }
    public static function get($key){
        self::check();
        return self::$conf->get($key);
    }
    public static function getAll() : array{
        self::check();
        return self::$conf->getAll($key);
    }
}