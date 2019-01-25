<meta charset="utf-8">

<?php
	try{
		$dbtype="mysql";//使用的数据库类型
		$servername="localhost";//数据库服务器主机名
		$user="root";//数据库连接用户名
		$pass="root";//数据库连接密码
		$dbname="regist";//选用的数据库

		//这里注意,=号两边不能存在空格,不然会报错,如：dbname = $dbname这样写就会报错
		$conn=new PDO("$dbtype:host=$servername;dbname=$dbname",$user,$pass);
		
	}catch(PDOException $e){
		print "error!".$e->getMessage();
		die();
	}




?>