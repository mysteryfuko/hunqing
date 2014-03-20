<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
	Public function _initialize(){
		$this->checkLogin();
	}
	protected function checkLogin() {
		if(!isset($_SESSION['id']) || $_SESSION['id']==''){
				$wecha_id = $_GET['wecha_id'];
				$token = $_GET['token'];
				$_SESSION['wecha_id'] = $wecha_id;
				$_SESSION['token'] = $token;
				$m = M('userinfo');
				if($token=='cantique'){
					$c = $m->where("wecha_id=\"%s\" AND token=\"%s\"",array($wecha_id,$token))->find();
					if($c){
						$_SESSION['id'] = $c[id];
					}
				}			
			}
	}
}
?>