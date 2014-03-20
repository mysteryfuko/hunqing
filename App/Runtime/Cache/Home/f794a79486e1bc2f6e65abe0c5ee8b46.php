<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
<head time='1395018823'>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="baidu-tc-cerfication" content="5f496895eb9bff9ec4db4512a7e4e95c" />
    <meta name="description" content="手Q最火爆的内涵部落，分享最真实、最具内涵漫画、邪恶漫画、搞笑图片、糗事、恶搞、雷人语录，让你看了之后根本把持不住，我们都爱内涵部落。"/>
    <meta name="keywords" content="" />
    <link rel="shortcut icon" href="http://dzqun.gtimg.cn/quan/images/favicon.ico"/>
    <title><?php echo (session('classname')); ?></title>    
	<link rel="stylesheet" href="/hunqing/Public/css/common.css">	
	<script type="text/javascript" src="/hunqing/Public/js/jquery.min.js"></script>	
	<script type="text/javascript" src="/hunqing/Public/JS/XY_Dialog/XY_Base.js"></script>
</head>
<body>
<div class="warp" onselectstart="return false;">
        <div class="header h_b">
        <i class="topicLogo perLogo fl db"><img src="<?php echo (session('logo')); ?>" class="bImg" width="38" height="38"></i>
        <h3 class="backflow"><?php echo (session('classname')); ?></h3>
        <span class="incoAnswer db return"></span>
    </div>

    <div class="container">
        <div class="topicBox">
            <div class="topicCon">
                    <p class="personImgDate">
                        <span class="perImg db">
                            <img src="<?php echo ($Topic["url"]); ?>" class="bImg" width="38" height="38" alt="头像">
                            <i class="admin"></i>
                            <span class="timeT"><?php echo ($Topic["name"]); ?><i><?php echo ($Topic["addtime"]); ?></i></span>
                        </span>
                        <span class="perDate db">
                        <a href="javascript:;" tid="<?php echo ($Topic["id"]); ?>" class="DelTopic">删除话题</a></span>
                    </p>
                    <div class="detailCon">
                        <p><?php echo ($Topic["content"]); ?></p>
                        <a href="javascript:;" class="viewBtn db fl" style="display:none;">全文</a>
						<div class="slideBox">
                            <div class="slideBoxWrapper" style="width: 100%;  position: relative;  margin: 10px 0 0; ">
                            <ul>
								<?php if(is_array($Topic["Pic"])): $i = 0; $__LIST__ = $Topic["Pic"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($vo1["url"]); ?>"><img src="<?php echo ($vo1["thumb_url"]); ?>"></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                            </div>
                            <span class="pageNum db" style="top:20px;display:none;"><?php echo ($Topic["count"]); ?>张</span>
                        </div>
                    </div>
            </div>
            <div class="topicList">
                <ul id="replyList_<?php echo ($Topic["id"]); ?>"> 
					<?php if(is_array($Topic["replay"])): $i = 0; $__LIST__ = $Topic["replay"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?><li id="<?php echo ($vo2["id"]); ?>"><img src="<?php echo ($vo2["url"]); ?>" class="sImg db fl" width="25" height="25" alt="头像"><a href="javascript:;" rid="<?php echo ($vo2["id"]); ?>" " class="sW fl"><span><?php echo ($vo2["name"]); ?>：</span>
							<?php echo ($vo2["content"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                            </div>
        </div>
    </div>
</div>
<!--底部bar-->
<div class="bottomBar">
    <div class="bottomBarCon">
        <a href="javascript:;" class="backBtn" id="goback" onclick="location.href=document.referrer;"><i class="incoAnswer back db"></i></a>
    <i class="db numP" id="navMsgNum" style="display:none;"></i>
    </a>
<div id="goTop" class="floatLayer db" ><a href="javascript:;" class="upBtn db"></a></div>
<script type="text/javascript">

	
	$('.sW').live('click',function(){
		var id1 = $(this).attr('rid');
		if(confirm('你确定要删除此回复')){
		$.post('/hunqing/index.php/Home/Admin/DelReplay',
			{
			id : id1
			},
			function(){
				$('li#'+id1).html('');
				$('li#'+id1).remove();
			})
		}else{
		}
	});
	
	$('.DelTopic').live('click',function(){
		var id1 = $(this).attr('tid');
		if(confirm('你确定要删除此话题')){
		$.post('/hunqing/index.php/Home/Admin/DelTopic',
			{
			id : id1
			},
			function(){
				alert("删除成功");
				location.href=document.referrer;
			})
		}else{
		}
	});
var currentPage; 
	
//图片触摸滑动
	var j, i, d, b, t, s, m, e = 0;
	$(".container").on("touchstart", ".slideBoxWrapper", function(w) {
		j = d = w.originalEvent.touches[0].pageX;
		i = b = w.originalEvent.touches[0].pageY;
		m = e		
	});
	var k = null;
	$(".container").on("touchmove", ".slideBoxWrapper", function(y) {
		d = y.originalEvent.touches[0].pageX;
		b = y.originalEvent.touches[0].pageY;
		t = d - j;
		s = b - i;
		if (Math.abs(s) < Math.abs(t)) {
			if (y.preventDefault) {
				y.preventDefault()
			}
		} else {
			return true
		}
		var x = $(this);
		e = m + parseInt(t);
		if (e > 0) {
			e = 0;
			t = 0;
			s = 0
		}
		var w = -1 * (this.scrollWidth - $(this).parent().width());
		if (this.scrollWidth >= $(this).parent().width() && e < w) {
			e = w;
			t = 0;
			s = 0
		}		
		$(this).css("left", e)
	});
	
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

//滑动加载
jQuery(function($) {
  currentPage = 1; 
  var scroll;
  var loadIMG = function() {
	  var url = "/hunqing/index.php/Home/index/ajaxloadreplay1/tid/<?php echo ($Topic["id"]); ?>/page/"+currentPage+"";
	  $.ajax({
		type: "POST",
		url: url
	  }).done(function( msg ) {
		  if (msg=='0'){
			return false;
		  }
		  else
		  {
			$('#replyList_<?php echo ($Topic["id"]); ?>').append(msg);
			 console.log(currentPage);
			//swipeboxInstance.refresh();
		  }
	  });
  };
  $(window).scroll( function() {
	 scroll = $(document).scrollTop();
	 sessionStorage.setItem("location",scroll)
	if ($(document).scrollTop() >= $(document).height()-$(window).height()) {
	  currentPage++;
	  loadIMG();
	}

  })

  $( document ).ready(function(){
	if(sessionStorage.getItem("location")){
	  $(document).scrollTop(sessionStorage.getItem("location"));
	}
  })

})
</script>
</body>
</html>