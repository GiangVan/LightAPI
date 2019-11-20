<?php

function existFileIncluded(string $path) : bool{
   $path = str_replace('\\', '/', $path);
    if(strlen($path) > 3 && substr($path, 0, 3) === '../')
    {
        $path = substr($path, 3);
    }
    $all_file_included = get_included_files();
    for($i = count($all_file_included) - 1; $i >= 0; $i--) 
    { 
        $all_file_included[$i] = str_replace('\\', '/', $all_file_included[$i]);
        if(strlen($all_file_included[$i]) >= strlen($path) && substr($all_file_included[$i], strlen($all_file_included[$i]) - strlen($path)) === $path)
        {
            return true;
        }
    }
    return false;
}

function requireFile(string $path) : bool{
    if(file_exists($path))
    {
        if(!existFileIncluded($path))
        {
            

            $awdawdjioawdjilfeawukghdhuksrfhbksdfhbmvcxawdfawgudawykdcvbcefshu = $path;
            call_user_func(function () use($awdawdjioawdjilfeawukghdhuksrfhbksdfhbmvcxawdfawgudawykdcvbcefshu){
                require($awdawdjioawdjilfeawukghdhuksrfhbksdfhbmvcxawdfawgudawykdcvbcefshu);
            });
        }
        return true;
    }
    else
    {
        return false;
    }
}