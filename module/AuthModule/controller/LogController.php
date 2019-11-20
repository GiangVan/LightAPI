<?php

class LogController{
    public function index(){
        callView('AuthModule', 'loginPage');
    }

    public function login(RoutingData $data){
        if(isset($data->request['id']) && !isEmpty($data->request['id'])){
            $result = DB::query('SELECT id FROM account WHERE id = :id', [':id' => $data->request['id']]);
            if(empty($result))
            {
                $returner = [
                    'notification' => jsGet('alert(`tên tài khoản chưa chính xác`)'),
                    'id' => $data->request['id']
                ];
                callView('AuthModule', 'loginPage', $returner);
            }
            else
            {
                setcookie('id', $data->request['id'], time() + (86400 * 90), '/');
                redirect('statistic');
            }
        }
        else
        {
            $returner = [
                    'notification' => jsGet('alert(`Bạn chưa nhập tên tài khoản`)'),
                    'id' => $data->request['id']
                ];
            callView('AuthModule', 'loginPage', $returner);
        }
    }

    public function logout(){
        setcookie("id", "", time() - 3600);
        redirect('welcome');
    }
}