<?php
$url = "../index.php?mod=text&act=list";
require_once "../model/Backend.php";
$model = new Backend;

$id = (int) $_POST['id'];
$text = $_POST['content'];

if($id > 0) {
	$model->updateText($id,$text);
	header('location:'.$url);
}else{
	$model->insertText($text);
	header('location:'.$url);
}

?>