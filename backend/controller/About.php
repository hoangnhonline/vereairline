<?php 

$url = "../index.php?mod=about&act=form&id=1";

require_once "../model/Backend.php";

$model = new Backend;

$id = (int) $_POST['id'];

$name_1_vi = $model->processData($_POST['name_1_vi']);
$name_2_vi = $model->processData($_POST['name_2_vi']);

$content_1_vi = $_POST['content_1_vi'];
$content_2_vi = $_POST['content_2_vi'];

$name_1_en = $model->processData($_POST['name_1_en']);
$name_2_en = $model->processData($_POST['name_2_en']);

$content_1_en = $_POST['content_1_en'];
$content_2_en = $_POST['content_2_en'];

$image_url = str_replace('../', '', $_POST['image_url']);

if($id > 0) {	
	
	$model->updateAbout($id,$name_1_vi,$content_1_vi,$image_url,$name_2_vi,$content_2_vi,$name_1_en,$name_2_en,$content_1_en,$content_2_en);

	header('location:'.$url.'&mess=Success');

}
?>