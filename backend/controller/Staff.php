<?php 

$url = "../index.php?mod=staff&act=list";

require_once "../model/Staff.php";

$model = new Staff;

$staff_id = (int) $_POST['staff_id'];

$staff_name = $_POST['staff_name'];

$staff_name_alias = $model->changeTitle($staff_name);


$title = $_POST['title'];

$content = $_POST['content'];

$email = $_POST['email'];

$image_url = str_replace('../', '', $_POST['image_url']);


if($staff_id > 0) {	
	$model->updateStaff($staff_id,$staff_name,$staff_name_alias,$title,$email,$image_url,$content);		
}else{	
	$model->insertStaff($staff_name,$staff_name_alias,$title,$email,$image_url,$content);	
}

header('location:'.$url);


?>