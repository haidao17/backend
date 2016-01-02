<?php defined('G_IN_ADMIN')or exit('No permission resources.'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><HTML xmlns="http://www.w3.org/1999/xhtml">
<head>
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta content="IE=11.0000" http-equiv="X-UA-Compatible">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<title>后台登陆</title>
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/login/js/jquery-1.9.1.min.js" type="text/javascript"></script>
     
<script type="text/javascript">
$(function(){
	//得到焦点
	$("#password").focus(function(){
		$("#left_hand").animate({
			left: "150",
			top: " -38"
		},{step: function(){
			if(parseInt($("#left_hand").css("left"))>140){
				$("#left_hand").attr("class","left_hand");
			}
		}}, 2000);
		$("#right_hand").animate({
			right: "-64",
			top: "-38px"
		},{step: function(){
			if(parseInt($("#right_hand").css("right"))> -70){
				$("#right_hand").attr("class","right_hand");
			}
		}}, 2000);
	});
	//失去焦点
	$("#password").blur(function(){
		$("#left_hand").attr("class","initial_left_hand");
		$("#left_hand").attr("style","left:100px;top:-12px;");
		$("#right_hand").attr("class","initial_right_hand");
		$("#right_hand").attr("style","right:-112px;top:-12px");
	});
});
</script>
 
<meta name="GENERATOR" content="MSHTML 11.00.9600.17496">
<link type="text/css" rel="stylesheet" href="<?php echo G_GLOBAL_STYLE; ?>/global/css/materialize/css/materialize.min.css"  media="screen,projection"/>
</head> 
<body>

	<nav>
    	<div class="nav-wrapper" style="margin-top: -22px;">
     		<p class="brand-logo" style="margin:0 10px;">DivTeam</p>
    	</div>
	</nav>

<div class="container">
 	<div class="row" style="margin-top:90px;">
        <div class="col s6 offset-s3">
          <div class="card grey lighten-5">
            <div class="card-content blue-text text-darken-2">
              <p class="card-title" style="text-align:center;">后台登陆</p>
               <form action="#" method="post" id="form">
					<div class="row">
				        <div class="input-field col s12">
				          <input id="input-u" name="username" class="ipt validate" value="" type="text">      
				          <label for="input-u">Username</label>
				        </div>
				      </div>

				    <div class="row">
				        <div class="input-field col s12">
				          <input class="ipt validate" type="password" id="input-p" name="password" value="">   
				          <label for="input-p">Password</label>
				        </div>
				    </div>

					<div class="row">
				        <div class="input-field col s12">
							<input class="ipt validate" type="text" id="input-c" name="code" value="">           
							<label for="input-c">验证码</label>
							<?php if(_cfg("web_off")){ ?>
								<span class="code" style="float: right;">
									<img width="88px" height="35px" id="checkcode" src="<?php echo WEB_PATH; ?>/api/checkcode/image/80_27/"/>
								</span>   
							<?php } ?>
				        </div>
				      </div>


				      <div class="row">
				      <a class="waves-effect waves-light btn" id="form_but"  value="登录">登陆</a>
				 </form>
            </div>
          </div>
        </div>
    </div>
</div>



<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo G_GLOBAL_STYLE; ?>/global/js/global.js"></script>
<script src="<?php echo G_PLUGIN_PATH; ?>/layer/layer.min.js"></script>
 <script type="text/javascript" src="<?php echo G_GLOBAL_STYLE; ?>/global/css/materialize/js/materialize.min.js"></script>

<script type="text/javascript">
var loading;
var form_but;
window.onload=function(){
	
	 document.onkeydown=function(){
		if(event.keyCode == 13){
             ajaxsubmit();
        }          
	}
	form_but=document.getElementById('form_but');
	form_but.onclick=ajaxsubmit;	
	<?php if(_cfg("web_off")){ ?>
	var checkcode=document.getElementById('checkcode');	
	checkcode.src = checkcode.src + new Date().getTime();	
	var src=checkcode.src;
		checkcode.onclick=function(){
				this.src=src+'/'+new Date().getTime();
	}
   <?php } ?>
		
}

$(document).ready(function(){$.focusblur("#input-u");$.focusblur("#input-p");$.focusblur("#input-c");});

function ajaxsubmit(){
		var name=document.getElementById('form').username.value;
		var pass=document.getElementById('form').password.value;
		<?php if(_cfg("web_off")){ ?>
		var codes=document.getElementById('form').code.value;
	    <?php }else{ ?>
		var codes = '';
		<?php } ?>
		//document.getElementById('form').submit();
		$.ajaxSetup({
			async : false
		});				
		$.ajax({
			   "url":window.location.href,
			   "type": "POST",
			   "data": ({username:name,password:pass,code:codes,ajax:true}),
			   "beforeSend":beforeSend, //添加loading信息
			   "success":success//清掉loading信息
		});
	
}
function beforeSend(){
	 form_but.value="登录中...";
	 loading=$.layer({
		type : 3,
		time : 0,
		shade : [0.5 , '#000' , true],
		border : [5 , 0.5 , '#7298a6', true],
		loading : {type : 4}
	});
}

function success(data){
	layer.close(loading);
	form_but.value="登录";
	var obj = jQuery.parseJSON(data);
	if(!obj.error){	
		window.location.href=obj.text;
	}else{
		// $.layer({
		// 	type :0,
		// 	area : ['auto','auto'],
		// 	title : ['信息',true],
		// 	border : [5 , 0.5 , '#7298a6', true],
		// 	dialog:{msg:obj.text}
		// });
		Materialize.toast(obj.text, 4000);
		var checkcode=document.getElementById('checkcode');
		var src=checkcode.src;
			checkcode.src='';
			checkcode.src=src;
		}
}
</script>
</body>
</html>