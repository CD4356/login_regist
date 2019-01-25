<meta charset="utf-8">
<?php

	//先启动session
	session_start();
	
	//获取表单提交数据
	$username=$_POST['username'];
	$userpass=$_POST['userpass'];
	//判断提交信息是否为空
	if($username==""||$userpass==""){
		//弹出消息提示框
		echo "<script>alert('用户名或密码为空')</script>";
		die();
	}
?>
<?php
	//引用connection.php文件连接数据库
	include_once('connection.php');

	//预处理sql语句
	$stmt=$conn->prepare("select*from user where name=:name and pass=:pass");
	//使用bindParam()方法绑定参数
	$stmt->bindParam(':name',$name);
	$stmt->bindParam(':pass',$pass);
	//为绑定的参数赋值
	$name=$username;
	$pass=$userpass;
	//执行
	$stmt->execute();
	//判断结果集中的行数是否大于0
	if($count=$stmt->rowcount()>0){
		//弹出消息提示框
		echo "<script>alert('登陆成功！')</script>";
		//跳转到主页面
		include_once('homepage.html');
	}else{
		//弹出消息提示框
		echo "<script>alert('用户名或密码错误！')</script>";
		//跳转会登陆页面
		include_once('login.html');
	}

	//关闭数据库连接
	$conn=null;
	//删除session
	session_destroy();


?>