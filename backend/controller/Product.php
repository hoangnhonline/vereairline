<?php 

$url_return = "../index.php?mod=product&act=list";

require_once "../model/Backend.php";

$model = new Backend;

$id = (int) $_POST['product_id'];

$arrColor = $arrSize = array();

$table = "product";

$arr['cate_type_id'] = $cate_type_id = $_POST['cate_type_id'];

$arr['cate_id'] = $cate_id = $_POST['cate_id'];

$arr['product_code'] = $product_code = $model->processData($_POST['product_code']);
$arr['product_name'] = $product_name = $model->processData($_POST['product_name']);
$arr['name_en'] = $name_en = $model->processData($_POST['name_en']);

$arr['product_alias'] = $product_alias = $model->changeTitle($product_name);

$arr['is_hot'] = $is_hot = (int) $_POST['is_hot'];
$arr['is_new'] = $is_new = (int) $_POST['is_new'];
$arr['hidden'] = $hidden = (int) $_POST['hidden'];
$arr['is_end'] = $is_end = (int) $_POST['is_end'];
$arr['is_saleoff'] = $is_saleoff = (int) $_POST['is_saleoff'];

$arr['percent_deal'] = $percent_deal = $_POST['percent_deal'];

$arr['price'] = $price = str_replace(",","", $_POST['price']);
$arr['price_saleoff'] = $price_saleoff = str_replace(",","", $_POST['price_saleoff']);

$arr['description'] = $description = nl2br($_POST['description']);

$arr['content'] = $content = mysql_real_escape_string($_POST['content']);

$meta_title = $model->processData($_POST['meta_title']);

$meta_description = $model->processData($_POST['meta_description']);

$meta_keyword = $model->processData($_POST['meta_keyword']);

$product_for = "";
$productForArr = $_POST['product_for'];
if(!empty($productForArr)){
    $product_for = implode(",", $productForArr);
}
$arr['product_for'] = $product_for;

$arr['created_at'] = time();
$arr['updated_at'] = time();
$arr['created_by'] = $_SESSION['user']['user_id'];
$arr['updated_by'] = $_SESSION['user']['user_id'];

if($meta_title =='') $meta_title = $product_name;
if($meta_description =='') $meta_description = $product_name;
if($meta_keyword =='') $meta_keyword = $product_name;

$arr['meta_title'] = $meta_title;
$arr['meta_description'] = $meta_description;
$arr['meta_keyword'] = $meta_keyword;
$arr['image_url'] = $image_url = str_replace('../', '', $_POST['image_url']);

$str_image = $_POST['str_image'];

$arrColor = $_POST['color'];

$arrSize = $_POST['size'];
if($id > 0) {	
	$arr['id'] = $id;
	$model->update($table,$arr);
	$arrTmp = array();
    if($str_image){
        $arrTmp = explode(';', $str_image);
    }            
    if(!empty($arrTmp)){
        foreach ($arrTmp as $url1) {
            if($url1){                       
                $url_1 =  str_replace('.', '_2.', $url1);                        
                mysql_query("INSERT INTO images VALUES(null,'$url1','$url_1',$id,1,1)");                
            }
        }
    }
    /* size */
    mysql_query("DELETE FROM product_size WHERE product_id = $id");
    if(!empty($arrSize)){
        foreach ($arrSize as $size_id) {
            if($size_id > 0){                                       
                mysql_query("INSERT INTO product_size VALUES($id,$size_id)");                
            }
        }
    }
    /* color */
    mysql_query("DELETE FROM product_color WHERE product_id = $id");
    if(!empty($arrColor)){
        foreach ($arrColor as $color_id) {
            if($color_id > 0){                                       
                mysql_query("INSERT INTO product_color VALUES($id,$color_id)");                
            }
        }
    }
	header('location:'.$url);
}else{
	$id = $model->insert($table,$arr);  
	$arrTmp = array();
    if($str_image){
        $arrTmp = explode(';', $str_image);
    }    
    if(!empty($arrTmp)){
        foreach ($arrTmp as $url) {
            if($url){                       
                $url_1 =  str_replace('.', '_2.', $url);                        
                mysql_query("INSERT INTO images VALUES(null,'$url','$url_1',$id,1,1)");
            }
        }
    }	
    /* size */
    mysql_query("DELETE FROM product_size WHERE product_id = $id");
    if(!empty($arrSize)){
        foreach ($arrSize as $size_id) {
            if($size_id > 0){                                       
                mysql_query("INSERT INTO product_size VALUES($id,$size_id)");                
            }
        }
    }
    /* color */
    mysql_query("DELETE FROM product_color WHERE product_id = $id");
    if(!empty($arrColor)){
        foreach ($arrColor as $color_id) {
            if($color_id > 0){                                       
                mysql_query("INSERT INTO product_color VALUES($id,$color_id)");                
            }
        }
    }
}
header('location:'.$url_return.'&cate_type_id='.$cate_type_id.'&cate_id='.$cate_id);