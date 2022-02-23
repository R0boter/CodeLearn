<?php

namespace app\api\controller;

// 创建一个错误类
class Error extends Base
{
    public function index()
    {
        // 当访问不存在的控制器时会自动调用错误类
        return $this->create([], "资源不存在", 404);
    }
}
