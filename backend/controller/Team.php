<?php 

$url = "../index.php?mod=team&act=list";

require_once "../model/Backend.php";

$model = new Backend;

$id = (int) $_POST['id'];

$name_vi = $model->processData($_POST['name_vi']);
$name_en = $model->processData($_POST['name_en']);
$job_en = $model->processData($_POST['job_en']);

$alias = $model->changeTitle($name_vi);

$job_vi = $model->processData($_POST['job_vi']);

$twitter_url = $_POST['twitter_url'];
$fb_url =  $_POST['fb_url'];

$display_order = (int) $_POST['display_order'];

$image_url = str_replace('../', '', $_POST['image_url']);

if($id > 0) {	
	
	$model->updateTeam($id,$name_vi,$name_en,$alias,$job_vi,$job_en,$image_url,$twitter_url,$fb_url,$display_order);

	header('location:'.$url);

}else{

	$model->insertTeam($name_vi,$name_en,$alias,$job_vi,$job_en,$image_url,$twitter_url,$fb_url,$display_order);

	header('location:'.$url);
}
?>