<?php

class ModuleHandler{
    public static function executeController(array $mapped_data_list, RoutingData $routing_data) : RoutingData{
        for ($i=0; $i < count($mapped_data_list); $i++) {
            ErrorHandler::wrongObjectDataType($mapped_data_list[$i], 'RoutingMappedData');
            $trace = $mapped_data_list[$i]->extension->getTrace();
            $routing_data = self::executeMiddleware($mapped_data_list[$i]->extension->getMiddlewareConfigPathList(), $trace, $routing_data);
            $configuration_path = new ConfigurationPath($trace, $mapped_data_list[$i]->controller_config_path);
            $routing_data = ControllerActualization::actualize(new ControllerFragments($configuration_path, $mapped_data_list[$i]->module_path), $routing_data);
        }
        return $routing_data;
    }

    public static function executeTopMiddleware(array $config_list, RoutingData $routing_data) : RoutingData{
        for ($i=0; $i < count($config_list); $i++) {
            ErrorHandler::wrongObjectDataType($config_list[$i], 'ConfigurationPath');
            $routing_data = TopMiddlewareActualization::actualize(new MiddlewareFragments($config_list[$i]), $routing_data);
        }
        return $routing_data;
    }

    public static function executeBotMiddleware(array $config_list, RoutingData $routing_data) : RoutingData{
        for ($i=0; $i < count($config_list); $i++) {
            ErrorHandler::wrongObjectDataType($config_list[$i], 'ConfigurationPath');
            $routing_data = BotMiddlewareActualization::actualize(new MiddlewareFragments($config_list[$i]), $routing_data);
        }
        return $routing_data;
    }

    private static function executeMiddleware(array $config_list, MappingTrace $trace, RoutingData $routing_data) : RoutingData{
        for ($i=0; $i < count($config_list); $i++) {
            $configuration_path = new ConfigurationPath($trace, $config_list[$i]);
            $routing_data = MiddlewareActualization::actualize(new MiddlewareFragments($configuration_path), $routing_data);
        }
        return $routing_data;
    }

    public static function executeAController(string $module_path, string $config_path, RoutingData $routing_data, MappingTrace $trace) : RoutingData{
        $configuration_path = new ConfigurationPath($trace, $config_path);
        return ControllerActualization::actualize(new ControllerFragments($configuration_path, $module_path), $routing_data);
    }
}