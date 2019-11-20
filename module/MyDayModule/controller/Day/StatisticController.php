<?php

class StatisticController{
    public function index(RoutingData $data){
        includeModel('MyDayModule', 'Account');
        includeModel('MyDayModule', 'Statistic');

        $account = Account::getById($data->middleware['account_id']);
        $lineCharts = Statistic::getLineCharts($data->middleware['account_id']);
        $doughnutCharts = Statistic::getDoughnutCharts($data->middleware['account_id']);
        $achievement = Statistic::getAchievement($data->middleware['account_id']);

        callView('MyDayModule', 'Day/statistic', compact('account', 'lineCharts', 'doughnutCharts', 'achievement'));
    }
}