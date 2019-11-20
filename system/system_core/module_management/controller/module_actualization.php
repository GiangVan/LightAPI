<?php

abstract class aModuleActualization{
    abstract public static function actualize(aClassFragments $class_fs, RoutingData $routing_data) : RoutingData;

    protected static function includeClass(aClassFragments $class_fs){
        $result = requireFile($class_fs->class_path);

        ErrorHandler::mappingEcho(!$result, 'not found <b>' . $class_fs->class_name . '</b> class (' . $class_fs->class_path . ')', $class_fs->trace);
    }
    
    protected static function actualizeClass(aClassFragments $class_fs, RoutingData $routing_data) : array{
        $class_name = $class_fs->class_name;
        ErrorHandler::mappingEcho(!class_exists($class_name), 'not found <b>' . $class_name . "</b> class at " . $class_fs->class_path, $class_fs->trace);
        ErrorHandler::mappingEcho(!isset($class_fs->method_name) && !method_exists($class_name, '__construct'), 'you must specify the method for <b>' . $class_name . "</b> class (" . $class_fs->class_path . ')', $class_fs->trace);

        $method_name = isset($class_fs->method_name) ? $class_fs->method_name : null;
        $object = new $class_name($routing_data);
        if($method_name !== null)
        {
            ErrorHandler::mappingEcho(!method_exists($class_name, $method_name), 'not found the method <b>' . $method_name . '()</b> of <b>' . $class_name . '</b> class (' . $class_fs->class_path . ')', $class_fs->trace);
    
            $result = $object->$method_name($routing_data);
            if($class_fs->option === 'echo')
            {
                echo $result;
            }
            else if($class_fs->option !== null)
            {
                ErrorHandler::mappingEcho(true, 'wrong option (<b>' . SystemConfig::get('OPTION_CHAR') . $class_fs->option . '</b>) of class configuration: <b>' . $class_name . "</b> (" . $class_fs->class_path . ')', $class_fs->trace);
            }
            else if($class_fs->option === null)
            {
                if(!is_array($result))
                {
                    ErrorHandler::echoNonPath('return of your <b>method</b> of controller or middleware must be an array.<br>' . '<b>Called at method: </b>' . $method_name . '() of ' . $class_name . ' at ' . $class_fs->class_path); 
                }
            }
            return $result;
        }
        return [];
    }
}

class ControllerActualization extends aModuleActualization{
    public static function actualize(aClassFragments $class_fs, RoutingData $routing_data) : RoutingData{
        parent::includeClass($class_fs);

        $routing_data->module_path = $class_fs->module_path;
        $result = parent::actualizeClass($class_fs, $routing_data);
        foreach ($result as $key => $value) {
            $routing_data->controller[$key] = $value;
        }
        
        return $routing_data; 
    }
}

class MiddlewareActualization extends aModuleActualization{
    public static function actualize(aClassFragments $class_fs, RoutingData $routing_data) : RoutingData{
        parent::includeClass($class_fs);

        $result = parent::actualizeClass($class_fs, $routing_data);
        foreach ($result as $key => $value) {
            $routing_data->middleware[$key] = $value;
        }

        return $routing_data; 
    }
}

class TopMiddlewareActualization extends aModuleActualization{
    public static function actualize(aClassFragments $class_fs, RoutingData $routing_data) : RoutingData{
        parent::includeClass($class_fs);

        $result = parent::actualizeClass($class_fs, $routing_data);
        foreach ($result as $key => $value) {
            $routing_data->top_middleware[$key] = $value;
        }

        return $routing_data; 
    }
}
class BotMiddlewareActualization extends aModuleActualization{
    public static function actualize(aClassFragments $class_fs, RoutingData $routing_data) : RoutingData{
        parent::includeClass($class_fs);

        $routing_data->bot_middleware = parent::actualizeClass($class_fs, $routing_data);
        $result = parent::actualizeClass($class_fs, $routing_data);
        foreach ($result as $key => $value) {
            $routing_data->bot_middleware[$key] = $value;
        }

        return $routing_data; 
    }
}