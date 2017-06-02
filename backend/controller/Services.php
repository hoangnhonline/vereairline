<?php 
$url = "../index.php?mod=services&act=list";
require_once "../model/Services.php";
$model = new Services;

$service_id = (int) $_POST['service_id'];
$service_name_vi = $model->processData($_POST['service_name_vi']);
$service_name_en = $model->processData($_POST['service_name_en']);

$service_name_safe_vi = $model->changeTitle($service_name_vi);
$service_name_safe_en = $model->changeTitle($service_name_en);

if($service_id > 0) {	
	$model->updateService($service_id,$service_name_vi,$service_name_en,$service_name_safe_vi,$service_name_safe_en);
	header('location:'.$url);
}else{
	$model->insertService($service_name_vi,$service_name_en,$service_name_safe_vi,$service_name_safe_en);
	header('location:'.$url);
}

?>