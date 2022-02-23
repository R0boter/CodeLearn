<?php

namespace app\api\controller;


use think\facade\Request;

use think\Response;

abstract class Base
{
    protected $page;
    protected $pageSize;

    // 使用构造函数获取分页和条数
    public function __construct()
    {
        // 获取分页
        $this->page = (int)Request::param('page');
        // 获取条数 默认值在 app.php 中定义，通过助手函数config获取，也可以通过引入use think\facade\Config;使用Config类来获取
        $this->pageSize = (int)Request::param('page_size', config('app.page_size'));
    }
    protected function create($data, $msg = '', $code = 200, $type = 'json')
    {
        // 标准 API 结构生成
        $result = [
            //状态码
            'code' => $code,
            // 消息
            'msg' => $msg,
            // 数据
            'data' => $data
        ];
        // 返回 API 接口
        return Response::create($result, $type);
    }
    public function __call($name, $arguments)
    {
        // 捕获方法不存在时的错误
        return $this->create([], '方法不存在', 404);
    }
}
