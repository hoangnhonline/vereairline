<?php
$url = "../index.php?mod=addon&act=list";
require_once "../model/Addon.php";
$model = new Addon;

$addon_id = (int) $_POST['addon_id'];
$addon_name = $model->processData($_POST['addon_name']);

if($addon_id > 0) {
	$model->updateAddon($addon_id,$addon_name);
	header('location:'.$url);
}else{
	$model->insertAddon($addon_name);
	header('location:'.$url);
}

?>