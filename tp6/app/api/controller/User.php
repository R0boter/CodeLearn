<?php

declare(strict_types=1);

namespace app\api\controller;

use think\Request;
use think\exception\ValidateException;
use think\facade\Validate;

use app\model\User as UserModel;
use app\api\validate\User as UserValidate;

// 继承基础控制器，基础控制器中定义了返回的API数据结构，和分页和条数
class User extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        // 从数据库查询数据
        // $data = UserModel::field('id, username, gender, email')->select();
        // 传统分页查询 会返回总条数，分页数，分页条数，但无法通过请求来获取其他分页内容
        //$data = UserModel::field('id, username, gender, email')->paginate(5);
        // 分页
        $data = UserModel::field('id, username, gender, email')
            ->page($this->page, $this->pageSize)
            ->select('1111');


        // 判断 是否有值
        // select 没查找到数据返回的是一个空数组可以使用 isEmpty()判断
        if ($data->isEmpty()) {
            return $this->create($data, '数据不存在', 204);
        } else {
            return $this->create($data, '数据请求成功');
        }
        // 三元表达式方式返回
        // return $this->create($data, $data->isEmpty() ? '数据不存在' : '数据请求成功');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        // 获取数据
        $data = $request->param();

        // 验证返回
        try {
            // 使用助手函数validate()验证
            validate(UserValidate::class)->check($data);
        } catch (ValidateException $exception) {
            // 错误返回
            return $this->create([], $exception->getError(), 400);
        }

        // 密码加密
        $data['password'] = sha1($data['password']);

        // 写入数据库并返回写入的id
        $id = UserModel::create($data)->getData('id');

        if (empty($id)) {
            return $this->create([], '注册失败', 400);
        } else {
            return $this->create($id, '注册成功', 200);
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        // 当 id 传过来的值不是数值时，TP6 会自动处理不会报错 ，如果要捕获这种错误需要自己手动判断
        // 判断 id 是否为整型
        if (!Validate::isInteger($id)) {
            return $this->create([], 'ID参数不合法', 400);
        }

        $data = UserModel::field('id,username,email,gender')->find($id);

        // find 没查找到数据返回 null，只能使用 empty()判断
        if (empty($data)) {
            return $this->create([], '无数据', 204);
        } else {
            return $this->create($data, '数据查询成功', 200);
        }
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        // 获取数据
        $data = $request->param();
        // 验证返回
        try {
            // 使用助手函数validate()验证，修改可能只修改某一个字段，所有需要做场景验证
            validate(UserValidate::class)->scene('edit')->check($data);
        } catch (ValidateException $exception) {
            // 错误返回
            return $this->create([], $exception->getError(), 400);
        }
        // 邮箱修改时不可以和原邮箱一致
        $updateData = UserModel::find($id);
        if ($updateData->email === $data['email']) {
            return $this->create([], '修改的邮箱和原邮箱一致', 400);
        }
        // 修改
        $id = UserModel::update($data)->getData('id');

        if (empty($id)) {
            return $this->create([], '修改失败', 204);
        } else {
            return $this->create($id, '修改成功', 200);
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        // 当 id 传过来的值不是数值时，TP6 会自动处理不会报错 ，如果要捕获这种错误需要自己手动判断
        // 判断 id 是否为整型
        if (!Validate::isInteger($id)) {
            return $this->create([], 'ID参数不合法', 400);
        }
        // 当删除时，如果数据库中没有这个id会删除失败会产生错误，因此要捕获这个错误
        try {
            UserModel::find($id)->delete();
            return $this->create([], '删除成功', 200);
        } catch (\Error $e) {
            // \Error 和 use \Error 是一个效果，加个斜杠可以不写 use
            return $this->create([], '错误或无法删除', 400);
        }
    }

    public function hobby($id)
    {

        // 判断 id 是否为整型
        if (!Validate::isInteger($id)) {
            return $this->create([], 'ID参数不合法', 400);
        }

        // 喜好数据集
        $data = UserModel::find($id)->hobby()->field('id,hobby')->select();

        // select 没查找到数据返回的是一个空数组可以使用 isEmpty()判断
        if ($data->isEmpty()) {
            return $this->create($data, '数据不存在', 204);
        } else {
            return $this->create($data, '数据请求成功');
        }
    }

    public function login(Request $request)
    {
        $data = $request->param();


        // 验证用户密码
        $result = Validate::rule([
            // 验证规则：验证user表中username和password唯一性，
            // 如果传过来用户名和密码的是正确的，因为唯一性（数据库中对应字段的值不能相同）会返回false
            // 所以判断时需要取反
            'username' => 'unique:user,username^password'
        ])->check([
            'username' => $data['username'],
            'password' => sha1($data['password'])
        ]);
        if (!$result) {
            session('admin', $data['username']);
            return $this->create(true, '登录成功', 200);
        } else {
            return $this->create([], '用户名或密码错误', 400);
        }
    }
}
