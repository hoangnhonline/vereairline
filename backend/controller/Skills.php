<?php 

$url = "../index.php?mod=skills&act=list";

require_once "../model/Backend.php";

$model = new Backend;

$id = (int) $_POST['id'];

$name_vi = $model->processData($_POST['name_vi']);
$name_en = $model->processData($_POST['name_en']);
$point = (int) $_POST['point'];


if($id > 0) {	
	
	$model->updateSkills($id,$name_vi,$name_en,$point);

	header('location:'.$url);

}else{

	$model->insertSkills($name_vi,$name_en,$point);

	header('location:'.$url);
}
?>