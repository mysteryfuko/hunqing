<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="robots" content="all" />
    <meta name="author" content="Tencent" />
    <meta name="Copyright" content="Tencent" />
    <meta name="Description" content="微社区" />
    <meta name="Keywords" content="微社区、微生活" />
    <title>微社区后台</title>
    <link rel="stylesheet" href="/hunqing/Public/css/style.css">
	<script type="text/javascript" src="/hunqing/Public/js/jquery.min.js"></script>	
	<script type="text/javascript" src="/hunqing/Public/JS/XY_Dialog/XY_Base.js"></script>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <div class="headerCon">
            <a href="javascript:;" class="logo db fl ht" title="微社区">微社区</a>
            <ul class="navMenu fl">
                <li><a href="#" class="spr on" >首页</a></li>
                <li><a href="#">管理中心</a></li>
            </ul>
        </div>
    </div>

    <div class="wp mtm nvt title pr" id="topbar">
    </div>
    <div class="container">
        <div id="mainContainer" class="main">
			<select name="List" class="List">
			<?php if(is_array($list)): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><option <?php if(($_SESSION['AdClass']) == $k): ?>selected<?php endif; ?> value="<?php echo ($vo["id"]); ?>" ><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
		<div class="topicBox">
			<div class="topicList">
			<ul id="topicItems">    
			<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?><li id="<?php echo ($vo1["id"]); ?>"> 
					<div class="editBtn fl">
					<a href="javascript:;" title="" class="delBtn db spr ht" tid="<?php echo ($vo1["id"]); ?>">删除帖子</a>
					</div> 
					<div class="topicCon fr pr"> 
						<a href="javascript:;" class="avatar"><img src="<?php echo ($vo1["url"]); ?>" class="personImg pa" width="40" height="40" alt="头像"></a> 
						<p class="titDate"> 
						<span class="db fl author">
						<strong><?php echo ($vo1["name"]); ?></strong>
						</span> 
						<span class="db f12 fr"><em><?php echo ($vo1["addtime"]); ?></em></span> </p> 
						<p class="htmlEdit"><a href="javascript:;" title=""><?php echo ($vo1["content"]); ?></a></p>  
						<p class="replyComment "> 
							<span class="db fl pr">
								<a class="replynum" href="javascript:;" title=""><i class="bubble dib spr mprevise"></i><?php echo ($vo1["Praise"]); ?></a> 
								<a class="zannum" href="javascript:;" title=""><i class="thumb dib spr mprevise"></i><?php echo ($vo1["ReplayCount"]); ?></a> 
							</span> 
							<span class="db fr threadOp" style="display: block;"> 
							<a href="/hunqing/index.php/Home/Admin/show/id/<?php echo ($vo1["id"]); ?>" title="" class="editThread" tid="<?php echo ($vo1["id"]); ?>">详细</a>   				
							</span> 
						</p> 
					</div> 
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
			<?php echo ($page); ?>
			</div>
		</div>
		</div>
        <div class="appl">
			<li><dd><a href="/hunqing/index.php/Home/Admin/index">版面管理</a></dd></li>
			<li><dd class="on">帖子管理</dd></li>
		</div>
    </div>
    <div class="footer">微策划公司 版权所有</div>
</div>
<script type="text/javascript">
$('.delBtn').live('click',function(){
	var id1 = $(this).attr('tid');
	if(confirm('你确定要删除此文字')){
		$.post('/hunqing/index.php/Home/Admin/DelTopic',
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
$('.List').live('change',function(){
	var class1 = $(this).val();
	$.post('/hunqing/index.php/Home/Admin/ChangeClass',
	{
	id : class1
	},
	function(){
		window.location.reload(); 
	})
});
</script>
</body>
</html>