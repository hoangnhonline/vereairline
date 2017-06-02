<?php 

$url = "../index.php?mod=portfolio&act=list";

require_once "../model/Backend.php";

$model = new Backend;

$id = (int) $_POST['id'];

$portfolio_name_vi = $model->processData($_POST['portfolio_name_vi']);
$portfolio_name_en = $model->processData($_POST['portfolio_name_en']);

$portfolio_alias = $model->changeTitle($portfolio_name_vi);

$description_vi = $model->processData($_POST['description_vi']);

$client_en = $_POST['client_en'];

$description_en = $model->processData($_POST['description_en']);

$client_vi = $_POST['client_vi'];
$text_link_vi = $_POST['text_link_vi'];
$text_link_en = $_POST['text_link_en'];

$link_url =  $_POST['link_url'];

$cate_id = (int) $_POST['cate_id'];

$image_url = str_replace('../', '', $_POST['image_url']);

if($id > 0) {	
	
	$model->updatePortfolio($id,$portfolio_name_vi,$portfolio_name_en,$portfolio_alias,$image_url,$description_vi,$description_en,$text_link_vi,$text_link_en,$client_vi,$client_en,$link_url,$cate_id);

	header('location:'.$url.'&cate_id='.$cate_id);

}else{

	$model->insertPortfolio($portfolio_name_vi,$portfolio_name_en,$portfolio_alias,$image_url,$description_vi,$description_en,$text_link_vi,$text_link_en,$client_vi,$client_en,$link_url,$cate_id);

	header('location:'.$url.'&cate_id='.$cate_id);
}
?>