<?php
session_start();
include "db.php";
if (isset($_POST["f_name"])) {

        $f_name =htmlspecialchars( $_POST["f_name"], ENT_QUOTES, 'UTF-8');
	$l_name = htmlspecialchars($_POST["l_name"], ENT_QUOTES, 'UTF-8');
	$email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
	$password =htmlspecialchars( $_POST['password'], ENT_QUOTES, 'UTF-8');
	$repassword =htmlspecialchars( $_POST['repassword'], ENT_QUOTES, 'UTF-8');
	$mobile =htmlspecialchars( $_POST['mobile'], ENT_QUOTES, 'UTF-8');
	$address1 = htmlspecialchars($_POST['address1'], ENT_QUOTES, 'UTF-8');
	$address2 = htmlspecialchars($_POST['address2'], ENT_QUOTES, 'UTF-8');
	$name = "/^[a-zA-Z ]+$/";
	$emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";
	$number = "/^[0-9]+$/";

if(empty($f_name) || empty($l_name) || empty($email) || empty($password) || empty($repassword) ||
	empty($mobile) || empty($address1) || empty($address2)){
		
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>PLease Fill all fields..!</b>
			</div>
		";
		exit();
	} else {
		if(!preg_match($name,$f_name)){
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>this $f_name is not valid..!</b>
			</div>
		";
		exit();
	}
	if(!preg_match($name,$l_name)){
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>this $l_name is not valid..!</b>
			</div>
		";
		exit();
	}
	if(!preg_match($emailValidation,$email)){
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>this $email is not valid..!</b>
			</div>
		";
		exit();
	}
	if(strlen($password) < 9 ){
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>Password is weak</b>
			</div>
		";
		exit();
	}
	if(strlen($repassword) < 9 ){
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>Password is weak</b>
			</div>
		";
		exit();
	}
	if($password != $repassword){
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>password is not same</b>
			</div>
		";
	}
	if(!preg_match($number,$mobile)){
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>Mobile number $mobile is not valid</b>
			</div>
		";
		exit();
	}
	if(!(strlen($mobile) == 10)){
		echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>Mobile number must be 10 digit</b>
			</div>
		";
		exit();
	}
	//existing email address in our database
	$sql = "SELECT user_id FROM user_info WHERE email = '$email' LIMIT 1" ;

		/*Vulnerability-SQL injection  
    	Fixing - Using a prepared statement with parameter binding */
		$stmt = mysqli_prepare($con, $sql);
		mysqli_stmt_bind_param($stmt, "s", $email);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$count_email = mysqli_num_rows($result);

	if($count_email > 0){
		echo "
			<div class='alert alert-danger'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>Email Address is already available Try Another email address</b>
			</div>
		";
		exit();
	} else {
		
		$sql = "INSERT INTO `user_info` 
  (`user_id`, `first_name`, `last_name`, `email`, 
  `password`, `mobile`, `address1`, `address2`) 
  VALUES (NULL, ?, ?, ?, 
  ?, ?, ?, ?)";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "ssssiss", $f_name, $l_name, $email, $password, $mobile, $address1, $address2);
  mysqli_stmt_execute($stmt);
  $_SESSION["uid"] = mysqli_insert_id($con);
  $_SESSION["name"] = $f_name;
  $ip_add = getenv("REMOTE_ADDR");
  $sql = "UPDATE cart SET user_id = ? WHERE ip_add=? AND user_id = -1";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "is", $_SESSION["uid"], $ip_add);
  mysqli_stmt_execute($stmt);

  echo "register_success";
  echo "<script> location.href='store.php'; </script>";
  exit;
		}
	}
	
}



?>






















































