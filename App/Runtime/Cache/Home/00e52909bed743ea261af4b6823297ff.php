<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="keywords" content="" />
    <link rel="shortcut icon" href="http://dzqun.gtimg.cn/quan/images/favicon.ico"/>
    <title><?php echo (session('classname')); ?></title>    
	<link rel="stylesheet" href="/hunqing/Public/css/common.css">	
	<script type="text/javascript" src="/hunqing/Public/js/jquery.min.js"></script>	
	<script type="text/javascript" src="/hunqing/Public/JS/XY_Dialog/XY_Base.js"></script>
</head>
<body><div class="warp" onselectstart="return false;">
            <div class="header">
                        <i class="topicLogo fl db"><img src="<?php echo (session('logo')); ?>" class="tImg" width="78" height="78" alt="logo"></i>
            <h3><?php echo (session('classname')); ?></h3>
                <p class="subTitle">
            </p>
			</div>
        <div class="container">
		<div id="allThreadList">
		<?php if(is_array($Topic)): $i = 0; $__LIST__ = $Topic;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="topicBox">
				<div class="topicCon pd15">
						<p class="personImgDate">
							<span class="perImg db">
								<img src="<?php echo ($vo["url"]); ?>" class="bImg" width="38" height="38" alt="头像">
								<i class=""></i>
								<span class="timeT"><?php echo ($vo["name"]); ?><i><?php echo ($vo["addtime"]); ?></i></span>
						</p>
						<div class="detailCon">
							<p>
							<?php echo ($vo["content"]); ?>
							</p>
							<div class="slideBox">
								<div class="slideBoxWrapper" style="position:relative;">
								<ul>
									<?php if(is_array($vo["Pic"])): $i = 0; $__LIST__ = $vo["Pic"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($vo1["url"]); ?>"><img src="<?php echo ($vo1["thumb_url"]); ?>"></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
								</ul>
								</div>
								<span class="pageNum db" style="top:5px;right:3px;display:none;"><?php echo ($vo["count"]); ?>张</span>
							</div>
							<span class="replyShare db fr">
								<a href="javascript:;" class="like" tId="<?php echo ($vo["id"]); ?>"><i class="<?php if(empty($vo["IsPraise"])): ?>noPraise<?php else: ?>praise<?php endif; ?>"></i><?php echo ($vo["Praise"]); ?></a>
								<a href="javascript:;" class="threadReply" tId="<?php echo ($vo["id"]); ?>"><i class="incoR spr"></i>回复</a>
							</span>
						</div>
				</div>
				<div class="topicList">
						<ul id="replyList_<?php echo ($vo["id"]); ?>">
						<?php if(is_array($vo["replay"])): $i = 0; $__LIST__ = $vo["replay"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?><li><img src="<?php echo ($vo2["url"]); ?>" class="sImg db fl" width="25" height="25" alt="头像"><a href="javascript:;" author="<?php echo ($vo2["name1"]); ?>" tid="<?php echo ($vo["id"]); ?>" uid="<?php echo ($vo2["uid"]); ?>" class="sW fl"><span><?php echo ($vo2["name"]); ?>：</span>
							<?php echo ($vo2["content"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
						<?php if(($vo["ReplayCount"]) > "5"): ?><p class="more" tid="<?php echo ($vo["id"]); ?>" rCount="<?php echo ($vo["ReplayCount"]); ?>" style="display:block"><a href="javascript:;" title="">更多</a>共<?php echo ($vo["ReplayCount"]); ?>条回复</p><?php endif; ?>	
						
				</div>
			</div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
</div>


<div class="bottomBar">
    <div class="bottomBarCon">
        <a href="javascript:;" class="backBtn" id="goback"><i class="incoAnswer back db"></i></a>
            <a href="/hunqing/index.php/Home/Index/pushnew/token/<?php echo (session('token')); ?>/wecha_id/<?php echo (session('wecha_id')); ?>" class="publish db"><i class="incoP"></i>发帖</a>
    <i class="db numP" id="navMsgNum" style="display:none;"></i>
    </a>
        </div>
</div>

<div id="goTop" class="floatLayer db"><a href="javascript:scroll(0,0)" class="upBtn db"></a></div>

<script type="text/javascript">
Util.loadJS("XY_Dialog.js",function(){
	$('.more').live('click',function(){
		var tid = $(this).attr('tid');
		var rCount = $(this).attr('rCount');
		if($(this).find("a").html() == "更多"){		
			$.ajax({
				type: "post",
				url: "/hunqing/index.php/Home/Index/ajaxloadreplay",
				data:"tid="+$(this).attr('tid'),
				success: function(data){
					$("#replyList_"+tid).html(data);	

					if( rCount > 18){
						$(".more[tid="+tid+"] a").html("全部");
					}else{
					$(".more[tid="+tid+"]").css("display","none");
					}
				}
			});
		}
		if($(this).find("a").html() == "全部"){
			window.location.href='/hunqing/index.php/Home/Index/showdetail/token/<?php echo (session('token')); ?>/wecha_id/<?php echo (session('wecha_id')); ?>/tid/'+tid;
		}		
	});
	$('.like').live('click',function(){
		if(CheckLogin() != false){
			var tid = $(this).attr('tId');
			if($(this).find("i").attr('class') == "noPraise"){ //更具显示的标签判断是否ajax点赞
				$.ajax({
				type: "post",
				url: "/hunqing/index.php/Home/Index/ajaxPraise",
				data:"tid="+tid,
				success: function(data){
					$(".like[tId="+tid+"]").html("<i class=\"praise\"></i>"+data+""); //改变赞的样式和数目
					
				}
				});
			}
		}
		
	});
	$('.threadReply').live('click',function(){
			if(CheckLogin() != false){
			Util.Dialog({
				title : "纯文本内容",
				boxID: "FormDialog",
				showtitle : false,
				width : 350,
				height : 200,
				fixed: false,
				content : "text:<div class=\"popLayer\" style=\"width:86%\"><form method=\"post\" id=\"formA\" action=\"/hunqing/index.php/Home/Index/replay\"> <input type=\"hidden\" id=\"tid\" name=\"tid\" value=\""+$(this).attr('tID')+"\"><input type=\"hidden\" id=\"uid\" name=\"uid\" value=\"<?php echo (session('id')); ?>\"><div class=\"sendBorder\"><textarea id=\"content\" name=\"content\" cols=\"\" rows=\"\" class=\"sInput\" placeholder=\"回两句吧...\"></textarea></div><div class=\"sendOperate\"><div class=\"operBtn db fr\"><span class=\"pText\" id=\"pText\">140</span><a href=\"javascript:;\" id=\"cBtn\" class=\"cancelBtn db close\" title=\"\" onclick=\"closeDialog()\">取消</a><a href=\"javascript:;\" id=\"comBtn\" class=\"sendBtn c1 db\" onclick=\"ajaxSubmit()\">发送</a></span></div></form></div>"
				});
			}

	});
	
	$('.sW').live('click',function(){
			if(CheckLogin() != false){
				Util.Dialog({
				title : "纯文本内容",
				boxID: "FormDialog",
				showtitle : false,
				width : 350,
				height : 200,
				fixed: false,
				content : "text:<div class=\"popLayer\" style=\"width:86%\"><form method=\"post\" id=\"formA\" action=\"/hunqing/index.php/Home/Index/replay\"><input type=\"hidden\" id=\"tid\" name=\"tid\" value=\""+$(this).attr('tID')+"\"><input type=\"hidden\" id=\"rid\" name=\"rid\" value=\""+$(this).attr('uid')+"\"><input type=\"hidden\" id=\"uid\" name=\"uid\" value=\"<?php echo (session('id')); ?>\"><div class=\"sendBorder\"><textarea id=\"content\" name=\"content\" cols=\"\" rows=\"\" class=\"sInput\" placeholder=\"回复 "+$(this).attr('author')+"\"></textarea></div><div class=\"sendOperate\"><div class=\"operBtn db fr\"><span class=\"pText\" id=\"pText\">140</span><a href=\"javascript:;\" id=\"cBtn\" class=\"cancelBtn db close\" title=\"\" onclick=\"closeDialog()\">取消</a><a href=\"javascript:;\" id=\"comBtn\" class=\"sendBtn c1 db\" onclick=\"ajaxSubmit()\">发送</a></span></div></form></div>"
				});
			}

	});
		
});
	function CheckLogin(){
		var a = "<?php echo (session('id')); ?>";
		if( a == ""){
			if(confirm("您不是会员卡会员不能回复和点赞点击确定添加会员")){
				self.location='http://wxapi.weicehua.net/index.php?g=Wap&m=Card&a=get_card&token=<?php echo (session('token')); ?>&wecha_id=<?php echo (session('wecha_id')); ?>';
				return false;
			}else{
			return false;
			}
		}
	}
	
	function closeDialog(){
	Util.Dialog.close("FormDialog");
	}
	
	function ajaxSubmit(){	
	var tid = $("#tid").val();
	var cont = $("#content").val();
	var uid = $("#uid").val();
	var rid = $("#rid").val();
	if(cont ==""){
		alert(rid);
	}else{		
		$.ajax({
			type: "post",
			url: "/hunqing/index.php/Home/Index/ajaxreplay",
			data:"tid="+tid+"&cont="+cont+"&uid="+uid+"&rid="+rid,
			success: function(data){
				$("#replyList_"+tid).html(data);
		  }
		  });	
		closeDialog();
		}
	}
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
</script>


<script type="text/javascript">
//滑动加载
jQuery(function($) {
  var currentPage = 1;
  var scroll;
  var loadIMG = function() {
	  var url = "/hunqing/index.php/Home/Index/ajaxload/class/<?php echo (session('class')); ?>/page/"+currentPage+"";
	  $.ajax({
		type: "POST",
		url: url
	  }).done(function( msg ) {
		  if (msg=='0'){
			return false;
		  }
		  else
		  {
			$('#allThreadList').append(msg);
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