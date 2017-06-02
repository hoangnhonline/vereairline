<?php 

$url = "../index.php?mod=follow&act=list";

require_once "../model/Backend.php";

$model = new Backend;

$id = (int) $_POST['id'];

$name = $model->processData($_POST['name']);
$link_url = $_POST['link_url'];


if($id > 0) {	
	
	$model->updateFollow($id,$name,$link_url);

	header('location:'.$url);

}else{

	$model->insertFollow($name,$link_url);

	header('location:'.$url);
}
?>