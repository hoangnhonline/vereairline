<?php 

$url = "../index.php?mod=manu&act=list";

require_once "../model/Backend.php";

$model = new Backend;

$id = (int) $_POST['manu_id'];

$manu_name = $model->processData($_POST['manu_name']);

$manu_alias = $model->changeTitle($manu_name);

$catetype_id = $_POST['catetype_id'];

$is_hot = (int) $_POST['is_hot'];

$hidden = (int) $_POST['hidden'];
if($id>0){
	$display_order = $_POST['display_order'];
}else{
	$display_order = $model->getOrderMax("manu") + 1;
}

$description = $_POST['description'];

$meta_title = $model->processData($_POST['meta_title']);

$meta_description = $model->processData($_POST['meta_description']);

$meta_keyword = $model->processData($_POST['meta_keyword']);

if($meta_title =='') $meta_title = $manu_name;
if($meta_description =='') $meta_description = $manu_name;
if($meta_keyword =='') $meta_keyword = $manu_name;

$image_url_upload = $_FILES['image_url_upload'];
if(($image_url_upload['name']!='')){
	$arrRe = $model->uploadImages($image_url_upload);	
	$image_url = $arrRe['filename'];
}else{
	$image_url = str_replace('../', '', $_POST['image_url']);
}

if($id > 0) {	
	
	$model->updateManu($id,$manu_name,$manu_alias,$description,$image_url,$is_hot,$display_order,$meta_title,$meta_description,$meta_keyword,$hidden,$catetype_id);

	header('location:'.$url);

}else{

	$model->insertManu($manu_name,$manu_alias,$description,$image_url,$is_hot,$display_order,$meta_title,$meta_description,$meta_keyword,$hidden,$catetype_id);

	header('location:'.$url);
}
?>
