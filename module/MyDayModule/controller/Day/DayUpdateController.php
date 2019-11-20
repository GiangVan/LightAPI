<?php

class DayUpdateController{
    public function index(RoutingData $data){
        includeModel('MyDayModule', 'Day');
        includeModel('MyDayModule', 'Account');
        includeModel('MyDayModule', 'MyDateFormat');

        $day = Day::getDay($data->middleware['account_id']);
        $account = Account::getById($data->middleware['account_id']);
        $date = 'Hôm nay<br>' . MyDateFormat::getDayOfWeek() . ' ' . MyDateFormat::getToday();

        callView('MyDayModule', 'Day/editing', compact('day', 'account', 'date'));
    }

    public function indexWith(RoutingData $data){
        includeModel('MyDayModule', 'Day');
        includeModel('MyDayModule', 'Account');
        includeModel('MyDayModule', 'MyDateFormat');

        $dateFormat = new MyDateFormat($data->request['date'], 'd/m/Y');
        $day = Day::getDay($data->middleware['account_id'], $dateFormat->get());
        $account = Account::getById($data->middleware['account_id']);

        $date = ($dateFormat->get() === date('Y-m-d') ? 'Hôm nay<br>' : '') . $dateFormat->toDayOfWeek(). ' ' . $dateFormat->toDayMonth();
 
        callView('MyDayModule', 'Day/editing', compact('day', 'account', 'date'));
    }

    public function update(RoutingData $data){
        includeModel('MyDayModule', 'Day');

        $day = new Day($data->middleware['account_id'], $data->request['day_id']);
        $day->update($data->request, $data->middleware['account_id']);

        redirect('statistic');
    }
}