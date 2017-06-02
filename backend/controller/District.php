<?php
$url = "../index.php?mod=district&act=list";
require_once "../model/District.php";
$model = new District;

$district_id = (int) $_POST['district_id'];
$district_name = $model->processData($_POST['district_name']);


if($district_id > 0) {
	$model->updateDistrict($district_id,$district_name);
	header('location:'.$url);
}else{
	$model->insertDistrict($district_name);
	header('location:'.$url);
}

?>