<?php 
session_start();
require_once "../model/Backend.php";
$model = new Backend;
$url = "../index.php?mod=city&act=list";
$arrParam['city_name'] = $model->processData($_POST['city_name']);
$arrParam['city_alias'] = $model->changeTitle($arrParam['city_name']);
$arrParam['display_order'] = $model->getOrderMax("city");
$city_id = (int) $_POST['city_id'];
$table = "city";
if($city_id > 0) {	
	$arrParam['city_id'] = $city_id;
	$model->update($table, $arrParam);
}else{
	$model->insert($table, $arrParam);
}
header('location:'.$url);
?>