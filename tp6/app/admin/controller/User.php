<?php
namespace app\admin\controller;

use app\model\Admin;

class User
{
    public function index()
    {
        $result = [
            'code' => 0,
            'msg' => '',
            'count' => 1,
            'data' => [
                [
                    "id" =>  10000,
                    "username" =>  "user-0",
                    "sex" =>  "女",
                    "city" =>  "城市-0",
                    "sign" =>  "签名-0",
                    "experience" =>  255,
                    "logins" =>  24,
                    "wealth" =>  82830700,
                    "classify" =>  "作家",
                    "score" =>  57
                ]
            ]
                ];
        return $result;

    }
    public function admin()
    {
        return view();
    }

    public function user()
    {

        return view();
    }

    public function agent()
    {
        return view();
    }

}
