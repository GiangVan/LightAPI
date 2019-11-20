<?php

class ErrorMessage{
    
    protected static function _checkArgType(array $current_backtrace, ErrorParam $param) : string{
        $args_type = gettype($current_backtrace['args'][$param->arg_index - 1]);

        $function = self::getFunction($current_backtrace);
        $title = '<b>Error</b>: argument ' . $param->arg_index . ' passed to <b>' . $function . '</b> must be of the type ' . $param->arg_type . ' (given ' . $args_type . ').' . '<br>';

        return $title . self::getPath($current_backtrace);
    }

    protected static function _checkExistKeyValue(array $current_backtrace, ErrorParam $param) : string{
        $function = self::getFunction($current_backtrace);
        $title = '<b>Error</b>: not found data of the key = ' . $param->key_data . ' at ' . $function . '.<br>';
        
        return $title . self::getPath($current_backtrace);
    }

    protected static function _checkKeyType(array $current_backtrace, ErrorParam $param) : string{
        $function = self::getFunction($current_backtrace);
        $title = '<b>Error</b>: ' . $param->key_type . ' can not be used as keys at ' . $function . '.<br>';
        
        return $title . self::getPath($current_backtrace);
    }

    protected static function _wrongDataType(array $current_backtrace, ErrorParam $param) : string{
        $title = '<b>Error</b>: ' . "{$param->header} must is a/an {$param->data_type}";
        
        return $title . self::getPath($current_backtrace);
    }

    protected static function _echo(array $current_backtrace, ErrorParam $param) : string{
        $title = '<b>Error</b>: ' . $param->message . '.<br>';
        
        return $title . self::getPath($current_backtrace);
    }

    protected static function _echoNonPath(array $current_backtrace, ErrorParam $param) : string{
        $title = '<b>Error</b>: ' . $param->message . '.<br>';
        
        return $title;
    }

    protected static function _mappingEcho(array $current_backtrace, ErrorParam $param) : string{
        $title = '<b>Error</b>: ' . $param->message . '.<br>';
        
        return $title . ($param->trace === null ? self::getPath($current_backtrace) : self::getPath($current_backtrace, $param->trace->file, $param->trace->line));
    }

    protected static function _checkSupportedHttpMethod(array $current_backtrace) : string{
        $title = '<b>Error</b>: ' . 'http method is not supported' . '.<br>';
        
        return $title . self::getPath($current_backtrace);
    }

    protected static function _checkSupportedHttpMethodFunction(array $current_backtrace, ErrorParam $param) : string{
        $function = $param->function;
        $title = '<b>Error</b>: ' . "the <b>{$function}()</b> function not exist" . '.<br>';
        
        return $title . self::getPath($current_backtrace);
    }

    private static function getPath(array $current_backtrace, string $file = null, string $line = null) : string{
        $file = $file === null ? $current_backtrace['file'] : $file;
        $line = $line === null ? $current_backtrace['line'] : $line;
        return '<b>Called in</b>: ' . $file . ' (<b>line ' . $line . '</b>)' . '<br>' . '<br>';
    }   

    private static function getFunction(array $current_backtrace) : string{
        $class = isset($current_backtrace['class']) ? $current_backtrace['class'] . $current_backtrace['type'] : '';
        $function = '<b>' . $class . $current_backtrace['function'] . '()' . '</b>';
        return $function;
    }   
}