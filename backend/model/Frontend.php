<?php
class Fontend {
  
    //private $host = "localhost";
    //private $user = "thietken_box";
    //private $pass = "12345!@#";
    //private $db = "thietken_box";


    function __construct() {
	if($_SERVER['SERVER_NAME']=='dongho.com'){
		mysql_connect('localhost', 'root', '') or die("Can't connect to server");
	        mysql_select_db('dongho') or die("Can't connect database");
	}else{
		   mysql_connect('localhost', 'vereairlin7c3a', 'bc33b31aa434a6c3') or die("Can't connect to server");
                mysql_select_db('vereairline_7c3a') or die("Can't connect database");  
	}
        mysql_query("SET NAMES 'utf8'") or die(mysql_error());
    }
    function processData($str) {
        $str = trim(strip_tags($str));
        if (get_magic_quotes_gpc() == false) {
            $str = mysql_real_escape_string($str);
        }
        return $str;
    }
    function getListEvent($banner_id){
        $arrReturn = array();
        $sql = "SELECT * FROM banner WHERE type_id = 2 AND id <> $banner_id ORDER BY id DESC LIMIT 0,5";        
        $rs = mysql_query($sql) or die(mysql_error());
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[] = $row;
        }
        return $arrReturn;
    }
    function getListCity(){
        $arrReturn = array();
        $sql = "SELECT * FROM city ORDER BY display_order ASC";        
        $rs = mysql_query($sql) or die(mysql_error());
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[] = $row;
        }
        return $arrReturn;
    }
    function getListStateByCity($city_id){
        $arrReturn = array();
        $sql = "SELECT * FROM state WHERE city_id = $city_id ORDER BY display_order ASC";        
        $rs = mysql_query($sql) or die(mysql_error());
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[] = $row;
        }
        return $arrReturn;
    }

    function getListDeal(){
        $arrReturn = array();
        $sql = "SELECT * FROM product WHERE is_saleoff = 1 AND (deal_amount > 0 OR da_ban > 0 ) ORDER BY RAND() LIMIT 0,5";        
        $rs = mysql_query($sql) or die(mysql_error());
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[] = $row;
        }
        return $arrReturn;
    }
    function getDetailSeo($id) {
        $arrReturn = array();      
        $sql = "SELECT * FROM seo WHERE id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row =mysql_fetch_assoc($rs);
        $arrReturn = $row;           
        return $arrReturn;
    }
    function changePass($password,$id){
        $sql = "UPDATE customer SET password='$password' WHERE id = $id";
        mysql_query($sql) or die(mysql_error());
    }
    function checkOldPass($password,$id){
        $sql = "SELECT id FROM customer WHERE id = $id AND password = '$password'";        
        $rs = mysql_query($sql) or die(mysql_error());
        if(mysql_num_rows($rs)==1){
            return true;
        }else{
            return false;
        }
    }
    function getListDetailManuCateType($catetype_id){
        $arrReturn = array();
        $sql = "SELECT * FROM manu_catetype WHERE catetype_id = $catetype_id";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $manu_id = $row['manu_id'];  
            $rs2 = mysql_query("SELECT manu_name, image_url FROM manu WHERE id = $manu_id");
            while($row1=mysql_fetch_assoc($rs2)){
                $arrReturn[] = $row1;
            }                      
        }
        return $arrReturn;
    }
     function getListOrderCustomer(){
        $arrResult = array();

        try{
            $customer_id = $_SESSION['user']['id'];
            $sql = "SELECT orders.* FROM orders WHERE  customer_id = $customer_id ";           
            $sql.=" ORDER BY orders.created_at DESC ";            
 
            $rs = mysql_query($sql) or die(mysql_error());//$this->throw_ex(mysql_error());  
            while($row = mysql_fetch_assoc($rs)){
                $arrResult['data'][] = $row; 
            }
            $arrResult['total'] = mysql_num_rows($rs);

        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Order','function' => 'getListOrderCustomer' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
        
        return $arrResult;
    }
    function getListArticles($cate_id=-1, $offset,$limit){
        $arrReturn = array();
        $sql = "SELECT * FROM articles WHERE hidden = 0 AND (cate_id = $cate_id OR $cate_id = -1) ORDER BY article_id DESC ";
        if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit"; 
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
               $arrReturn['data'][] = $row;
            }
            $arrReturn['total'] = mysql_num_rows($rs);     
        return $arrReturn;
    }
    function getListArticlesNew($limit){
        $arrReturn = array();
        $sql = "SELECT * FROM articles WHERE hidden = 0 ORDER BY article_id DESC ";
        
                $sql .= " LIMIT 0,$limit"; 
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[] = $row;
        }
            
        return $arrReturn;
    }
    function getListArticlesCate(){
        $arrReturn = array();
        $sql = "SELECT * FROM article_cate WHERE hidden = 0";        
        $rs = mysql_query($sql) or die(mysql_error());
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[] = $row;
        }
        return $arrReturn;
    }
    function getDetailBanner($id){
        $arrReturn = array();
        $sql = mysql_query("SELECT * FROM banner WHERE id = $id");
        $arrReturn = mysql_fetch_assoc($sql);        
        return $arrReturn;
    }
    function getOrderIdMax(){
        $sql = "SELECT MAX(order_id) as max FROM orders ";
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        return $row['max'] + 1;
    }
    function getDetailCateArticles($cate_id){
        $arrReturn = array();
        $sql = mysql_query("SELECT * FROM article_cate WHERE cate_id = $cate_id");
        $arrReturn = mysql_fetch_assoc($sql);        
        return $arrReturn;
    }
    function getDetailCode($code){
        $arrReturn = array();
        $sql = mysql_query("SELECT * FROM promotion_code WHERE code = '$code'");
        $arrReturn = mysql_fetch_assoc($sql);        
        return $arrReturn;
    }
     function insertOrderDetail($order_id,$product_id,$product_name,$amount,$price,$total){
        $time = time();
        $sql = "INSERT INTO order_detail VALUES(NULL,$order_id,$product_id,'$product_name',$amount,$price,$total,$time,1)";
        mysql_query($sql);
    }
	function getListBannerByPosition($position_id,$limit=-1){
        $arrReturn = array();
        $sql = "SELECT * FROM banner WHERE position_id = $position_id ";
		if($limit > 0){
			$sql.=" LIMIT 0,$limit";
		}	
		$rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[] = $row;
        }
        return $arrReturn;
    }
    function getDetailBlockFooter($block_id){
        $arrReturn = array();
        $sql = "SELECT * FROM block WHERE block_id = $block_id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        $arrReturn['data'] = $row;   
        $sql1 = "SELECT * FROM link WHERE block_id = $block_id";
        $rs1 = mysql_query($sql1) or die(mysql_error());
        while($row1 = mysql_fetch_assoc($rs1)){
            $arrReturn['link'][] = $row1;
        }
        return $arrReturn;
    }
    function getListText(){
        $arrResult = array();
        $sql = "SELECT * FROM text";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrResult[$row['id']] = $row['text'];
        }
        return $arrResult;
    }
    function changeTitle($str) {
        $str = $this->stripUnicode($str);
        $str = str_replace("?", "", $str);
        $str = str_replace("&", "", $str);
        $str = str_replace("'", "", $str);
        $str = str_replace("  ", " ", $str);
        $str = trim($str);
        $str = mb_convert_case($str, MB_CASE_LOWER, 'utf-8'); // MB_CASE_UPPER/MB_CASE_TITLE/MB_CASE_LOWER
        $str = str_replace(" ", "-", $str);
        $str = str_replace("---", "-", $str);
        $str = str_replace("--", "-", $str);
        $str = str_replace('"', '', $str);
        $str = str_replace('"', "", $str);
        $str = str_replace(":", "", $str);
        $str = str_replace("(", "", $str);
        $str = str_replace(")", "", $str);
        $str = str_replace(",", "", $str);
        $str = str_replace(".", "", $str);
        $str = str_replace("?", "", $str);
        $str = str_replace("'", "", $str);
        $str = str_replace('"', "", $str);
        $str = str_replace("%", "", $str);
        for($i = 0;$i<=strlen($str);$i++){
            $str = str_replace(" ", "-", $str);
            $str = str_replace("--", "-", $str);
        }

        return $str;
    }
    function throw_ex($e){
        throw new Exception($e);
    }
    
    /* category */
    function getDetailCate($id) {
        $arrReturn = array();      
        $sql = "SELECT * FROM cate WHERE id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row =mysql_fetch_assoc($rs);
        $arrReturn = $row;           
        return $arrReturn;
    }
    function getListArticleByCate($cate_id){
        $arrReturn = array();
        $sql = "SELECT * FROM articles WHERE cate_id = $cate_id ORDER BY article_id DESC LIMIT 0,7";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[] = $row;
        }
        return $arrReturn;
    }
    function getListCate($cate_type_id=-1) {
        try{
            $arrReturn = array();
            $sql = "SELECT * FROM cate WHERE (cate_type_id = $cate_type_id OR $cate_type_id = -1) AND parent_id = 0 ";           
            $sql.=" AND status = 1 ";
            $rs = mysql_query($sql) or die(mysql_error());            
            while($row =mysql_fetch_assoc($rs)){
                $arrReturn[$row['id']] =  $row;            
                $rs1 = mysql_query("SELECT * FROM cate WHERE parent_id = ".$row['id']);
                while($row1 = mysql_fetch_assoc($rs1)){
                    $arrReturn[$row['id']]['child'][$row1['id']] = $row1;                
                    $rs2 = mysql_query("SELECT * FROM cate WHERE parent_id = ".$row1['id']);
                    while($row2 = mysql_fetch_assoc($rs2)){                    
                        $arrReturn[$row['id']]['child'][$row1['id']]['child'][$row2['id']] = $row2;
                    }
                }
            } 
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Cate','function' => 'getListCate' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
        return $arrReturn;
    }
    function getListCateNoTreeByParent($parent_id) {
        try{
            $arrReturn = array();
            $sql = "SELECT * FROM cate WHERE hidden = 0 AND parent_id = $parent_id ";                      
            $rs = mysql_query($sql) or die(mysql_error());            
            while($row =mysql_fetch_assoc($rs)){
                $arrReturn[$row['id']] =  $row;                            
            } 
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Cate','function' => 'getListCateNoTreeByParent' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
        return $arrReturn;
    }
    function getListCateNoTreeByParentMenu($parent_id) {
        try{
            $arrReturn = array();
            $sql = "SELECT * FROM cate WHERE hidden = 0 AND parent_id = $parent_id AND is_hot = 1 ORDER BY display_order ";                      
            $rs = mysql_query($sql) or die(mysql_error());            
            while($row =mysql_fetch_assoc($rs)){
                $arrReturn[$row['id']] =  $row;                            
            } 
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Cate','function' => 'getListCateNoTreeByParent' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
        return $arrReturn;
    }
    function getAgeRange(){
        try{
            $arrReturn = array();
            $sql = "SELECT * FROM age_range ";                      
            $rs = mysql_query($sql) or die(mysql_error());            
            while($row =mysql_fetch_assoc($rs)){
                $arrReturn[$row['id']] =  $row;                            
            } 
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Age','function' => 'getAgeRange' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
        return $arrReturn;   
    }
    /* manufacture */   
    function getDetailManu($id) {
        $arrReturn = array();      
        $sql = "SELECT * FROM manu WHERE id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row =mysql_fetch_assoc($rs);
        $arrReturn = $row;           
        return $arrReturn;
    }
    
    function getListManu($is_hot=-1) {
        try{
            $arrReturn = array();
            $sql = "SELECT * FROM manu WHERE (is_hot = $is_hot OR $is_hot = -1) AND hidden = 0 ";                       
            $rs = mysql_query($sql) or die(mysql_error());            
            while($row =mysql_fetch_assoc($rs)){
                $arrReturn[$row['id']] =  $row;                           
            } 
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Manu','function' => 'getListManu' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
        return $arrReturn;
    }
    /* pages */
    
    function getDetailPage($id) {
        $arrReturn = array();      
        $sql = "SELECT * FROM pages WHERE id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row =mysql_fetch_assoc($rs);
        $arrReturn = $row;           
        return $arrReturn;
    }
    
    function getListPage($is_hot=-1) {
        try{
            $arrReturn = array();
            $sql = "SELECT * FROM pages WHERE (is_hot = $is_hot OR $is_hot = -1) AND status = 1 ";                       
            $rs = mysql_query($sql) or die(mysql_error());            
            while($row =mysql_fetch_assoc($rs)){
                $arrReturn[$row['id']] =  $row;                           
            } 
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Page','function' => 'getListPage' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
        return $arrReturn;
    }

    /* product */    
    function getListProductHomePage($cate_type_id,$limit){
        $arrReturn = array();
        $sql = "SELECT * FROM product WHERE is_hot = 1 AND cate_type_id = $cate_type_id ORDER BY id DESC LIMIT 0,$limit";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[$row['id']] = $row;
        }
        return $arrReturn;
    } 
     function getListProductNoiBat($offset=-1,$limit=-1){
        $arrReturn = array();
        $sql = "SELECT * FROM product WHERE is_hot = 1  ORDER BY id DESC ";
        if ($limit > 0 && $offset >= 0){
            $sql .= " LIMIT $offset,$limit";
        }        
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
               $arrReturn['data'][] = $row;
        }
        $arrReturn['total'] = mysql_num_rows($rs);    
        return $arrReturn;
    } 
    function getListProductSearch($keyword,$offset=-1,$limit=-1){
        $keyword = $this->processData($keyword);
        $arrReturn = array();
        $sql = "SELECT * FROM product WHERE ( product_name LIKE '%".$keyword."%' ) OR ( product_code LIKE '%".$keyword."%' ) AND hidden = 0  ORDER BY id DESC ";
        if ($limit > 0 && $offset >= 0){
            $sql .= " LIMIT $offset,$limit";
        }        
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
               $arrReturn['data'][] = $row;
        }
        $arrReturn['total'] = mysql_num_rows($rs);    
        return $arrReturn;
    }
    function getListProductSale($offset=-1,$limit=-1){
        $arrReturn = array();
        $sql = "SELECT * FROM product WHERE is_saleoff = 1  ORDER BY id DESC ";
        if ($limit > 0 && $offset >= 0){
            $sql .= " LIMIT $offset,$limit";
        }        
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
               $arrReturn['data'][] = $row;
        }
        $arrReturn['total'] = mysql_num_rows($rs);    
        return $arrReturn;
    } 
    function getProductRelated($parent_cate, $product_id){
        $arrReturn = array();
        $sql = "SELECT * FROM product WHERE parent_cate = $parent_cate AND id <> $product_id ORDER BY id DESC LIMIT 0,8";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[$row['id']] = $row;
        }
        return $arrReturn;
    }
    function getDetailProduct($id) {
        $arrReturn = array();      
        $sql = "SELECT * FROM product WHERE id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row =mysql_fetch_assoc($rs);        
        $arrReturn['data']= $row;

        $sql = "SELECT * FROM images WHERE object_id = $id AND object_type = 1";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn['images'][] = $row;
            $str_image.= $row['url'].";";            
        }
        
        $arrReturn['str_image'] = $str_image;                  
        return $arrReturn;
    }
    
    function getListProduct($cate_type_id,$cate_id,$manu_id,$is_available,$is_saleoff,$is_hot,$offset,$limit) {
        try{
            $arrReturn = array();
            $sql = "SELECT * FROM product WHERE (is_hot = $is_hot OR $is_hot = -1) ";                                   
            $sql.=" AND (cate_id = $cate_id OR $cate_id = -1) AND (cate_type_id = $cate_type_id OR $cate_type_id = -1) ";
            $sql.=" AND (is_saleoff = $is_saleoff OR $is_saleoff = -1) AND (manu_id = $manu_id OR $manu_id = -1) ";            
            $sql.=" AND hidden = 0 ORDER BY created_at DESC ";
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";            
            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrReturn['data'][] = $row;
            }
            $arrReturn['total'] = mysql_num_rows($rs);        

        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Product','function' => 'getListProduct' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
        return $arrReturn;
    }

    /* cate_type */
    function getListCateType(){
        $arrReturn = array();
        $sql = "SELECT * FROM cate_type WHERE hidden = 0 ORDER BY display_order ASC ";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[] = $row;
        }
        return $arrReturn;
    }
    /* cate_type */
    function getListCateTypeMenu(){
        $arrReturn = array();
        $sql = "SELECT * FROM cate_type WHERE hidden = 0 AND is_menu = 1 ORDER BY display_order ";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[] = $row;
        }
        return $arrReturn;
    }
    function getDetailCateType($id) {
        $arrReturn = array();      
        $sql = "SELECT * FROM cate_type WHERE id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row =mysql_fetch_assoc($rs);
        $arrReturn = $row;           
        return $arrReturn;
    }   

    
    function getCateByCateType($cate_type_id) {
        $arrReturn = array();        
        $sql = "SELECT * FROM cate WHERE cate_type_id = $cate_type_id AND parent_id = 0";
        $rs = mysql_query($sql) or die(mysql_error());
        while($row =mysql_fetch_assoc($rs)){
            $arrReturn[$row['id']] =  $row;
            $rs1 = mysql_query("SELECT * FROM cate WHERE parent_id = ".$row['id']);
            while($row1 = mysql_fetch_assoc($rs1)){
                $arrReturn[$row['id']]['child'][$row1['id']] = $row1;                
                $rs2 = mysql_query("SELECT * FROM cate WHERE parent_id = ".$row1['id']);
                while($row2 = mysql_fetch_assoc($rs2)){                    
                    $arrReturn[$row['id']]['child'][$row1['id']]['child'][$row2['id']] = $row2;
                }
            }
        }      
        echo "<option value='0'>--chọn--</option>";
        if(!empty($arrReturn)){
            foreach ($arrReturn as $cate) {
                echo "<option value='".$cate['id']."'><b>".$cate['cate_name']."</b></option>";
                if(!empty($cate['child'])){
                    foreach ($cate['child'] as $cate1) {
                        echo "<option value='".$cate1['id']."'>".$cate['cate_name']." / ".$cate1['cate_name']."</option>";
                        if(!empty($cate1['child'])){
                            foreach ($cate1['child'] as $cate2) {
                                echo "<option value='".$cate2['id']."'>".$cate['cate_name']." / ".$cate1['cate_name']." / ".$cate2['cate_name']."</option>";
                                if(!empty($cate2['child'])){
                                    foreach ($cate2['child'] as $cate3) {
                                        echo "<option value='".$cate3['id']."'>--------------".$cate3['cate_name']."</option>";
                                    }
                                }
                            }
                        }
                    }                    
                }
            }
        }                
    }
    function getCateCap1ByCateType($cate_type_id) {
        $arrReturn = array();        
        $sql = "SELECT * FROM cate WHERE cate_type_id = $cate_type_id AND parent_id = 0 ORDER BY display_order ";
        $rs = mysql_query($sql) or die(mysql_error());
        while($row =mysql_fetch_assoc($rs)){
            $arrReturn[$row['id']] =  $row;            
        }                           
        return $arrReturn;
    }
     function getCateCap1ByCateTypeMenu($cate_type_id) {
        $arrReturn = array();        
        $sql = "SELECT * FROM cate WHERE cate_type_id = $cate_type_id AND parent_id = 0 AND is_hot = 1 ORDER BY display_order";
        $rs = mysql_query($sql) or die(mysql_error());
        while($row =mysql_fetch_assoc($rs)){
            $arrReturn[$row['id']] =  $row;            
        }             		
        return $arrReturn;
    }
    function logError($arrLog){
        $time = date('d-m-Y H:i:s');
         ////put content to file
        $createdTime = date('Y/m/d');

        // path to log folder
        $logFolder = "../logs/errors/$createdTime";

        // If not existed => create it
        if (!is_dir($logFolder)) mkdir($logFolder, 0777, true);
        // path to log file
        $logFile = $logFolder . "/error_model.log";
        // Put content in it
        $fp   = fopen($logFile, 'a');
        fwrite($fp, json_encode($arrLog)."\r\n");
        fclose($fp);
    }
    function stripUnicode($str) {
        if (!$str)
            return false;
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'đ',
            'D' => 'Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            '' => '?',
            '-' => '/'
        );
        foreach ($unicode as $khongdau => $codau) {
            $arr = explode("|", $codau);
            $str = str_replace($arr, $khongdau, $str);
        }
        return $str;
    }
    function phantrang3($page, $page_show, $total_page, $link) {
        $dau = 1;
        $cuoi = 0;
        $dau = $page - floor($page_show / 2);
        if ($dau < 1)
            $dau = 1;
        $cuoi = $dau + $page_show;
        if ($cuoi > $total_page) {

            $cuoi = $total_page + 1;
            $dau = $cuoi - $page_show;
            if ($dau < 1)
                $dau = 1;
        }
        echo '<div class="pagination pagination__posts"><ul>';
        if($page > 1){
            ($page==1) ? $class = " class='active'" : $class="class='first'" ;
            echo "<li ".$class."><a href=" . $link .">Đầu</a>" ;
        }
        for($i=$dau; $i<$cuoi; $i++)
        {
            ($page==$i) ? $class = " class='active'" : $class="class='inactive'" ;
            if($i>1){
            echo "<li ".$class."><a href=" . $link . "&trang=$i>$i</a></li>";
            }else{
                echo "<li ".$class."><a href=" . $link . ">1</a></li>";
            }   
        }
        if($page < $total_page) {
            ($page==$total_page) ? $class = "class='active'" : $class="class='last'" ;
            echo "<li ".$class."><a href=" . $link . "&trang=$total_page>Cuối</a></li>";
        }
        echo "</ul></div>";
    }
    function phantrang($page, $page_show, $total_page, $link) {
        $dau = 1;
        $cuoi = 0;
        $dau = $page - floor($page_show / 2);
        if ($dau < 1)
            $dau = 1;
        $cuoi = $dau + $page_show;
        if ($cuoi > $total_page) {

            $cuoi = $total_page + 1;
            $dau = $cuoi - $page_show;
            if ($dau < 1)
                $dau = 1;
        }
        echo '<div class="pagination pagination__posts"><ul class="pags">';
        if($page > 1){
            ($page==1) ? $class = " class='active'" : $class="class='first'" ;
            echo "<li ".$class."><a href=" . $link ."><<</a>" ;
        }
        for($i=$dau; $i<$cuoi; $i++)
        {
            ($page==$i) ? $class = " class='active'" : $class="class='inactive'" ;
            if($i>1){
            echo "<li ".$class."><a href=" . $link . "?trang=$i>$i</a></li>";
            }else{
                echo "<li ".$class."><a href=" . $link . ">1</a></li>";
            }   
        }
        if($page < $total_page) {
            ($page==$total_page) ? $class = "class='active'" : $class="class='last'" ;
            echo "<li ".$class."><a href=" . $link . "?trang=$total_page>>></a></li>";
        }
        echo "</ul></div>";
    }



    public function login($username,$password){
	
        $password = md5($password);
        $sql = "SELECT * FROM customer WHERE username='$username' AND password ='$password'";
        $user = mysql_query($sql) or die(mysql_error());

        $row = mysql_num_rows($user);           
        if ($row == 1) {//success
            $chitiet = mysql_fetch_assoc($user);
            $_SESSION['user'] = $chitiet;            
            echo "success";exit();
        }
        else{
            echo "Tên đăng nhập hoặc mật khẩu không đúng.";exit();
        }            
	}


	function phantrang2($page,$page_show,$total_page,$link){
		$dau=1;
		$cuoi=0;
		$dau=$page - floor($page_show/2);
		if($dau<1) $dau=1;
		$cuoi=$dau+$page_show;
		if($cuoi>$total_page)
		{

			$cuoi=$total_page+1;
			$dau=$cuoi-$page_show;
			if($dau<1) $dau=1;
		}
		echo '<div class="pagination pagination__posts"><ul class="pags">';
		if($page > 1){
			($page==1) ? $class = " class='active'" : $class="first" ;
			echo "<li ".$class."><a data-page='1' href='javascript:void(0)'><<</a></li>"	;
		}
		for($i=$dau; $i<$cuoi; $i++)
		{
			($page==$i) ? $class = " class='active'" : $class="inactive" ;
			echo "<li ".$class."><a data-page='".$i."' href='javascript:void(0)'>$i</a></li>";
		}
		if($page < $total_page) {
			($page==$total_page) ? $class = "class='active'" : $class="last" ;
			echo "<li ".$class."><a data-page='".$total_page."' href='javascript:void(0)'>>></a></li>";
		}
		echo "</ul></div>";
	}
    function smtpmailer($to, $from, $from_name, $subject, $body) {

		//ini_set('display_errors',1);
        global $error;
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 1;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = GUSER;
        $mail->Password = GPWD;
        $mail->SetFrom($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->CharSet="utf-8";
        $mail->IsHTML(true);
        $mail->AddAddress($to);
		//var_dump($mail->ErrorInfo);
        if(!$mail->Send()) {
            $error = 'Gởi mail bị lỗi : '.$mail->ErrorInfo;
            return false;
        } else {
            $error = 'Thư của bạn đã được gởi đi !';
            return true;
        }
    }
    function checkemailexist($email){
        $sql = "SELECT id FROM newsletter WHERE email = '$email' AND status = 1 ";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_num_rows($rs);
        if($row==0){
            return "1";
        }else{
            return "0";
        }
    }

    function checkUsernameExist($username){
        $sql = "SELECT id FROM customer WHERE username = '$username' AND status = 1 ";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_num_rows($rs);
        if($row==0){
            return "1";
        }else{
            return "0";
        }
    }
    function checkEmailUsed($email,$type=''){
        $sql = "SELECT id FROM customer WHERE email = '$email' AND status = 1";
        if($type=='info'){
            $id = $_SESSION['user']['id'];
            $sql.=" AND id <> $id ";
        }
        
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_num_rows($rs);
        if($row==0){
            return "1";
        }else{
            return "0";
        }
    }
    function updateUser($email,$full_name,$address,$city,$phone,$handphone){
        $id = $_SESSION['user']['id'];
        $sql = "UPDATE customer SET email = '$email', full_name = '$full_name', address = '$address', city_id = $city, phone='$phone', handphone = '$handphone' WHERE id = $id";

        mysql_query($sql) or die(mysql_error());
    }
   
    function insertUser($username,$password,$email,$full_name,$address,$city,$phone,$handphone){
         $time = time();
         $sql = "INSERT INTO customer VALUES
                            (NULL,'$full_name','$address',$city,
                            '$phone','$handphone','$email','$username','$password',
                            $time,$time,NULL,NULL,1)";
         $rs = mysql_query($sql) or die(mysql_error().$sql);
         return mysql_insert_id();
    }
    function calDayDelivery(){
        $arr = array();
        date_default_timezone_set('Asia/Saigon');
        $start   = new DateTime();
        $end     = new DateTime();

        $end     = $end->modify( '+8 days' ); // Date Period doesn't include the end date

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($start, $interval ,$end);
        $i = 0;
        foreach($daterange as $date){
            $i++;
            if( $i==1 && date('G') < 15 ){ 
                $arr[$date->format("m/d/Y")] = "Hôm nay " . $date->format("d/m");
            }
            if($i > 1){
                var_dump($date);
                $arr[$date->format("m/d/Y")] = $this->thuVN($date)." ".$date->format("d/m");
            }
        }
        return $arr;
    }
    function calHourDelivery(){
        $current = date('G');
        $max = 21;
        $arr = array();        
        if($current < 15){
            $start = $current;            
        }else{
            $start = 10;           
        }        
        for($i = $start; $i <= $max; $i++){
            $arr[] = $i;
        }
        return $arr;
    }
    function getDetailUser($id){
        $sql = "SELECT * FROM customer WHERE id = $id";        
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        return $row;
    }

    function thuVN($date){        
        $n = date('w',strtotime($date->date));   
        var_dump($date->date);     
        var_dump($n);
        switch($n){
            case 0 : 
                return "Chủ nhật";break;
            case 1 : 
                return "Thứ Hai";break;
            case 2 : 
                return "Thứ Ba";break;
            case 3 : 
                return "Thứ Tư";break;
            case 4 : 
                return "Thứ Năm";break;
            case 5 : 
                return "Thứ Sáu";break;
            case 6 : 
                return "Thứ Bảy";break;
        }
    }
    /* order */

    function insertOrder($total_amount,$total_price,$fullname,$phone,$email,$address,$city_id,$company,$tax_no,$method_id,$note,$discount,$code_id,$total_pay,$customer_id){
        $time = time();
        $sql = "INSERT INTO orders VALUES(NULL, $total_amount,$total_price,'$fullname','$phone','$email','$address',$city_id,'$company','$tax_no',2,$time,
            $method_id,'$note','$discount',$code_id,$total_pay,$customer_id)";
        mysql_query($sql) or die(mysql_error());
        $order_id = mysql_insert_id();
        return $order_id;
    }
    function getListProductCate($parent_id=-1,$giatu=-1,$giaden=-1,$offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM product WHERE (parent_cate = $parent_id OR $parent_id = -1) ";           
           
            if($giatu > -1 && $giaden > -1){                
                $sql.= " AND  (price BETWEEN $giatu AND $giaden)";
            }

            $sql.=" AND hidden = 0 ORDER BY created_at DESC ";
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";           
            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][] = $row;
            }            
            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){     
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'FE','function' => 'getListProduct' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListProductCateType($cate_type_id = -1,$hot = -1, $is_saleoff = -1, $offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM product WHERE (cate_type_id = $cate_type_id OR $cate_type_id = -1) AND (is_hot = $hot OR $hot = -1) AND (is_saleoff = $is_saleoff OR $is_saleoff = -1) ";                      
            $sql.=" AND hidden = 0 ORDER BY created_at DESC ";                      
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";           
            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][] = $row;
            }            
            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){     
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'FE','function' => 'getListProduct' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getDetailArticles($article_id){
        $sql = "SELECT * FROM articles WHERE article_id = $article_id";
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        return $row;
    }
    function getArticlesRelated($cate_id, $article_id,$offset,$limit){
        $arrReturn = array();
        $sql = "SELECT article_id,article_title,article_alias,image_url FROM articles WHERE cate_id = $cate_id AND article_id <> $article_id ORDER BY article_id DESC LIMIT $offset,$limit";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[$row['article_id']] = $row;
        }
        return $arrReturn;
    }
    function getArticlesNews($limit){
        $arrReturn = array();
        $sql = "SELECT article_id,article_title,article_alias,image_url FROM articles ORDER BY article_id DESC LIMIT 0,$limit";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[$row['article_id']] = $row;
        }
        return $arrReturn;
    }
    function getArticlesMostView($offset,$limit){
        $arrReturn = array();
        $sql = "SELECT article_id,article_title,article_alias,image_url FROM articles WHERE is_hot = 1 ORDER BY RAND() LIMIT $offset,$limit";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[$row['article_id']] = $row;
        }
        return $arrReturn;
    }
    function getProductDeal($offset,$limit){
        $arrReturn = array();
        $sql = "SELECT id,product_name,product_alias,image_url,price,price_saleoff FROM product WHERE hidden = 0 AND is_saleoff = 1 ORDER BY RAND() LIMIT $offset,$limit";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[$row['id']] = $row;
        }
        return $arrReturn;
    }
    
}

?>
