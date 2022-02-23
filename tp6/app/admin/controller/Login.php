<?php
namespace app\admin\controller;

use think\facade\Validate;
use think\Request;

class Login
{
    public function index()
    {
        return view();
    }
    public function check(Request $request)
    {
        $data = $request->param();
        $error = '';

        // 验证
        $validate = Validate::rule([
            // unique表示指定匹配表中的指定字段的值，不能和传入的值一样。一样返回false，不一样返回true
            'username|用户名' => 'require|unique:admin,username^password',
            'password|密码' => 'require|min:6',
        ]);

        $result = $validate->check([
            // 规则里的键可以随便写，但验证里必须对应上规则里的键
            'username'=> $data['username'],
            'password' => sha1($data['password'])
        ]);

        // 规则里写的是判断在admin表中username和password字段的值是否和传过来的值一样，一样则表示值在两个字段中已经存在，则返回false
        // 两个值都存在，说明用户名和密码输入正确，所以这里用取反的方式，如果两个值有一个不存在，返回true，表示用户名或密码错误
        if($result){
            $error .= '用户名或密码错误!';
        }

        // 使用验证码一定要开启Session,TM的卡了半天
        if(!captcha_check($data['captcha'])){
            $error .= '验证码错误!';
        }

        // 利用 Ajax 传过来的 post 请求，返回需要数组格式的数据，所以定义返回的结果集
        $res = [
            //状态码
            'code' => empty($error)?1:0,
            // 消息
            'msg' => $error,
            // 数据
            'data' => $data
        ];

        return $res;


    }
}
