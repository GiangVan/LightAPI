<?php

Mapping::get('register', 'RegisterController@index', 'AuthModule');
Mapping::post('register', 'RegisterController@register#echo', 'AuthModule');
Mapping::get('login', 'LogController@index', 'AuthModule');
Mapping::post('login', 'LogController@login#echo', 'AuthModule');
Mapping::get('logout', 'LogController@logout', 'AuthModule');