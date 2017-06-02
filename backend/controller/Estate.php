<?php
$url = "../index.php?mod=estate_type&act=list";
require_once "../model/Estate.php";
$model = new Estate;

$estate_type_id = (int) $_POST['estate_type_id'];
$estate_type_name = $model->processData($_POST['estate_type_name']);
$estate_alias = $model->changeTitle($estate_type_name);


if($estate_type_id > 0) {
	$model->updateEstate($estate_type_id,$estate_type_name,$estate_alias);
	header('location:'.$url);
}else{
	$model->insertEstate($estate_type_name,$estate_alias);
	header('location:'.$url);
}

?>