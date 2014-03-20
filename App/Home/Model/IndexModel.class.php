<?php
// 用户模型
namespace Home\Model;
use Think\Model;
class IndexModel extends Model {

	public function getAllTopic($class=1,$page=1){
		$T = M("Topic");	
		$TopicData = $T->where('class=%d',$class)->order("addtime desc")->limit(($page-1)*6,6)->select();
		foreach($TopicData as $key=>$values){
			$tmp = $this->getName($values[uid]);
			$TopicData[$key]['url'] = $tmp[url];
			$TopicData[$key]['name'] = $tmp[wechaname];
			$TopicData[$key]['Pic'] = $this->getPic($values[id]);
			$TopicData[$key]['count'] = $this->getPicCount($values[id]);
			$TopicData[$key]['addtime'] = date('m-d', $values[addtime]); //格式化时间戳
			$TopicData[$key]['replay'] = $this->getReplay($values[id]);
			$TopicData[$key]['ReplayCount'] = $this->getReplayCount($values[id]);
			$TopicData[$key]['Praise'] = $this->getPraise($values[id]);
			$TopicData[$key]['IsPraise'] = $this->getIsPraise($values[id],$_SESSION['id']);
		}
		return $TopicData; 
	}
	
	public function getTopic($tid){
		$T = M("Topic");	
		$TopicData = $T->where('id=%d',$tid)->find();
		$tmp = $this->getName($TopicData[uid]);
		$TopicData['url'] = $tmp[url];
		$TopicData['name'] = $tmp[wechaname];
		$TopicData['Pic'] = $this->getPic($TopicData[id]);
		$TopicData['count'] = $this->getPicCount($TopicData[id]);
		$TopicData['addtime'] = date('m-d', $TopicData[addtime]); //格式化时间戳
		$TopicData['replay'] = $this->getReplay($TopicData[id],21);
		$TopicData['ReplayCount'] = $this->getReplayCount($TopicData[id]);
		$TopicData['Praise'] = $this->getPraise($TopicData[id]);
		$TopicData['IsPraise'] = $this->getIsPraise($TopicData[id],$_SESSION['id']);
		return $TopicData; 
	}
	
	public function save($array){
		$data[uid] = $array[userid] ;
		$data[content] = $array[content] ;
		$data['class'] = $array[class1] ;
		$data[addtime] = time() ;
		$topic = M("topic");
		$cid = $topic->add($data);
		$img['tid'] = $cid;
		
		$pic = M("topicpic");
		foreach($array['img'] as $key=>$value){
			$img['url']=$value;
			$img['thumb_url'] = $array['thumbimg'][$key];
			$pic->add($img);
		}
	}
	public function getName($id){
		$U = M('Userinfo');
		$UserData = $U->where('id=%d',$id)->find();
		if($UserData[url] == NULL){
			$UserData[url] = __ROOT__."/public/img/default.jpg";
		}
		return $UserData;
	}
	
	public function getPic($id){
		$P = M('topicpic');
		$Pic = $P->where('tid=%d',$id)->select();
		return $Pic;
	}
	
	public function getPicCount($id){
		$P = M('topicpic');
		$PicCount = $P->where('tid=%d',$id)->count();
		return $PicCount;
	}
	
	public function getReplay($id,$limit=6,$page=1){
		$R = M('replay');
		$Replay = $R->where('tid=%d',$id)->order("addtime desc")->limit(($page-1)*$limit,$limit)->select();
		foreach($Replay as $key=>$values){
			if($values[reuid] != 0){
				$tmp1 = $this->getName($values[uid]);
				$tmp2 = $this->getName($values[reuid]);
				$Replay[$key][name] = $tmp1[wechaname]."</span> 回复 <span>".$tmp2[wechaname];
				$Replay[$key][name1] = $tmp1[wechaname];
			}else{
			$tmp1 = $this->getName($values[uid]);
			$Replay[$key][name] = $tmp1[wechaname];
			$Replay[$key][name1] = $tmp1[wechaname];
			}
			$Replay[$key][url] = $tmp1[url];
		}
		return $Replay;
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
	
	public function getIsPraise($id,$uid){
		$P = M('praise');
		$IsPraise = $P->where('tid=%d AND uid=%d',array($id,$uid))->find();
		if($IsPraise){
			return 1;
		}	
	}
	
	public function PushPraise($id,$tid){
		$P = M('praise');
		$data[uid] = $id;
		$data[tid] = $tid;
		$P->add($data);
	}
	public function AddReplay($array,$limit=6){
		$P = M('replay');
		$data[tid] = $array[tid];
		$data[uid] = $array[uid];
		$data[reuid] = $array[rid];
		$data[content] = $array[cont];
		$data[addtime] = time();
		$P->add($data);
		$T = M('topic');
		$tmp[addtime] = time();
		$T->where('id=%d',$array[tid])->save($tmp); 
		return $this->getReplay($array[tid],$limit);
	}
}