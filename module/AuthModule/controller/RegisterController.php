<?php

class RegisterController{
    public function index(){
        callView('AuthModule', 'registering');
    }

    public function register(RoutingData $data){
        if(isset($data->request['id']) && isset($data->request['name']) && !empty($data->request['name']) && !empty($data->request['id']))
        {
            $reuslt = DB::nonQuery("INSERT INTO account(id, `name`) VALUES (:id, :name)", [':id' => $data->request['id'], ':name' => $data->request['name']]);
            if($reuslt === false)
            {
                $returner = [
                    'notification' => jsGet('alert(`Tên tài khoản đã tồn tại! Vui lòng chọn tên khác`)'),
                    'id' => $data->request['id'],
                    'name' => $data->request['name']
                ];
                callView('AuthModule', 'registering', $returner);
            }
            else
            {
                setcookie('id', $data->request['id'], time() + (86400 * 90), '/');
                redirect('day/update');
            }
        }
        else
        {
            $returner = [
                'notification' => jsGet('alert(`Bạn chưa nhập tên tài khoản hoặc họ tên`)'),
                'id' => isset($data->request['id']) ? $data->request['id'] : '',
                'name' => isset($data->request['name']) ? $data->request['name'] : ''
            ];
            callView('AuthModule', 'registering', $returner);
        }
    }
}