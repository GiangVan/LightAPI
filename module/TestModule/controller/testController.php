<?php

class testController{
    public function index(RoutingData $data)
    {
        dd(date('H', strtotime('15:00:00')));
    }

}