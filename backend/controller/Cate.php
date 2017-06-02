<?php 

$url = "../index.php?mod=cate&act=list";

require_once "../model/Backend.php";

$model = new Backend;

$id = (int) $_POST['cate_id'];

$arrData['cate_type_id'] = $cate_type_id = (int) $_POST['cate_type_id'];

$arrData['parent_id'] = $parent_id = (int) $_POST['parent_id'];

$arrData['cate_name'] = $cate_name = $model->processData($_POST['cate_name']);

$arrData['cate_alias'] = $cate_alias = $model->processData($_POST['cate_alias']);

$arrData['is_hot'] = $is_hot = (int) $_POST['is_hot'];
$arrData['hidden'] = $hidden = (int) $_POST['hidden'];

if($id > 0){
	$arrData['display_order'] = $display_order = $_POST['display_order'];
}else{
	$arrData['display_order'] = $display_order = $model->getOrderMax("cate") + 1;
}

$arrData['content'] = $content = mysql_real_escape_string($_POST['content']);

$arrData['seo_text'] = $seo_text = mysql_real_escape_string($_POST['seo_text']);

$meta_title = $model->processData($_POST['meta_title']);

$meta_description = $model->processData($_POST['meta_description']);

$meta_keyword = $model->processData($_POST['meta_keyword']);

if($meta_title =='') $meta_title = $cate_name;
if($meta_description =='') $meta_description = $cate_name;
if($meta_keyword =='') $meta_keyword = $cate_name;

$arrData['meta_title'] = $meta_title;
$arrData['meta_description'] = $meta_description;
$arrData['meta_keyword'] = $meta_keyword;
$image_url_upload = $_FILES['image_url_upload'];
$icon_url_upload = $_FILES['icon_url_upload'];

if(($image_url_upload['name']!='')){
	$arrRe = $model->uploadImages($image_url_upload);	
	$image_url = $arrRe['filename'];
}else{
	$image_url = str_replace('../', '', $_POST['image_url']);
}
$arrData['image_url'] = $image_url;
if(($icon_url_upload['name']!='')){
	$arrRe = $model->uploadImages($icon_url_upload);	
	$icon_url = $arrRe['filename'];
}else{
	$icon_url = str_replace('../', '', $_POST['icon_url']);
}

$arrData['icon_url'] = $icon_url;

if($id > 0) {	
	$arrData['id'] = $id;
	$model->update('cate', $arrData);
	$url_id = $model->getUrlId($id, 1); // 1 : cate
	if($url_id > 0){
		$model->updateAlias($url_id, $cate_alias);
	}else{
		$model->insertAlias($cate_alias, $id, 1);	
	}		
	$model->update('cate', $arrData);
	if($parent_id > 0){
		header('location:../index.php?mod=cate&act=list-child&parent_id='.$parent_id);
	}else{
		header('location:'.$url.'&cate_type_id='.$cate_type_id);
	}	
}else{
	$id = $model->insert('cate', $arrData);
	$model->insertAlias($cate_alias, $id, 1);

	if($parent_id > 0){
		header('location:../index.php?mod=cate&act=list-child&parent_id='.$parent_id);
	}else{
		header('location:'.$url.'&cate_type_id='.$cate_type_id);
	}	
}
?>
