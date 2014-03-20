<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
	$D = D('index');
	$class = Init_GP(array('class'));
	$_SESSION['class'] = $class['class'];
	$C = M('class');
	$tmp = $C->where('id=%d',$class['class'])->find();
	$_SESSION['classname'] = $tmp['name'];
	$_SESSION['logo'] = $tmp['logo'];//获取板块名字及logo保存在session中用于前台显示
	
	$data = $D->getAllTopic($class['class']);

	//var_dump($data);
	
	$this->assign('Topic',$data);
	$this->display();
    }
	
	public function PushNew()
	{
		if(!isset($_SESSION['id'])){
			redirect('http://wxapi.weicehua.net/index.php?g=Wap&m=Card&a=get_card&token='.$_SESSION['token'].'&wecha_id='.$_SESSION['wecha_id']);
		}
		$this->display();
	}
	
	public function showdetail(){
		$data = Init_GP(array('tid'));
		$D = D('index');
		$ShowData = $D->getTopic($data['tid']);
		//var_dump($ShowData);
		$this->assign('Topic',$ShowData);
		$this->display();
	}
	public function ajaxAdd(){
		$data = Init_GP(array('img','userid','class1','content','thumbimg'));
		$D = D('index');
		$D->save($data);		 
	}
	
	public function successdo(){
		header("Content-type: text/html; charset=utf-8");
		redirect(__APP__.'/Home/index/index/class/'.$_SESSION['class'], 3, '发布成功...');
	}
	
	public function ajaxreplay(){
		$data = Init_GP(array('tid','uid','rid','cont'));
		$D = D('index');
		$Replaydata = $D->AddReplay($data,18);
		foreach($Replaydata as $values){
			$cont .='<li><img src="'.$values[url].'" class="sImg db fl" width="25" height="25" alt="头像"><a href="javascript:;" author="'.$values[name1].'" tid="'.$data[tid].'" uid="'.$values[uid].'" class="sW fl"><span>'.$values[name].'：</span>
							'.$values[content].'</a></li>';
		}
		echo $cont;
	}
	
	public function ajaxreplay1(){
		$data = Init_GP(array('tid','uid','rid','cont'));
		$D = D('index');
		$Replaydata = $D->AddReplay($data,21);
		foreach($Replaydata as $values){
			$cont .='<li><img src="'.$values[url].'" class="sImg db fl" width="25" height="25" alt="头像"><a href="javascript:;" author="'.$values[name1].'" tid="'.$data[tid].'" uid="'.$values[uid].'" class="sW fl"><span>'.$values[name].'：</span>
							'.$values[content].'</a></li>';
		}
		echo $cont;
	}
	
	public function ajaxPraise(){
		$data = Init_GP(array('tid'));
		$D = D('index');
		$D->PushPraise($_SESSION['id'],$data[tid]);
		
		echo $D->getPraise($data[tid]);
	}
	
	public function ajaxloadreplay(){
		$data = Init_GP(array('tid'));
		$D = D('index');
		$show = $D->getReplay($data[tid],18);
		foreach($show as $values){
			$cont .='<li><img src="'.$values[url].'" class="sImg db fl" width="25" height="25" alt="头像"><a href="javascript:;" author="'.$values[name1].'" tid="'.$data[tid].'" uid="'.$values[uid].'" class="sW fl"><span>'.$values[name].'：</span>
							'.$values[content].'</a></li>';
		}
		echo $cont;
	}
	
	public function ajaxloadreplay1(){
		$data = Init_GP(array('tid','page'));
		$D = D('index');
		$show = $D->getReplay($data[tid],18,$data[page]);
		foreach($show as $values){
			$cont .='<li><img src="'.$values[url].'" class="sImg db fl" width="25" height="25" alt="头像"><a href="javascript:;" author="'.$values[name1].'" tid="'.$data[tid].'" uid="'.$values[uid].'" class="sW fl"><span>'.$values[name].'：</span>
							'.$values[content].'</a></li>';
		}
		echo $cont;
	}
	
	public function ajaxload($page=1){
		$data1 = Init_GP(array('class','page'));
		$D = D('index');
		$data = $D->getAllTopic($data1['class'],$data1['page']);//分页获取数据
		foreach($data as $values){
			$content .=' <div class="topicBox">
				<div class="topicCon pd15">
					<p class="personImgDate">
						<span class="perImg db">
							<img src="'.$values[url].'" class="bImg" width="38" height="38" alt="头像">
							<i class=""></i>
							<span class="timeT">'.$values[name].'<i>'.$values[addtime].'</i></span>
						</p>
						<div class="detailCon">
							<p>
							'.$values[content].'
							</p>
							<div class="slideBox">
								<div class="slideBoxWrapper" style="position:relative;">
								<ul>';
			foreach($values[Pic] as $values1){
				$content .='<li><a href="'.$values1[url].'"><img src="'.$values1[thumb_url].'"></a></li>';
				}
			$content .='</ul>
						</div>
						<span class="pageNum db" style="top:5px;right:3px;display:none;">'.$values['count'].'张</span>
						</div>
						<span class="replyShare db fr">
							<a href="javascript:;" class="like" tId="'.$values['id'].'"><i class="';
						if($values['IsPraise']){
							$content .='praise';
						}else{
							$content .='noPraise';
						}
						$content .='"></i>'.$values['Praise'].'</a>
						<a href="javascript:;" class="threadReply" tId="'.$values['id'].'"><i class="incoR spr"></i>回复</a>
						</span>
					</div>
				</div>
				<div class="topicList">
					<ul id="replyList_'.$values['id'].'">';
			foreach($values[replay] as $values2){
				$content .='<li><img src="'.$values2['url'].'" class="sImg db fl" width="25" height="25" alt="头像"><a href="javascript:;" author="'.$values2['name1'].'" tid="'.$values['id'].'" uid="'.$values2['uid'].'" class="sW fl"><span>'.$values2['name'].'：</span>
				'.$values2['content'].'</a></li>';	
			}
			$content .='</ul>';
			if($values[ReplayCount] > 5){
			$content .='<p class="more" tid="'.$values['id'].'" rCount="'.$values['ReplayCount'].'" style="display:block"><a href="javascript:;" title="">更多</a>共'.$values[ReplayCount].'条回复</p>';
			}
			$content .='</div>
			</div>
			<script type="text/javascript">
			$(".slideBox").each(function() {
				var f = $(this).find("li");
				var c = 0;
				for (var b = 0; b < f.length; b++) {
					c += $(f[b]).width()
				}
				if ($(this).width() < c) {
					$(this).find(".pageNum").show()
				}
			});
			</script>';
		}
		echo $content;
	}
	
	public function ajaxUpload(){		
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath  =      '/bbs/'.$_SESSION['class']."/"; // 设置附件上传目录
		// 上传文件 
		$info   =   $upload->uploadOne($_FILES['uploadFile']);//upload();
		if(!$info) {// 上传错误提示错误信息
			$this->error($upload->getError());
		}else{// 上传成功
			echo json_encode($info);
			//生存缩影图
			$image = new \Think\Image();
			$image->open("..".__ROOT__."/uploads".$info[savepath].$info[savename]);
			$image->thumb(150, 150)->save("..".__ROOT__."/uploads".$info[savepath].'/thumb_'.$info[savename]);

		}
		//var_dump($_FILES['photo']);
	}
}