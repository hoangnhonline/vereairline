<?php
if(!isset($_SESSION)){
    session_start();
}
require_once 'models/Home.php';
$model = new Home;
$mod = isset($_GET['mod']) ? $_GET['mod'] : "";
$arrText = $model->getListText();
function checkCat($uri) {
    require_once 'models/Home.php';
    $model = new Home; 

    $uri = str_replace("+", "", $uri);

    $p_detail = '#chi-tiet/[a-z0-9\-\+]+\-\d+.html#';
    $p_detail_news = '#chi/[a-z0-9\-\+]+\-\d+.html#';
    $p_cate_page = '#/[a-z0-9\-\+]+.html#';
    $p_cate_news = '#danh-muc/[a-z0-9\-\+]+\-\d+.html#';
    $p_detail_event = '#su-kien/[a-z0-9\-\+]+\-\d+.html#';
    $p_tag = '#/tag/[a-z\-]+.html#';
    $p_contact = '#/lien-he+.html#';    
    $p_order = '#/quan-ly-don-hang+.html#';
    $p_orderdetail = '#/chi-tiet-don-hang+.html#';
    $p_info = '#/cap-nhat-thong-tin+.html#';
    $p_changepass = '#/doi-mat-khau+.html#';
    $p_logout = '#/thoat+.html#';
    $p_hot = '#/[a-z0-9\-]+\-+c+\d+h+\d+.html#';
    $p_sale = '#/[a-z0-9\-]+\-+c+\d+s+\d+.html#';
   

    $p_cart = '#/gio-hang+.html#';
    $p_register = '#/dang-ky+.html#';
    $p_about = '#/gioi-thieu+.html#';
    $p_thanhtoan = '#/thanh-toan+.html#';
    $p_tintuc = '#/tin-tuc+.html#';
    $p_cate =  '#/[a-z0-9\-]+\-+p+\d+.html#';    
    $p_content =  '#/[a-z0-9\-]+\-+c+\d+.html#';
    $p_search = '#/tim-kiem+.html#';
    
    $mod = $seo = "";
    $object_id = 0;   
    
    if(strpos($uri, 'chi-tiet/')){

        $mod = "detail";
        
    }elseif(strpos($uri, 'tin-tuc/')){

        $mod = "detail-news";
        
    }elseif(strpos($uri, 'tim-kiem.')){

        $mod = "search";
        
    }elseif(strpos($uri, 'yeu-cau-dat-ve.')){

        $mod = "request";
        
    }elseif(strpos($uri, 'nhap-thong-tin.')){
        if(empty($_SESSION['booking'])){
            header('location:http://'.$_SESSION['SERVER_NAME']);
        }else{
            $mod = "booking";
        }
        
    }else{        
        
        if (preg_match($p_search, $uri)) {
            $mod = "search";        
        }   
        if (preg_match($p_cate_page, $uri)) {
            $uri = str_replace("/", '', $uri);         
            $tmp = explode(".", $uri);
            
            if($tmp[0] == "lien-he"){
                $mod = "contact";
            }elseif($tmp[0] =="tin-tuc"){
                $mod = "news";
                $seo = $model->getDetailSeo(4);
            }else{
                $row = $model->getDetailAlias($tmp[0]);
                $mod = $row['type'] == 1 ? "cate" : "content";                
                $object_id = $row['object_id'];
                if($mod=="cate"){
                    $detailCate = $seo = $model->getDetailCateArticles($object_id); 
                }
            }
        }   
       
        if (preg_match($p_about, $uri)) {
            $mod = "about";
            $seo = $model->getDetailSeo(2);
        }        
        
        if (preg_match($p_detail_news, $uri)) {
            $mod = "detail-news";
        }
        if (preg_match($p_detail_event, $uri)) {
            $mod = "detail-event";
        }
        if (preg_match($p_tintuc, $uri)) {
            $mod = "news";
            $seo = $model->getDetailSeo(4);
        }
        if (preg_match($p_cate_news, $uri)) {
            $mod = "cate-news";
        }        
        
        if (preg_match($p_content, $uri)) {
            $mod = "content";
        }
        if (preg_match($p_hot, $uri) || preg_match($p_sale, $uri)) {
            $mod = "catetype";
        }
        
        if (preg_match($p_contact, $uri)) {
            $mod = "contact";        
        }       
       
    }
    return array("seo"=>$seo, "mod" =>$mod,'object_id' => $object_id);
}

$uri = $_SERVER['REQUEST_URI'];

$arrRS = checkCat($uri);
$mod = $arrRS['mod'];
$object_id = $arrRS['object_id']; 

$uri = str_replace(".html", "", $uri);
$tmp_uri = explode("/", $uri);

switch ($mod) {    
           
    case "search" : 
        $seo = $model->getDetailSeo(10);
        break;    
    case "contact": 
        $seo = $model->getDetailSeo(3);              
        break;    
    case "detail":
        $article_alias = $tmp_uri[2];   
        $article_id = $model->getArticleId($article_alias);
        $data = $seo = $model->getDetailArticles($article_id);   
        $cate_id = $data['cate_id'];         
        $detailCate =  $model->getDetailCateArticles($cate_id);     
        break;
    case "detail-news":
        $article_alias = $tmp_uri[2];   
        $article_id = $model->getArticleId($article_alias);
        $data = $seo = $model->getDetailArticles($article_id);   
        $cate_id = $data['cate_id'];    
        $detailCate =  $model->getDetailCateArticles($cate_id);     
        break;    
    case "detail-event":
        $tieude_id = $tmp_uri[2];   
        $arr = explode("-", $tieude_id);
        $banner_id = (int) end($arr);        
        $data = $model->getDetailBanner($banner_id);  
        $seo['meta_title'] = $data['name_event'];
        $seo['meta_description'] = $data['name_event'];
        $seo['meta_keyword'] = $data['name_event'];
        break;                     
    case "cate":
        $cate_id = (int) $arrRS['object_id'];
        $seo = $arrRS['seo'];
        break; 
    case "content":        
        $page_id = $object_id;
        $data = $seo = $model->getDetailPage($page_id);
        break;
    case "page":

        $rs_article = $modelHome->getDetailPage($page_id);
        $arrDetailPage = mysql_fetch_assoc($rs_article);
        break;
    default :    
        $seo = $model->getDetailSeo(1);
        break;
}
?>
