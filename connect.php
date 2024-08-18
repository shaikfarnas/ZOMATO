<?php
	error_reporting(E_ALL);
	ini_set('display_errors',1);
	session_start();
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	try{
	$conn=new mysqli('localhost','root','',null);
	if($conn->connect_error)
	{
		die("connection failed:".$conn->connect_error);
	}
	

	$sql="CREATE DATABASE IF NOT EXISTS `DETAILS`";
	if($conn->query($sql)===TRUE){
		echo "Database created successfully";
	}else{
		echo "Error creating database".$conn->error;
	}
	
	$conn->select_db('DETAILS');
	echo "connected successfully to the database DETAILS";

	$sql = "CREATE TABLE IF NOT EXISTS userdetails(
	ID INT(11) AUTO_INCREMENT PRIMARY KEY,
	NAME VARCHAR(100) NOT NULL,
	EMAIL VARCHAR(100) NOT NULL,
	PHONE_NUMBER VARCHAR(15) NOT NULL,
	ADDRESS TEXT NOT NULL,
	PAYMENT VARCHAR(50) NOT NULL,
	PINCODE VARCHAR(10) NOT NULL
	)";

	if($conn->query($sql)===TRUE){
		echo "Table 'userdetails' created successfully or already exists.<br>";
	}else{
		echo "Error creating table".$conn->error;
	}


	$name=$_POST['name'];
   	//echo $name;
   	$email=$_POST['email'];
   	//echo $email;
   	$phone=$_POST['phone'];
    	//echo $phone;
    $address=$_POST['address'];
   	//echo $address;
  	$payment=$_POST['payment'];
  	//echo $payment;
   	$pincode=$_POST['pincode'];
   	//echo $pincode;

  	$query="INSERT INTO `userdetails` (`NAME`,`EMAIL`,`PHONE_NUMBER`,`ADDRESS`,`PAYMENT`,`PINCODE`) VALUES(?,?,?,?,?,?)";
   	$stmt=$conn->prepare($query);
   	mysqli_stmt_bind_param($stmt,'ssssss',$name,$email,$phone,$address,$payment,$pincode);
    if($stmt->execute())
	{
		echo "Record inserted successfully.<br>";
		$SESSION["name"]=$name;
	}else{
		echo "Error:".$stmt->error;
	}
	$stmt->close();
	$conn->close();
	}
	catch(mysqli_sql_exception $e){
		die("Connection failed:".$e->getMessage());
	}

	$_SESSION["name"]=$name;
	$_SESSION["thank"]="Thank You!";
 	
?>
<html>
<body>
	<center style="color:blue;padding: top 10px;" >
<?php 

echo $_SESSION["name"]." " ."THANKS FOR PLACING ORDER";
?>
<br>
<img src="thank.jpeg" width=250px>
</center>
</body>
</html>
