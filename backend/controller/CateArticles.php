<?php 

$url = "../index.php?mod=cate_articles&act=list";

require_once "../model/Backend.php";

$model = new Backend;

$id = (int) $_POST['cate_id'];

$cate_name = $model->processData($_POST['cate_name']);

$cate_alias = $model->processData($_POST['cate_alias']);

$is_hot = (int) $_POST['is_hot'];

$hidden = (int) $_POST['hidden'];

$meta_title = $model->processData($_POST['meta_title']);

$meta_description = $model->processData($_POST['meta_description']);

$meta_keyword = $model->processData($_POST['meta_keyword']);

if($meta_title =='') $meta_title = $cate_name;
if($meta_description =='') $meta_description = $cate_name;
if($meta_keyword =='') $meta_keyword = $cate_name;

$image_url_upload = $_FILES['image_url_upload'];
if(($image_url_upload['name']!='')){
	$arrRe = $model->uploadImages($image_url_upload);	
	$image_url = $arrRe['filename'];
}else{
	$image_url = str_replace('../', '', $_POST['image_url']);
}

$description = $model->processData($_POST['description']);

$seo_text = mysql_real_escape_string($_POST['seo_text']);

if($id > 0) {	
	
	$model->updateCateArticles($id,$cate_name,$cate_alias,$image_url,$description,$meta_title,$meta_description,$meta_keyword,$is_hot,$hidden,$seo_text);

	header('location:'.$url);

}else{

	$model->insertCateArticles($cate_name,$cate_alias,$image_url,$description,$meta_title,$meta_description,$meta_keyword,$is_hot,$hidden,$seo_text);

	header('location:'.$url);
}
?>