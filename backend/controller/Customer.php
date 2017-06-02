<?php 

$url = "../index.php?mod=customer&act=list";

require_once "../model/Backend.php";

$model = new Backend;

$id = (int) $_POST['id'];

$full_name = $model->processData($_POST['full_name']);
$phone = $model->processData($_POST['phone']);
$handphone = $model->processData($_POST['handphone']);
$address = $model->processData($_POST['address']);
$email = $model->processData($_POST['email']);
$username = $model->processData($_POST['username']);
$status = (int) $_POST['status'];
$back_url = $_POST['back_url'];

if($id > 0) {	
	
	$model->updateCustomer($id,$full_name,$phone,$handphone,$address,$email,$username,$status);

	header('location:'.$url.$back_url);

}
?>
