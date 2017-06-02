<?php 
session_start();
$url = "../index.php?mod=book&act=list";

require_once "../model/Backend.php";
$model = new Backend;

$arrParam = $_POST;
$arrParam['id'] = (int) $_POST['book_id'];
$arrParam['fullname'] = $model->processData($_POST['fullname']);
$arrParam['status'] = (int) ($_POST['status']);
$arrParam['adultNo'] = (int) ($_POST['adultNo']);
$arrParam['infantNo'] = (int) ($_POST['infantNo']);
$arrParam['childNo'] = (int) ($_POST['childNo']);
$arrParam['phone'] = $model->processData($_POST['phone']);
$arrParam['email'] = $model->processData($_POST['email']);
$arrParam['notes'] = $model->processData($_POST['notes']);
$arrParam['address'] = $model->processData($_POST['address']);

$back_url = $_POST['back_url'];
unset($arrParam['book_id']);
unset($arrParam['back_url']);

if($arrParam['id'] > 0) {		
	$model->update('booking',$arrParam);
	header('location:'.$url.$back_url);
}

?>