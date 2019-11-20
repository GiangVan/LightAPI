<?php

Mapping::get('test', 'testController@index', 'TestModule')->middleware('Auth@check');
Mapping::get('welcome', 'HomeController@welcome', 'MyDayModule');

Mapping::get('day/update/with', 'Day/DayUpdateController@indexWith', 'MyDayModule')->middleware('Auth@check');
Mapping::get('day/update', 'Day/DayUpdateController@index', 'MyDayModule')->middleware('Auth@check');
Mapping::post('day/update', 'Day/DayUpdateController@update', 'MyDayModule')->middleware('Auth@check');

Mapping::get('statistic', 'Day/StatisticController@index', 'MyDayModule')->middleware('Auth@check');
Mapping::get('/', 'Day/StatisticController@index', 'MyDayModule')->middleware('Auth@check');