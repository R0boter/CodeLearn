<?php
// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

return [
    // 应用地址
    'app_host'         => env('app.host', ''),
    // 应用的命名空间
    'app_namespace'    => '',
    // 是否启用路由
    'with_route'       => true,
    // 默认应用
    'default_app'      => 'index',
    // 默认时区
    'default_timezone' => 'Asia/Shanghai',

    // 应用映射（自动多应用模式有效）
    'app_map'          => [],
    // 域名绑定（自动多应用模式有效）
    'domain_bind'      => [],
    // 禁止URL访问的应用列表（自动多应用模式有效）
    'deny_app_list'    => [],

    // 异常页面的模板文件
    'exception_tmpl'   => app()->getThinkPath() . 'tpl/think_exception.tpl',


    // 当无法使用 Error.php 或 Base.php中的 __call 方法捕获到的异常，可以使用下面配置捕获，并定义模板
    // 需要安装模板引擎
    // 'http_exception_template' => [
    //     // 定义404错误的模板文件地址
    //     404 => \think\facade\App::getAppPath() . '404.json',
    //     // 还可以定义其他的 HTTP  status
    //     401 => \think\facade\App::getAppPath() . '401.json',

    // ],

    // 错误显示信息,非调试模式有效
    'error_message'    => '页面错误！请稍后再试～',
    // 显示错误信息
    'show_error_msg'   => true,

    /******** 自定义配置，如果是多应用，可以在应用下的config文件夹下创建app.php为每个应用单独设置 **********/
    // 分页条数
    'page_size' => 5,
];
