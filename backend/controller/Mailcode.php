<?php 

$url = "../index.php?mod=promotion_code&act=listmail";

require_once "../model/Rating.php";

$model = new Rating;


$code_id = (int) $_POST['code_id'];

$list_email = $model->processData($_POST['list_email']);


if($code_id > 0 && $list_email != ''){
	$model->insertMailNhanCode($code_id,$list_email);
}

header('location:'.$url);


?>