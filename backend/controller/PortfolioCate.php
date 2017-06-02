<?php 

$url = "../index.php?mod=portfolio_cate&act=list";

require_once "../model/Backend.php";

$model = new Backend;

$id = (int) $_POST['cate_id'];

$cate_name_vi = $model->processData($_POST['cate_name_vi']);
$cate_name_en = $model->processData($_POST['cate_name_en']);

$cate_alias = $model->changeTitle($cate_name_vi);

if($id > 0) {	
	
	$model->updatePortfolioCate($id,$cate_name_vi,$cate_name_en,$cate_alias);

	header('location:'.$url);

}else{

	$model->insertPortfolioCate($cate_name_vi,$cate_name_en,$cate_alias);

	header('location:'.$url);
}
?>