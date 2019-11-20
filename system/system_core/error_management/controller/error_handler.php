<?php

class ErrorHandler extends ErrorDisplay{
    public static function checkArgType($var_checking, string $type, int $arg_index, int $backtrace_index = 0){
        if(parent::isDisplayError() && gettype($var_checking) !== $type)
        {
            $param = new ErrorParam();
            $param->arg_index = $arg_index;
            $param->arg_type = $type;
            self::throw($backtrace_index, $param, __FUNCTION__);
        }
    }

    public static function checkExistKeyValue($data, $key, int $backtrace_index = 0){
        if(parent::isDisplayError() && !isset($data[$key]))
        {
            $param = new ErrorParam();
            $param->key_data = $key;
            self::throw($backtrace_index, $param, __FUNCTION__);
        }
    }

    public static function checkKeyType($key, int $backtrace_index = 0){
        $key_type = gettype($key);
        if(parent::isDisplayError() && ($key_type === 'object' || $key_type === 'array'))
        {
            $param = new ErrorParam();
            $param->key_type = $key_type;
            self::throw($backtrace_index, $param, __FUNCTION__);
        }
    }

    public static function checkSupportedHttpMethod(string $method, int $backtrace_index = 0){
        if(parent::isDisplayError() && !http_method_is_supported($method))
        {
            self::throw($backtrace_index, null, __FUNCTION__);
        }
    }

    public static function checkSupportedHttpMethodFunction(string $method, int $backtrace_index = 0){
        if(parent::isDisplayError() && !http_method_is_supported($method))
        {
            $upped_method = strtoupper($method);
            if($upped_method === 'POST' || $upped_method === 'GET' || $upped_method === 'PUT' || $upped_method === 'PATCH' || $upped_method === 'DELETE')
            {
                self::throw($backtrace_index, null, 'checkSupportedHttpMethod');
            }
            else
            {
                $param = new ErrorParam();
                $param->function = $method;
                self::throw($backtrace_index, $param, __FUNCTION__);
            }
        }
    }

    public static function wrongObjectDataType($object_data, string $class_name, int $backtrace_index = 0){
        if(parent::isDisplayError() && gettype($object_data) !== 'object' && get_class($object_data) !== $class_name)
        {
            $param = new ErrorParam();
            $param->header = 'your data type';
            $param->data_type = $class_name;
            self::throw($backtrace_index, $param, 'wrongDataType');
        }
    }

    public static function wrongDataType($data, string $checking_type, int $backtrace_index = 0){
        if(parent::isDisplayError() && gettype($data) !== $checking_type)
        {
            $param = new ErrorParam();
            $param->header = 'your data type';
            $param->data_type = $checking_type;
            self::throw($backtrace_index, $param, 'wrongDataType');
        }
    }

    public static function wrongDataKeyType($key, string $checking_type, int $backtrace_index = 0){
        if(parent::isDisplayError() && gettype($key) !== $checking_type)
        {
            $param = new ErrorParam();
            $param->header = 'the key type of your data';
            $param->data_type = $checking_type;
            self::throw($backtrace_index, $param, 'wrongDataType');
        }
    }

    public static function wrongDataValueType($value, string $checking_type, int $backtrace_index = 0){
        if(parent::isDisplayError() && gettype($value) !== $checking_type)
        {
            $param = new ErrorParam();
            $param->header = 'the value type of your data';
            $param->data_type = $checking_type;
            self::throw($backtrace_index, $param, 'wrongDataType');
        }
    }

    public static function echo(string $message, int $backtrace_index = 0){
        if(parent::isDisplayError())
        {
            $param = new ErrorParam();
            $param->message = $message;
            self::throw($backtrace_index, $param, __FUNCTION__);
        }
        exit;
    }

    public static function echoNonPath(string $message){
        if(parent::isDisplayError())
        {
            $param = new ErrorParam();
            $param->message = $message;
            self::throw(-2, $param, __FUNCTION__);
        }
        exit;
    }

    public static function mappingEcho(bool $isThrow, string $message, MappingTrace $trace = null){
        if(parent::isDisplayError() && $isThrow)
        {
            $param = new ErrorParam();
            $param->message = $message;
            $param->trace = $trace;
            self::throw(0, $param, __FUNCTION__);
        }
    }

    private static function throw(int $backtrace_index, ?ErrorParam $param = null, $function = null){
        $backtrace_index += 2;
        $backtrace = debug_backtrace();
        echo parent::getDisplayString($backtrace, $backtrace_index, $param, $function);
        exit;
    }
}
