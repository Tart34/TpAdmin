<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/21
 * Time: 19:22
 */

namespace app\admin\controller;
use app\admin\model\AuthRule;
use think\controller;
use think\Request;
use app\common\controller\common;
class Menus extends Base
{
    protected $common;
    private $authRule;
    public function __construct(Request $request = null)
    {
        //实例化菜单模型
        $this->authRule = new AuthRule();
        $this->common = new common();
        parent::__construct($request);
    }

    /**
     * @author by 张超 <Email:416716328@qq.com web:http://www.zhangchao.name>
     * @name 菜单列表
     * @version 1.0.0
     * @funName menusList
     * @return  Obj
     */
    public function menusList(){
        //菜单列表
        return $this->fetch();
    }

    /**
     * @author by 张超 <Email:416716328@qq.com web:http://www.zhangchao.name>
     * @name 获取菜单列表
     * @version 1.0.0
     * @funName getMenusList
     * @return  Obj
     */
    public function getMenusList(){
        //条件搜索
        $result = $this->authRule->getMenusList(input("get.page"),config("ADMIN_LIMIT"),input("get.ismenu"),input("get.isshow"),input("get.name"));
        if ($result){
            $list = $this->common->menusList($result['list']);
            $this->common->LayuiAjaxSuccess(200,"数据获取成功！",$list,$result['count']);
        }else{
            $this->common->ajaxError(400,"我是有底线的喔！");
        }
    }

    /**
     * @author by 张超 <Email:416716328@qq.com web:http://www.zhangchao.name>
     * @name 左侧菜单列表
     * @version 1.0.0
     * @funName leftMenus
     * @return  Obj
     */
    public function leftMenus(){

    }

    /**
     * @author by 张超 <Email:416716328@qq.com web:http://www.zhangchao.name>
     * @name 添加后台菜单
     * @version 1.0.0
     * @param title 标题
     * @param action 方法名
     * @param controller 控制器名
     * @param ismenu 是否菜单 1是 2否
     * @param isshow 是否显示 1显示 2隐藏
     * @funName addMenus
     * @return  Obj
     */
    public function addMenus(){
        if ($this->request->isPost()){
            $post = input("post.");
            $data = json_decode($post['data'],true);
            $result = $this->authRule->addMenus($data);
            if ($result){
                $this->common->ajaxSuccess(200,"添加菜单成功！");
            }else{
                $this->common->ajaxError(400,"菜单添加失败！");
            }
        }else{
            $path = Request::instance()->input("get.path");
            if ($path){
                $this->assign("path",$path);
            }
            return $this->fetch();
        }
    }

    /**
     * @author by 张超 <Email:416716328@qq.com web:http://www.zhangchao.name>
     * @name 修改菜单
     * @version 1.0.0
     * @funName updateMenus
     * @return  Obj
     */
    public function updateMenus(){
        if ($this->request->isPost()){
            $menus = new AuthRule();
            $result = $menus->allowField(true)->save(Request::instance()->param(),input("post.id"));
            if ($result){
                $this->common->ajaxSuccess(200,"已切换状态");
            }else{
                $this->common->ajaxError(400,"操作失败了哟");
            }
        }else{
            $this->fetch();
        }
    }
}