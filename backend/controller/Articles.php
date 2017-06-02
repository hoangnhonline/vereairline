<?php 

$url = "../index.php?mod=articles&act=list";

require_once "../model/Backend.php";

$model = new Backend;

$article_id = (int) $_POST['article_id'];

$article_title = $model->processData($_POST['article_title']);
$title_en = $model->processData($_POST['title_en']);
$article_alias = $model->processData($_POST['article_alias']);

$description = $model->processData($_POST['description']);

$content = mysql_escape_string($_POST['content']);
$source = mysql_escape_string($_POST['source']);
$seo_text = mysql_escape_string($_POST['seo_text']);

$cate_id = (int) $_POST['cate_id'];

$is_hot = (int) $_POST['is_hot'];
$hidden = (int) $_POST['hidden'];

$image_url_upload = $_FILES['image_url_upload'];
if(($image_url_upload['name']!='')){
	$arrRe = $model->uploadImages($image_url_upload);	
	$image_url = $arrRe['filename'];
}else{
	$image_url = str_replace('../', '', $_POST['image_url']);
}


$meta_title = $model->processData($_POST['meta_title']);
$meta_keyword = $model->processData($_POST['meta_keyword']);
$meta_description = $model->processData($_POST['meta_description']);

if($meta_title=='') $meta_title = $page_name;
if($meta_keyword=='') $meta_keyword = $page_name;
if($meta_description=='') $meta_description = $page_name;


$arrTag = array();
$str_tag_new =  rtrim(trim($_POST['tags']),";")  ;
$str_tag = str_replace(',',';',$str_tag_new);		
$arrTag  = explode(";",$str_tag);
$back_url = $_POST['back_url'];
if($article_id > 0) {	
	
	$model->updateArticles($article_id,$article_title,$title_en,$article_alias,$image_url,$description,$content,$cate_id,$arrTag,$source,$is_hot,$meta_title,$meta_description,$meta_keyword,$hidden,$seo_text);

	header('location:'.$url.$back_url);

}else{

	$model->insertArticles($article_title,$title_en,$article_alias,$image_url,$description,$content,$cate_id,$arrTag,$source,$is_hot,$meta_title,$meta_description,$meta_keyword,$hidden,$seo_text);
	
	header('location:'.$url."&cate_id=".$cate_id);
}
?>