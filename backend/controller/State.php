<?php 
session_start();
require_once "../model/Backend.php";
$model = new Backend;
$url = "../index.php?mod=state&act=list";
$arrParam['state_name'] = $model->processData($_POST['state_name']);
$arrParam['state_alias'] = $model->changeTitle($arrParam['state_name']);

$arrParam['city_id'] = $city_id = (int) $_POST['city_id'];
$state_id = (int) $_POST['state_id'];
$arrParam['display_order'] = $model->getOrderMaxState("state", $city_id);
$table = "state";
if($state_id > 0) {	
	$arrParam['id'] = $state_id;
	$model->update($table, $arrParam);
}else{
	$model->insert($table, $arrParam);
}
header('location:'.$url."&city_id=".$city_id);
?>