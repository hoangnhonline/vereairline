<?php 

$url = "../index.php?mod=catetype&act=list";

require_once "../model/Backend.php";

$model = new Backend;

$id = (int) $_POST['cate_type_id'];

$cate_type_name = $model->processData($_POST['cate_type_name']);
$description = $model->processData($_POST['description']);

$cate_type_alias = $model->changeTitle($cate_type_name);

$is_menu = (int) $_POST['is_menu'];
$hidden = (int) $_POST['hidden'];

if($id>0){
	$display_order = $_POST['display_order'];
}else{
	$display_order = $model->getOrderMax("cate_type") + 1;
}

$image_url_upload = $_FILES['image_url_upload'];
$icon_url_upload = $_FILES['icon_url_upload'];
if(($image_url_upload['name']!="")){
	$arrRe = $model->uploadImages($image_url_upload);	
	$image_url = $arrRe['filename'];
}else{
	$image_url = str_replace('../', '', $_POST['image_url']);
}
if(($icon_url_upload['name']!="")){
	$arrRe = $model->uploadImages($icon_url_upload);	
	$icon_url = $arrRe['filename'];
}else{
	$icon_url = str_replace('../', '', $_POST['icon_url']);
}

$meta_title = $model->processData($_POST['meta_title']);

$meta_description = $model->processData($_POST['meta_description']);

$meta_keyword = $model->processData($_POST['meta_keyword']);

if($meta_title =='') $meta_title = $cate_type_name;
if($meta_description =='') $meta_description = $cate_type_name;
if($meta_keyword =='') $meta_keyword = $cate_type_name;

if($id > 0) {	
	
	$model->updateCateType($id,$cate_type_name,$cate_type_alias,$description,$image_url,$icon_url,$is_menu,$display_order,$hidden,$meta_title,$meta_description,$meta_keyword);

	header('location:'.$url);

}else{

	$model->insertCateType($cate_type_name,$cate_type_alias,$description,$image_url,$icon_url,$is_menu,$display_order,$hidden,$meta_title,$meta_description,$meta_keyword);

	header('location:'.$url);
}

?>
