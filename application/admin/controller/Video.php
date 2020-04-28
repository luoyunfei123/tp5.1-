<?php
namespace app\Admin\controller;
use think\Controller;
use think\View;
use think\Db;
use think\Request;
use think\Session;
class Video extends Controller
{
  
    public function V_list ()
    {
    	$res=Db::table('video')->select();
        $this->assign('list',$res);
        return	$this->fetch("v_list");

    }
    public function V_add ()
    {
        return	$this->fetch("v_add");
    }
    public function insert_form_video(Request $request){

        $file =$request->file('file');
        
        $data=$request->param();   
	    // 移动到框架应用根目录/public/uploads/ 目录下
	    if($file){
            
                $info = $file->move(ROOT_PATH . 'public' . DS . 'vedios');

                $piclink=$info->getSaveName();//将视频的地址定义为$cover存进数据库
    
                $data["source"]=$piclink;
    
                if(Db::table('video')->insert($data)){
    
                    return $this->success("添加成功",'Video/V_list');
    
                }else{
    
                    return $this->error("添加失败",'Video/V_add');
    
                } 
            
            
	       
	    }
	    
    }


     public function delVedio ($num)
       {
            $imgs=Db::table('video')->find($num);

            $logo=$imgs["source"];

            $result = substr($logo,0,strrpos($logo,"\\"));

            $result2 = substr($logo,strripos($logo,"\\")+1);

            $path=ROOT_PATH . 'public' . DS . 'videos';

            $picurl=$path.'/'.$result.'/'.$result2;

            @unlink($picurl);

            $del=Db::table('video')->delete($num);

                if($del){

                    return json("0");

                }else{

                 return json("1");

                }     
            
            
       }

      
            
            
       
   
}
