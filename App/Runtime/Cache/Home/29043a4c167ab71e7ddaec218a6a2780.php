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
</head>
<body>
<div class="wrapper">
    <div class="header">
        <div class="headerCon">
            <a href="javascript:;" class="logo db fl ht" title="微社区">微社区</a>
            <ul class="navMenu fl">
                <li><a href="/" class="spr on">首页</a></li>
                <li><a href="/" id="manageIndex" >管理中心</a></li>
            </ul>
        </div>
    </div>

    <div class="wp mtm nvt title pr" id="topbar">
    </div>
    <div class="container">
        <div id="mainContainer" class="main">
		
		<form action='/hunqing/index.php/Home/Login/AdminDoLogin' method='post' name='myForm'>
			用户名：<input type='text' name='username'/><br/>
			密　码：<input type='password' name='password'/><br/>
			验证码：<input type='text' name='code'/>
					<img src='/hunqing/index.php/Home/Login/code' onclick="javascript:this.src=this.src+'?'+Math.random()"/>
					<br/>
			<button type="submit">登录</button>
		</form>
		
		</div>
        <div class="appl"></div>
    </div>
    <div class="footer">微策划公司 版权所有</div>
</div>
</body>
</html>