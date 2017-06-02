<?php 

$url = "../index.php?mod=seo&act=list";

require_once "../model/Backend.php";

$model = new Backend;
$id = (int) $_POST['id'];


$meta_title = $model->processData($_POST['meta_title']);
$meta_keyword = $model->processData($_POST['meta_keyword']);
$meta_description = $model->processData($_POST['meta_description']);
$seo_text = ($_POST['seo_text']);


$model->updateSeo($id,$meta_title,$meta_keyword,$meta_description,$seo_text);

header('location:'.$url);




?>