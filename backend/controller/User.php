<?php 

$url = "../index.php?mod=user&act=list";

require_once "../model/Backend.php";

$model = new Backend;

$act = $_POST['act'];

if($act == "checkPass"){

	$user_id = (int) $_POST['user_id'];
	$password = md5($_POST['password']);	
    $row = $model->getDetailUser($user_id);
    if ($password == $row['password'])
        echo "1";
    else
        echo "0";

	exit();

}elseif($act == "privis"){

	$user_id = (int) $_POST['user_id'];
	$privi= $_POST['privi'];
	$model->deletePrivi($user_id);
    if(!empty($privi)){
    	foreach ($privi as $value) {
    		$model->insertPrivi($user_id,$value);
    	}
    }
	header('location:'.$url);

}elseif($act == "changepass"){

	$user_id = $_SESSION['user_id'];
	$password = md5($_POST['password']);
	$model->changePass($user_id,$password);
	session_destroy();    
	header('location:../login.php');

}else{

	$user_id = (int) $_POST['user_id'];
	$city_id = (int) $_POST['city_id'];

	$full_name = $model->processData($_POST['full_name']);
	$username = $model->processData($_POST['username']);
	$phone = $model->processData($_POST['phone']);
	$email = $model->processData($_POST['email']);
	$address = $model->processData($_POST['address']);
	$back_url = $_POST['back_url'];
	$status  = $_POST['status'];
	if($user_id > 0) {	

		$model->updateUser($user_id,$email,$full_name,$address,$city_id,$phone,$status);

		header('location:'.$url.$back_url);

	}else{

		$model->insertUser($username,$full_name,$email,$phone,$address,$city_id,$status);

		header('location:'.$url);

	}

}

?>