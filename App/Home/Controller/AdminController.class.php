<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class AdminController extends Controller {
	Public function _initialize(){
		$this->checkLogin();
	}
	
	public function index(){
		$C = M('class');
		$data = $C->select();
		$this->assign('data',$data);
		$this->display();
		$_SESSION['AdClass'] = 1;
	}
	
	public function editClass(){
		$data = Init_GP(array('id','name'));
		$M = M('class');
		$data[logo] = $_POST['logo'];
		$M->save($data);
		$this->redirect('index');
	}
	
	public function AddClassDo(){
		$data = Init_GP(array('id','name'));
		$M = M('class');
		$data[logo] = $_POST['logo'];
		$M->add($data);
		$this->redirect('index');
	}

	public function DelReplay(){
		$id = $_POST['id'];
		$replay = M('replay');
		$replay->delete($id);
	}
	public function show(){
		$data = Init_GP(array('id'));
		$D = D('index');
		$ShowData = $D->getTopic($data['id']);
		//var_dump($ShowData);
		$this->assign('Topic',$ShowData);
		$this->display();
	}
	
	public function TopicList(){
		$D = D('Admin');
		$C = M('class');
		$list = $C->select();		
		$User = M('Topic'); 
		$count = $User->where('class=%d',$_SESSION['AdClass'])->count();// 查询满足要求的总记录数
		$Page = new \Think\Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数(6)
		$show = $Page->show();// 分页显示输出
		$data = $D->getAllTopic($_SESSION['AdClass'],$Page->firstRow,$Page->listRows);
		//var_dump($data);
		$this->assign('page',$show);
		$this->assign('data',$data);
		$this->assign('list',$list);
		$this->display();
	}
	
	public function DelTopic(){
		$id = $_POST['id'];
		$topic = M('topic');
		$topic->delete($id);
		$pic = M('topicpic');
		$pic->where('tid=%d',$id)->delete();
		$replay = M('replay');
		$replay->where('tid=%d',$id)->delete();
	}
	public function ChangeClass(){
		$id = $_POST['id'];
		$_SESSION['AdClass'] = $id;		
	}
	
	public function AddClass(){		
		$M = M('class');
		$id = $M->count();
		echo ($id+1);
	}
	
	protected function checkLogin() {
		if(!isset($_SESSION['AdminId']) || $_SESSION['AdminId']==''){
				$this->redirect('Login/index');
			}
	}	
}