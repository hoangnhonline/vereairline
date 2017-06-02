<?php 

$url = "../index.php?mod=client&act=list";

require_once "../model/Backend.php";

$model = new Backend;

$id = (int) $_POST['id'];

$name_vi = $model->processData($_POST['name_vi']);
$job_vi = $model->processData($_POST['job_vi']);
$content_vi = $model->processData($_POST['content_vi']);

$name_en = $model->processData($_POST['name_en']);
$job_en = $model->processData($_POST['job_en']);
$content_en = $model->processData($_POST['content_en']);

$image_url = str_replace('../', '', $_POST['image_url']);

if($id > 0) {	
	
	$model->updateClient($id,$name_vi,$job_vi,$content_vi,$name_en,$job_en,$content_en,$image_url);

	header('location:'.$url);

}else{

	$model->insertClient($name_vi,$job_vi,$content_vi,$name_en,$job_en,$content_en,$image_url);

	header('location:'.$url);
}
?>