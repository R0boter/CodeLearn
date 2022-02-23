<?php /*a:1:{s:78:"C:\Users\Falcon\Desktop\phpEnv\www\api.tp6.com\app\admin\view\login\index.html";i:1601208518;}*/ ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>富豪博彩-后台登陆</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="Access-Control-Allow-Origin" content="*" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, maximum-scale=1"
    />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="format-detection" content="telephone=no" />
    <link rel="stylesheet" href="/static/admin/lib/layui-v2.5.5/css/layui.css">
    <link rel="stylesheet" href="/static/admin/css/login.css">
  </head>
  <body>
    <div class="main-body">
      <div class="login-main">
        <div class="login-top">
          <span>富豪博彩   后台登录</span>
          <span class="bg1"></span>
          <span class="bg2"></span>
        </div>
        <form class="layui-form login-bottom">
          <div class="center">
            <div class="item">
              <span class="icon icon-2"></span>
              <input
                type="text"
                name="username"
                lay-verify="required"
                placeholder="请输入登录账号"
                maxlength="24"
              />
            </div>

            <div class="item">
              <span class="icon icon-3"></span>
              <input
                type="password"
                name="password"
                lay-verify="required"
                placeholder="请输入密码"
                maxlength="20"
              />
              <span class="bind-password icon icon-4"></span>
            </div>

            <div id="validatePanel" class="item" style="width: 137px">
              <input
                type="text"
                name="captcha"
                placeholder="请输入验证码"
                maxlength="4"
              />
              <label id="refreshCaptcha" class="validateImg"
                ><?php echo captcha_img(); ?></label
              >
            </div>
          </div>
          <div
            class="layui-form-item"
            style="text-align: center; width: 100%; height: 100%; margin: 0px"
          >
            <button class="login-btn" lay-submit="" lay-filter="login">
              立即登录
            </button>
          </div>
        </form>
      </div>
    </div>
    <div class="footer">
      ©版权所有 2014-2018 纯粹网络工作室<span class="padding-5">|</span><a target="_blank" href="#">粤ICP备16006642号-2</a>
    </div>

    <script src="/static/admin/lib/layui-v2.5.5/layui.js"></script>
    <script>
      layui.use(['form','jquery'], function () {
          var $ = layui.jquery,
              form = layui.form,
              layer = layui.layer;
          // 登录过期的时候，跳出ifram框架
          if (top.location != self.location) top.location = self.location;
          $('.bind-password').on('click', function () {
              if ($(this).hasClass('icon-5')) {
                  $(this).removeClass('icon-5');
                  $("input[name='password']").attr('type', 'password');
              } else {
                  $(this).addClass('icon-5');
                  $("input[name='password']").attr('type', 'text');
              }
          });
          // 进行登录操作
          form.on('submit(login)', function (data) {

              data = data.field;
              if (data.username == '') {
                  layer.msg('用户名不能为空');
                  return false;
              }
              if (data.password == '') {
                  layer.msg('密码不能为空');
                  return false;
              }
              if (data.captcha == '') {
                  layer.msg('验证码不能为空');
                  return false;
              }
              $.ajax({
                  url:'login',
                  method:'post',
                  data:data,
                  dataType:'JSON',
                  success:function(res){
                      if(res.code == 0){
                          layer.msg(res.msg);
                          }
                      else{
                          layer.msg('登录成功', function () {
                            window.location = 'index';
                          })
                      }
                  },
                  error:function () {
                    layer.msg('系统错误！请刷新后再试！')
                  }
              }) ;
              return false; // 用于阻止表单跳转的
          });
      });
    </script>
  </body>
</html>
