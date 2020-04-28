<?php
namespace app\index\controller;
use think\Controller;
use think\View;
use think\Db;
use think\Request;
class Index extends Controller
{
    public function index()
    {
         $data=Db::table('site')->limit(10)->select();
         $this->assign('info',$data);
     return	$this->fetch("index");
        

    }
}
