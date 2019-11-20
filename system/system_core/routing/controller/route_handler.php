<?php

class RouteHandler{
    public static function start(FormattedURI $formatted_uri){
        $http_method = $_SERVER['REQUEST_METHOD'];
        RouteChecking::httpMethodSupported();
        
        $mapped_data_list = RouteMapping::getAllMappedData($http_method, $formatted_uri);
        RouteChecking::existMappedData($mapped_data_list);

        $routing_data = new RoutingData(RoutingData::getHttpMethodData($http_method));
        $routing_data = ModuleHandler::executeTopMiddleware(TopMiddlewareMapping::getAll($http_method), $routing_data);
        $routing_data = ModuleHandler::executeController($mapped_data_list, $routing_data);
        $routing_data = ModuleHandler::executeBotMiddleware(BotMiddlewareMapping::getAll($http_method), $routing_data);
    }

}