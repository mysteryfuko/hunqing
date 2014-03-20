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
		<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="m-box cl"> <h2><?php echo ($vo["name"]); ?></h2> 
				<div class="m-boxr fl">
					<form action="/hunqing/index.php/Home/Admin/editClass/id/<?php echo ($vo["id"]); ?>" method="post" id="infoForm" enctype="multipart/form-data">
					<div class="field cl"> <label>板块名称：</label> <span class="mlm infovalue" id="name<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></span><input type="hidden" name="name" id="name<?php echo ($vo["id"]); ?>" value="<?php echo ($vo["name"]); ?>"/>
					<span class="mlm pa"> <i class="db mBox pa">  
						<a class="modifyBImg pa" id="changeDesc" href="javascript:void(0)" clname="<?php echo ($vo["name"]); ?>" CLID="<?php echo ($vo["id"]); ?>">更改</a> </i></span>
					</div> 
					<div class="field cl"> 
					<label>板块LOGO：</label> 
					<span class="mlm infovalue"><div id="logopreview"> <img src="<?php echo ($vo["logo"]); ?>" id="img<?php echo ($vo["id"]); ?>" alt="logo"> </div> </span> 
					<span class="mlm pa"> <i class="db mBox1 pa"> <input type="hidden" name="logo" id="logo<?php echo ($vo["id"]); ?>" value="<?php echo ($vo["logo"]); ?>"><input name="<?php echo ($vo["id"]); ?>" id="logoinput" type="file" class="selectInput pa" > <a class="modifyBImg pa" href="javascript:void(0)">更改</a> </i> <span class="tiptxt mt30">建议大于200*200像素，小于2M<br>仅支持jpg/png/jpeg格式的图片</span> </span> 
					</div> 
					<div class="field cl"> <label>板块地址：</label> <span class="mlm infovalue">http://<?php echo ($_SERVER['SERVER_NAME']); ?>/hunqing/index.php/Home/index/index/class/<?php echo ($vo["id"]); ?></span> </div> 
					<div class="field"> <input class="btn btn-green1" type="submit" value="保存" title="保存" tabindex="21" id="infoFormSubmit"> </div> </form>
				</div>
			</div><?php endforeach; endif; else: echo "" ;endif; ?>
		<div class="Add"> <input class="btn btn-green1" value="添加板块" title="添加板块" tabindex="21" id="infoAddSubmit"> </div>
		</div>
        <div class="appl">
			<li><dd class="on">版面管理</dd></li>
			<li><dd><a href="/hunqing/index.php/Home/Admin/TopicList">帖子管理</a></dd></li>
		</div>
    </div>
    <div class="footer">微策划公司 版权所有</div>
</div>
<script type="text/javascript">
Util.loadJS("XY_Dialog.js",function(){
	$('#changeDesc').live('click',function(){
			Util.Dialog({
			title : "纯文本内容",
			boxID: "FormDialog",
			showtitle : false,
			width : 200,
			height : 10,
			fixed: false,
			content : "text:<div style=\"width: 100%; position: fixed; z-index: 1001; top: 95.5px; left: 0px;\" id=\"fwin_dialog_tips\"><div class=\"tip-box box-shadow\" style=\"margin:0 auto;\" id=\"descBox\"><div class=\"tip-hd mbm\">板块名称</div> <div class=\"tip-inbox f14 mbm\"><input type=\"hidden\" id=\"CLID\" value=\""+$(this).attr('CLID')+"\"/> <textarea id=\"sDescNew\" cols=\"5\" rows=\"5\">"+$(this).attr('clname')+"</textarea> </div> <div class=\"tip-actionbtn txt-right\"> <button type=\"button\" class=\"btn btn-default mrw close\">取消</button> <button type=\"button\" class=\"btn btn-green submitBtn\">确定</button> </div></div></div>"
			});
	});		
});
	$('.close').live('click',function(){
		Util.Dialog.close("FormDialog");
	});

	$('.submitBtn').live('click',function(){
		var id = $("#CLID").val();
		var d = $("#sDescNew").val();	
		$("#name"+id).html(d);
		$("input#name"+id).val(d);
		Util.Dialog.close("FormDialog");
	});	
	console.log();
	var base;
	
	$("#logoinput").live('change',function(){		
		var file=this.files[0];
		var id = $(this).attr('name');
		var reader = new FileReader(); 
		reader.readAsDataURL(file); 	
		reader.onload = function(e){ 
			base = this.result; 
			$("#logo"+id).val(base);
			$("#img"+id).attr('src',base);
		}
	});
	
	$('#infoAddSubmit').live('click',function(){
		$.post('/hunqing/index.php/Home/Admin/AddClass',
			function(data){
			$("<div class=\"m-box cl\"> <h2></h2><div class=\"m-boxr fl\"><form action=\"/hunqing/index.php/Home/Admin/AddClassDo/id/"+data+"\" method=\"post\" id=\"infoForm\" enctype=\"multipart/form-data\"><div class=\"field cl\"> <label>板块名称：</label> <span class=\"mlm infovalue\" id=\"name"+data+"\"></span><input type=\"hidden\" name=\"name\" id=\"name"+data+"\" value=\"\"/><span class=\"mlm pa\"> <i class=\"db mBox pa\">  <a class=\"modifyBImg pa\" id=\"changeDesc\" href=\"javascript:void(0)\" clname=\"\" CLID=\""+data+"\">更改</a> </i></span></div> <div class=\"field cl\"> <label>板块LOGO：</label> <span class=\"mlm infovalue\"><div id=\"logopreview\"> <img src=\"\" alt=\"logo\"> </div> </span> <span class=\"mlm pa\"> <i class=\"db mBox1 pa\"> <input type=\"hidden\" name=\"logo\" id=\"logo"+data+"\" value=\"\"><input name=\"logo"+data+"\" id=\"logoinput\" type=\"file\" class=\"selectInput pa\" > <a class=\"modifyBImg pa\" href=\"javascript:void(0)\">更改</a> </i> <span class=\"tiptxt mt30\">建议大于200*200像素，小于2M<br>仅支持jpg/png/jpeg格式的图片</span> </span> </div> <div class=\"field cl\"> <label>板块地址：</label> <span class=\"mlm infovalue\">http://<?php echo ($_SERVER['SERVER_NAME']); ?>/hunqing/index.php/Home/index/index/class/"+data+"</span> </div> <div class=\"field\"> <input class=\"btn btn-green1\" type=\"submit\" value=\"保存\" title=\"保存\" tabindex=\"21\" id=\"infoFormSubmit\"> </div> </form></div></div>").prependTo(".Add");
		})
	});
</script>
</body>
</html>