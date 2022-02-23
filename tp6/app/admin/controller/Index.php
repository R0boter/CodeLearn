<?php
namespace app\admin\controller;

use think\facade\Db;

class Index
{
    public function index()
    {
        return view();
    }
    public function home()
    {
        return view();
    }
    public function menu()
    {
        $homeInfo = [
            "title" =>  "首页",
            "href" =>  "home"
        ];

        $logoInfo = [
            "title" =>  "富豪博彩",
            "image" =>  "/static/admin/images/logo.png",
            "href" =>  ""
        ];

        $menuInfo = $this->getMenuInfo();

        $result = [
            'homeInfo' => $homeInfo,
            'logoInfo' => $logoInfo,
            'menuInfo' => $menuInfo
        ];

        return  json($result);
    }

    private function getMenuInfo()
    {
        $menuList = Db::name('menu')
            ->field('id,pid,title,icon,href,target')
            ->select();

        $menuList = $this->buildMenuChild(0,$menuList);


        return $menuList;

    }

    private function buildMenuChild($pid,$menuList)
    {

        $treeList = [];
        foreach($menuList as $v){
            if($pid == $v['pid']){
                $node = $v;
                $child = $this->buildMenuChild($v['id'],$menuList);
                if(!empty($child)){

                    $node['child'] = $child;
                }

                $treeList[] = $node;
            }
        }
        return $treeList;

    }
    public function clear()
    {
        $clear = [
            "code" => 1,
            "msg" => "服务端清理缓存成功"
        ];
    }
}
