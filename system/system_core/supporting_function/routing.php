<?php

function callView(string $module_path, string $view_name, array $params = null){
    $path = SystemConfig::get('DIRECTION_EXTENSION') . SystemConfig::get('MODULE_FOLDER') . $module_path . '/' . SystemConfig::get('VIEW_FOLDER') . $view_name . '.php';
    if(file_exists($path))
    {
        $awkdhaukwhvcxvhkuwhaduhckhzxbvukawhgukfghlnmbiouopioyttrybcvertkuhvcblixchuiyhewsiougbvxchvgiyo = $path;
        $awduefxcnbvpoiqweopiuqeroioeiuryzxcnmbekurghweiyugousdfghsjkdgfweiucghxiersugbndkiurgfnhdkfuygedfiku = $params;
        call_user_func(function() use ($awduefxcnbvpoiqweopiuqeroioeiuryzxcnmbekurghweiyugousdfghsjkdgfweiucghxiersugbndkiurgfnhdkfuygedfiku, $awkdhaukwhvcxvhkuwhaduhckhzxbvukawhgukfghlnmbiouopioyttrybcvertkuhvcblixchuiyhewsiougbvxchvgiyo){
            if($awduefxcnbvpoiqweopiuqeroioeiuryzxcnmbekurghweiyugousdfghsjkdgfweiucghxiersugbndkiurgfnhdkfuygedfiku !== null){
                foreach ($awduefxcnbvpoiqweopiuqeroioeiuryzxcnmbekurghweiyugousdfghsjkdgfweiucghxiersugbndkiurgfnhdkfuygedfiku as $key => $value) 
                {
                    ${$key} = $value;
                }
            }
            require($awkdhaukwhvcxvhkuwhaduhckhzxbvukawhgukfghlnmbiouopioyttrybcvertkuhvcblixchuiyhewsiougbvxchvgiyo);
        });
    }
    else
    {
        ErrorHandler::echo('not found the view at <b>' . $path . '</b>');
    }
    exit;
}

function includeModel(string $module_path, string $model_name){
    $path = '../' . SystemConfig::get('MODULE_FOLDER') . $module_path . '/' . SystemConfig::get('MODEL_FOLDER') . $model_name . '.php';
    $result = requireFile($path);
    if(!$result)
    {
        ErrorHandler::echo('not found the file: ' . $path);
    }
}

function callController( string $module_path, string $config_path, RoutingData $data) : RoutingData{
    return ModuleHandler::executeAController($module_path, $config_path, $data, new MappingTrace(1));
}

function http_method_is_supported(string $method) : bool{
    $method = strtoupper($method);
    return in_array($method, SystemConfig::get('SUPPORTED_HTTP_METHOD'));
}

//return the base url or url + uri if you set it
function url(string $uri = null) : string{
    return $uri === null ? $_SERVER['HTTP_HOST'] . '/' : $_SERVER['HTTP_HOST'] . '/' . $uri;
}

function redirect(string $uri){
    if(substr($uri, 0, 1) !== '/')
    {
        $uri = '/' . $uri;
    }
    exit("<script>window.location.href = `{$uri}`;</script>");
}
