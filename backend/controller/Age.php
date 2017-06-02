<?php
$url = "../index.php?mod=age&act=list";
require_once "../model/Backend.php";
$model = new Backend;

$id = (int) $_POST['id'];
$range = $model->processData($_POST['range']);

if($id > 0) {
	$model->updateAgeRange($id,$range);
	header('location:'.$url);
}else{
	$model->insertAgeRange($range);
	header('location:'.$url);
}

?>