<meta charset="utf-8">
<?php

    //先启动session
	session_start();

/*1.表单验证部分*/

	//获取表单提交数据
	$username=$_POST['username'];
	$userpass=$_POST['userpass'];
	$confirmpassword=$_POST['confirmpassword'];
	$qqemail=$_POST['qqemail'];
	$mobilephone=$_POST['mobilephone'];
	//格式错误信息提示
	$usernameErr=$userpassErr=$confirmpasswordErr=$qqemailErr=$mobilephoneErr="";
	
	//验证姓名
	if (empty($_POST["username"])){
		$usernameErr = "名字是必需的";
		include_once('regist.html');
		die();      
    }else{
        if (!preg_match("/^[a-zA-Z ]+$/",$username)){
        	$usernameErr = "只允许字母"; 
        	include_once('regist.html');
        	die();      
        }
    }  

    //验证密码
    if (empty($_POST["userpass"])){
		$userpassErr = "密码是必需的";
		include_once('regist.html');
		die();
    }else{
        if (!preg_match("/^[\w]{6}$/",$userpass)){
        	$userpassErr = "只允许字母或数字且长度为6"; 
        	include_once('regist.html');
        	die();
        }
    }  

    //再次确认密码
    if (empty($_POST["confirmpassword"])){
		$confirmpasswordErr = "请确认密码";
		include_once('regist.html');
		die();
    }else{
    	if ($userpass!=$confirmpassword){
			$confirmpasswordErr = "密码不一致";
			include_once('regist.html');
			die();
   		}
   	}

    //验证邮箱
    if (!empty($_POST["qqemail"])){
    	if (!preg_match("/^[\w]+@{1}[q]{2}(\.[c]{1}[o]{1}[m]{1})$/",$qqemail)){
       		$qqemailErr = "只支持QQ邮箱"; 
        	include_once('regist.html');
        	die();
    	}
    }

    //验证手机号码
    if (!empty($_POST["mobilephone"])){
    	if (!preg_match("/^[1][358]\d{9}$/",$mobilephone)){
        	$mobilephoneErr = "手机号格式错误"; 
        	include_once('regist.html');
        	die();
    	} 
	}

	                                           
/*2.操作数据库部分*/

	//引用connection.php文件连接数据库
	include_once('connection.php');

	//使用预处理语句执行查询操作,判断用户是否已存在
	$stmt=$conn->prepare("select*from user where name=:name");
	//使用bind_param()函数绑定参数
	$stmt->bindParam(':name',$username);
	//为绑定的参数赋值
	$stmt->execute();
	
	if($count=$stmt->rowcount()>0){
		echo "用户已存在,请重新注册！"."<a href='regist.html'>去注册</a>"."<br>";
		echo $count;
		die();
	}

	if($qqemail!=""&&$mobilephone!=""){
		//判断该用户未注册后,使用预处理语句将其插入到user表中
		$stmt=$conn->prepare("insert into user(name,pass,email,phone) values(:name,:pass,:email,:phone)");
		//使用bind_param()函数绑定参数
		$stmt->bindParam(':name',$name); 
		$stmt->bindParam(':pass',$pass); 
		$stmt->bindParam(':email',$email); 
		$stmt->bindParam(':phone',$phone);
		//为绑定的参数赋值
		$name=$username;
		$pass=$userpass;
		$email=$qqemail;
		$phone=$mobilephone;
		//执行
		$result=$stmt->execute();
		if($result){
			//插入成功后,弹出消息提示框
			echo "<script>alert('注册成功')</script>"."<br>";
		}else{
			die();
		}
	}

	if($qqemail!=""){
		//判断该用户未注册后,使用预处理语句将其插入到user表中
		$stmt=$conn->prepare("insert into user(name,pass,email) values(:name,:pass,:email)");
		//使用bind_param()函数绑定参数
		$stmt->bindParam(':name',$name); 
		$stmt->bindParam(':pass',$pass); 
		$stmt->bindParam(':email',$email);  
		//为绑定的参数赋值
		$name=$username;
		$pass=$userpass;
		$email=$qqemail;
		//执行
		$result=$stmt->execute();
		if($result){
			//插入成功后,弹出消息提示框
			echo "<script>alert('注册成功')</script>"."<br>";
		}else{
			die();
		}
	}
	
	if($mobilephone!=""){
		//判断该用户未注册后,使用预处理语句将其插入到user表中
		$stmt=$conn->prepare("insert into user(name,pass,phone) values(:name,:pass,:phone)");
		//使用bind_param()函数绑定参数
		$stmt->bindParam(':name',$name); 
		$stmt->bindParam(':pass',$pass); 
		$stmt->bindParam(':phone',$phone);  
		//为绑定的参数赋值
		$name=$username;
		$pass=$userpass;
		$phone=$mobilephone;
		//执行
		$result=$stmt->execute();
		if($result){
			//插入成功后,弹出消息提示框
			echo "<script>alert('注册成功')</script>"."<br>";
		}else{
			die();
		}
	}

	if($qqemail==""&&$mobilephone==""){
		//判断该用户未注册后,使用预处理语句将其插入到user表中
		$stmt=$conn->prepare("insert into user(name,pass) values(:name,:pass)");
		//使用bind_param()函数绑定参数
		$stmt->bindParam(':name',$name); 
		$stmt->bindParam(':pass',$pass); 
		//为绑定的参数赋值
		$name=$username;
		$pass=$userpass;
		$result=$stmt->execute();
		if($result){
			//插入成功后,弹出消息提示框
			echo "<script>alert('注册成功')</script>"."<br>";
		}else{
			die();
		}
	}
	
	$stmt=$conn->prepare("select*from user");
	//执行execute()函数返回的是一个PDOStatement对象,表示执行成功或失败
	$result=$stmt->execute();
	if($result){
		//fetch()方法用于获取结果集的下一行(fetch()方法是一行一行进行检索的),并放入到关联数组,然后通过while()循环输出结果集
		//众所周知,我们平时获取数组的值时,一般都是通过数字索引或者是其字符串键来获取的
		//结果集的返回方式通过fetch()方法的参数来控制,参数为PDO::FETCH_ASSOC,即通过列名作为数组索引来获取
		//参数为PDO::FETCH_NUM时,通过列号作为索引来获取,参数为PDO::FETCH_BOTH时,即可通过列名来获取也可通过列号来获取,不写默认为PDO::FETCH_BOTH
		//具体可以看：https://www.jb51.net/article/105797.htm或http://www.php.cn/php-weizijiaocheng-361205.html
		echo "注册用户<br>";
		while($row=$stmt->fetch()){
			echo $row['name']." " .$row['pass']." ".$row['email']." ".$row['phone']."<br>";
			// echo $row['0']." " .$row['1']." ".$row['2']." ".$row['3']."<br><br>";
		}
		//输出结果集中的行数
		echo "注册人数为：".$count=$stmt->rowcount()."<br>";
	}
	

	//关闭数据库连接,释放资源
	$conn=null;
	session_destroy();

?>