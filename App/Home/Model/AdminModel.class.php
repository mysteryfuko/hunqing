<?php
// 用户模型
namespace Home\Model;
use Think\Model;
class AdminModel extends Model {

public function getAllTopic($class=1,$page1=0,$page2=5){
		$T = M("Topic");	
		$TopicData = $T->where('class=%d',$class)->order("addtime desc")->limit($page1.','.$page2)->select();
		foreach($TopicData as $key=>$values){
			$tmp = $this->getName($values[uid]);
			$TopicData[$key]['url'] = $tmp[url];
			$TopicData[$key]['name'] = $tmp[wechaname];
			//$TopicData[$key]['Pic'] = $this->getPic($values[id]);
			//$TopicData[$key]['count'] = $this->getPicCount($values[id]);
			$TopicData[$key]['addtime'] = date('m-d', $values[addtime]); //格式化时间戳
			//$TopicData[$key]['replay'] = $this->getReplay($values[id]);
			$TopicData[$key]['ReplayCount'] = $this->getReplayCount($values[id]);
			$TopicData[$key]['Praise'] = $this->getPraise($values[id]);
			//$TopicData[$key]['IsPraise'] = $this->getIsPraise($values[id],$_SESSION['id']);
		}
		return $TopicData; 
	}
	
	public function getName($id){
		$U = M('Userinfo');
		$UserData = $U->where('id=%d',$id)->find();
		if($UserData[url] == NULL){
			$UserData[url] = __ROOT__."/public/img/default.jpg";
		}
		return $UserData;
	}
	
	public function getReplayCount($id){
		$P = M('replay');
		$ReplayCount = $P->where('tid=%d',$id)->count();
		return $ReplayCount;
	}
	
	public function getPraise($id){
		$P = M('praise');
		$RraiseCount = $P->where('tid=%d',$id)->count();
		return $RraiseCount;
	}
}