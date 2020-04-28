<?php
namespace app\Admin\controller;
use think\Controller;
use think\View;
use think\Db;
use think\Request;
use think\Session;
class Hezuo extends Controller
{
  
    public function hz_list ()
    {
    	$res=Db::table('site')->select();

        $this->assign('list',$res);

        return	$this->fetch("hz_list");

    }
    public function hz_add ()
    {
        return	$this->fetch("hz_add");
    }
    public function insert_form(Request $request){

        $file =$request->file('file');
        $data=$request->param();   
	    // 移动到框架应用根目录/public/uploads/ 目录下
	    if($file){

	        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');

	        $piclink=$info->getSaveName();//将图片的地址定义为$cover存进数据库

		    $data["logo"]=$piclink;

		    if(Db::table('site')->insert($data)){

		    	return $this->success("添加成功",'Hezuo/hz_list');

		    }else{

		    	return $this->error("添加失败",'Hezuo/hz_add');

		    }
	    }
	    
    }


     public function delHz ($num)
       {
            $imgs=Db::table('site')->find($num);

            $logo=$imgs["logo"];

            $result = substr($logo,0,strrpos($logo,"\\"));

            $result2 = substr($logo,strripos($logo,"\\")+1);

            $path=ROOT_PATH . 'public' . DS . 'uploads';

            $picurl=$path.'/'.$result.'/'.$result2;

            @unlink($picurl);

            $del=Db::table('site')->delete($num);

                if($del){

                    return json("0");

                }else{

                 return json("1");

                }     
            
            
       }

       public function editHz ($id)
       {

        $find=Db::table('site')->find($id);

        $num=$find["id"];

        $logo=$find["logo"];

        $sitename=$find["sitename"];

        $link=$find["sitelink"];

        $address=$find["address"];

        $this->assign('id',$num);

        $this->assign('logo',$logo);

        $this->assign('sitename',$sitename);

        $this->assign('sitelink',$link);

        $this->assign('address',$address);

        return  $this->fetch("editHz");
       } 
     
       public function update_info (Request $request)
       {

        $file =$request->file('file');

        $data=$request->param();  

        $id=$data["id"];
        
        $find=Db::table('site')->find($id);

            if($file){

            $logo=$find["logo"];

            $result = substr($logo,0,strrpos($logo,"\\"));

            $result2 = substr($logo,strripos($logo,"\\")+1);

            $path=ROOT_PATH . 'public' . DS . 'uploads';

            $picurl=$path.'/'.$result.'/'.$result2;

            @unlink($picurl);
            


            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');

            $piclink=$info->getSaveName();//将图片的地址定义为$cover存进数据库

            $data["logo"]=$piclink;

            $up=Db::table('site')->where('id', $id)->update($data);

            if($up){

                return $this->success("更新成功",'Hezuo/hz_list');

            }else{

                return $this->error("更新失败",'Hezuo/hz_list');

            }
        }    


        else{
            
            $up=Db::table('site')->where('id', $id)->update($data);

            if($up){

                return $this->success("更新成功",'Hezuo/hz_list');

            }else{

                return $this->error("更新失败",'Hezuo/hz_list');

            }
        } 
            
            
       }
   
}
