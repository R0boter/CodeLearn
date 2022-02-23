<?php

use think\facade\Route;

// 用户模块 资源路由
Route::resource('/', 'User');

// 一对多用户喜好
Route::get('user/:id/hobby', 'User/hobby');

// 登录路由
Route::post('login', 'User/login');
