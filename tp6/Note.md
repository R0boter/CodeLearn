## 准备工作

安装：`composer create-project topthink/think ./`

更新：`composer update topthink/framework`

安装模板引擎：`composer require topthink/think-view`

安装多应用支持：`composer require topthink/think-multi-app`

创建资源控制器：`php think make:controller User --api`

创建验证器：`php think make:validate User`

> 添加`--api`表示创建只应用于 API 的控制器，不添加则是创建普通控制器

> 资源控制器中默认提供了一些方法，这些方法配合资源路由，通过不同的请求方法，使访问更加简洁，具体查看 TP6 资源路由

设置数据库配置信息

## 基础设置

因为 API 返回的都是使用`Response::create()`创建的统一格式的数据，因此创建一个基础控制器`Base.php`来统一数据结构，API 所有返回的数据都以分页形式展示，因此在基础控制器中定义

默认的分页条数，这种很少变化的配置，可以放在`app.php`中，通过助手函数`config()`进行获取

## 错误捕获

数据是否存在，在接口文件`User.php`中直接捕获处理就可以了

控制器不存在错误，使用`Error.php`控制器捕获处理

方法不存在错误，在`Base.php`控制器中使用魔术方法`__call()`进行捕获处理

其他无法捕获的错误，在`app.php`中定义错误模板文件，进行处理

## 多应用

ThinkPHP6 安装后默认是单应用，要开启多应用模式需要先安装

安装多应用扩展后，如果目录结构还是单应用目录结构，还是会以单应用模式运行

多应用模式结构如下，`app_name`可以有多个：

```shell
www     Web 部署目录
|-app   应用目录
|  |-app_name   应用目录
|  |  |-common.php 函数文件
|  |  |-controller 控制器目录
|  |  |- model     模型目录
|  |  |- view      视图目录
|  |  |- config    配置目录
|  |  |- route     路由目录
|  |  |_...        更多类库目录
|  |
|  |-common.php     公共函数文件
|  |_event.php      事件定义文件

```

当建立多个应用目录后，建议每个应用的，配置，路由配置，视图模板，验证器都在各自的应用目录下配置，不使用公共的

如果多应用使用的同一个数据库，模型可以使用公共的

如果是单应用转为多应用，建议开启强制路由，在`config`下的`router.php`。**多应用下应注意以下事项**

1. 命名空间的修改，多应用比单应用多了一层目录
2. 强制路由下所有未定义的路由都会报错，可以通过每个应用下创建`config`文件夹，创建`app.php`文件，添加如下配置
   ```php
    return [
        // 异常页面的模板文件,将404.json放在当前应用目录下
        'exception_tmpl'   => \think\facade\App::getAppPath() . '404.json',
    ]
   ```
3. 如果不使用方法二，也可以在`route`文件夹下的`app.php`中添加`Route::miss(function(return "404 NOT FOUND!";))`，或者指定`MISS`路由`Route::miss('public/miss')`
4. 在各自应用目录下的设置，只能捕获到各自应用的路径下的路由错误，如果要捕获根域名下的路由错误还是要在公共配置文件中设置,也可以设置全局`app.conf`里面的异常模板文件，本来这里是`thinkphp`框架中的一个`tql`文件，如果修改后调试模式也不会报详细错误，适用于上线后
5. 在全局`config`下的`app.php`中的应用映射可以将应用名进行修改，如：将`admin`映射为`think`，映射后只能使用`think`访问`admin`应用
6. 在全局`config`下的`app.php`中的域名绑定可以将指定域名绑定到指定的应用上，因为默认使用`index`做为默认应用，所有解析到此服务器的域名默认都访问的是`index`，使用域名绑定为不同应用使用不同域名
7. 在域名绑定处，可以只写二级域名的前缀
