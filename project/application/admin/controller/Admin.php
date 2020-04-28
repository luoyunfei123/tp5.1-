<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Db;
use think\Request;
use think\Session;
class Admin extends Controller
{
    
    public function index()
    {
       
        if (Session("uname") == null){
            $this->redirect("User/login");
        }
        return	$this->fetch("index");
    }

    
    public function qdapi ()
    {
        return	$this->fetch("qdapi");
    }
    public function modify_password ()
    {
        return	$this->fetch("modify_password");
    }
    public function iconfont ()
    {
        return	$this->fetch("iconfont");
    }
    public function agent_add ()
    {
        return	$this->fetch("agent_add");
    }

    
    public function agent_list ()
    {
        $res=Db::table('user')->select();
        $this->assign('info',$res);
        return	$this->fetch("agent_list");
    }
    
    public function specifications_list ()
    {
        return	$this->fetch("specifications_list");
    }
     
}
