<?php

use think\facade\Route;
// 主页路由
Route::get('/','Index/index');

Route::get('index','Index/index');

Route::get('menu','Index/menu');

Route::get('clear', 'Index/clear');

Route::get('home','Index/home');

// 登录路由
Route::group(function(){
    Route::get('login','Login/index');
    Route::post('login','Login/check');
});

// 用户管理路由

Route::post('user','user/index');

Route::get('user/admin','user/admin');

Route::get('user/agent','user/agent');

Route::get('user/user','user/user');
