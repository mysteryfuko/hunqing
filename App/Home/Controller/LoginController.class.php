<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {	
	public function index(){
		$this->display();
	}
	
	public function code(){
		$Verify = new \Think\Verify();
		$Verify->imageH = 30;
		$Verify->fontSize = 15;
		$Verify->entry();
	}
	
	public function AdminDoLogin(){
	$data = Init_GP(array('username','password','code'));
	$m = M('admin');
	$user= $data[username];
	$password = md5($data[password]);
	$verify = new \Think\Verify();
	if( $verify->check($data[code], '') ){
	$data = $m->where("user=\"%s\" AND password=\"%s\"",array($user,$password))->find();
	
		if($data){
			$_SESSION['AdminId']="1";
			$this->success('登录成功', __MODULE__.'/admin/index');
			}else{
			$this->error($password);
			}
	}else{
		$this->error('验证码错误');
		}
	}

	
}