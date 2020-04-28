<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Db;
use think\Request;
use think\Session;
class User extends Controller
{
    
   
    public function login ()
    {
        return	$this->fetch("login");
    }
    public function loginuser ($name,$pass)
    {
        $user=Db::table('user')
                    ->where('name',$name)
                    ->where('pass',$pass)
                    ->find();
        if($user)
                {
                    session('uname',$name);
                    return json(1);
                }else{
                    return json(0);
                }
    }
    

    public function adduser ()
    {
        $request = Request::instance();
        $name=  Request::instance() -> param('name');
        $pass=  Request::instance() -> param('password');
        $phone= Request::instance() -> param('phone');
        $email= Request::instance() -> param('email');
        $dates= Request::instance() -> param('dates');
        $sql = array('name' => $name, 'pass' => $pass,'phone' => $phone, 'email' => $email,'dates' => $dates);
        $exc=Db::table('user')->insert($sql);
         if($exc){
            return json('ok');
            $this->success('添加成功！', 'Admin/agent_list');
         }else{
            $this->success('添加失败！', 'Admin/agent_add');
         }
    }

    public function delUser ()
    {
        $request = Request::instance();
        $id=  Request::instance() -> param('id');
        $del=Db::table('user')->delete($id);
        if($del){
            $this->success('删除成功！', 'Admin/agent_list');
         }else{
            $this->success('删除失败！', 'Admin/agent_add');
         }
    }
    
    public function loginout(){
        Session::clear();
        $this->redirect('User/login');
    }
}
