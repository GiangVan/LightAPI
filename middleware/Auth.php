<?php

class Auth{
    public function check(RoutingData $data){
        if(isset($data->cookie['id'])){
            $result = DB::query('SELECT id FROM account WHERE id = :id', [':id' => $data->cookie['id']]);
            if(empty($result))
            {
                redirect('welcome');
            }
            else
            {
                return ['account_id' => $data->cookie['id']];
            }
        }
        else
        {
            redirect('welcome');
        }
    }
}