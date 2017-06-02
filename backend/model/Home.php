<?php
class Home {

   private $host = "localhost";
    private $user = "root";
    private $pass = "root";
    private $db = "conyeu";

    //private $host = "localhost";
    //private $user = "thietken_box";
    //private $pass = "12345!@#";
    //private $db = "thietken_box";


    function __construct() {
        mysql_connect($this->host, $this->user, $this->pass) or die("Can't connect to server");
        mysql_select_db($this->db) or die("Can't connect database");
        mysql_query("SET NAMES 'utf8'") or die(mysql_error());
    }

    function throw_ex($e){
        throw new Exception($e);
    }

    function getListEstateType($offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM estate_type WHERE status = 1 ";

            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][$row['estate_type_id']] = $row;
            }
            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'getListEstateType' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListProjectType($offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM project_type WHERE status = 1 ";

            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][$row['project_type_id']] = $row;
            }
            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'getListEstateType' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListLegal($offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM legal WHERE status = 1 ";

            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][$row['legal_id']] = $row;
            }
            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'getListEstateType' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListPrice($offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM price WHERE status = 1 ";

            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][$row['price_id']] = $row;
            }
            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'getListEstateType' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListAddon($offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM addon WHERE status = 1 ";

            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][$row['addon_id']] = $row;
            }
            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'getListEstateType' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListArea($offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM area WHERE status = 1 ";

            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][$row['area_id']] = $row;
            }
            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'getListEstateType' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListDirection($offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM direction WHERE status = 1 ";

            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][$row['direction_id']] = $row;
            }
            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'getListEstateType' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }

    function getListDistrict($city_id=-1, $offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM district WHERE status = 1 AND (city_id = $city_id OR $city_id = -1 ) ";

            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][$row['district_id']] = $row;
            }
            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'getListEstateType' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListPostHot($offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM post WHERE hot = 1 ";
            $sql.=" AND status = 1 ORDER BY creation_time DESC ";
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][] = $row;
            }

            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Home','function' => 'getListPostHost' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListPost($district_id=-1,$type_id=-1,$estate_type_id=-1,$direction_id=-1,$area_id=-1,$legal_id=-1,$price_id=-1,$project_type_id=-1,$offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM post WHERE (district_id = $district_id OR $district_id = -1) ";
            $sql.=" AND (type_id = $type_id OR $type_id = -1) AND (estate_type_id = $estate_type_id OR $estate_type_id = -1) ";
            $sql.=" AND (direction_id = $direction_id OR $direction_id = -1) AND (area_id = $area_id OR $area_id = -1) ";
            $sql.=" AND (legal_id = $legal_id OR $legal_id = -1) AND (price_id = $price_id OR $price_id = -1) ";
            $sql.=" AND (project_type_id = $project_type_id OR $project_type_id = -1) ";
            $sql.=" AND status = 1 ORDER BY creation_time DESC ";
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][] = $row;
            }

            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'getListPost' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListArticle($cate_id=-1,$offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM articles WHERE (category_id = $cate_id OR $cate_id = -1) ";           
            $sql.=" AND status = 1 ORDER BY creation_time DESC ";
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][] = $row;
            }

            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Home','function' => 'getListArticle' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    
    function getListProject($project_type_id=-1,$offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM project WHERE (project_type_id = $project_type_id OR $project_type_id = -1) ";           
            $sql.=" AND status = 1 ORDER BY creation_time DESC ";
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][] = $row;
            }

            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Home','function' => 'getListProject' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getDetailEstateTypeByID($estate_type_id){
        $sql = "SELECT * FROM estate_type WHERE estate_type_id = $estate_type_id";
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        return $row;
    }
    function getDetailProjectTypeByID($project_type_id){
        $sql = "SELECT * FROM project_type WHERE project_type_id = $project_type_id";
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        return $row;
    }
    function getEstateIDByAlias($alias){
        $sql = "SELECT * FROM estate_type WHERE estate_alias = '$alias'";
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        return $row['estate_type_id'];
    }
    function getProjectTypeIDByAlias($alias){
        $sql = "SELECT * FROM project_type WHERE project_type_alias = '$alias'";
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        return $row['project_type_id'];
    }
    function getDetailArticle($article_id) {
        $arrReturn = array();
        $str_image = "";
        $sql = "SELECT * FROM articles WHERE article_id = $article_id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row =mysql_fetch_assoc($rs);
        $arrReturn['data']= $row;

        $sql = "SELECT * FROM images WHERE object_id = $article_id AND object_type = 2";
        $rs = mysql_query($sql) or die(mysql_error());
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn['images'][] = $row;
            $str_image.= $row['url'].";";            
        }
        $arrReturn['str_image'] = $str_image;        
        return $arrReturn;
    }
    function getDetailProject($project_id) {
        $arrReturn = array();
        $str_image = "";
        $sql = "SELECT * FROM project WHERE project_id = $project_id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row =mysql_fetch_assoc($rs);
        $arrReturn['data']= $row;

        $sql = "SELECT * FROM images WHERE object_id = $project_id AND object_type = 3";
        $rs = mysql_query($sql) or die(mysql_error());
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn['images'][] = $row;
            $str_image.= $row['url'].";";            
        }
        $arrReturn['str_image'] = $str_image;        
        return $arrReturn;
    }
    function getListProjectHot() {
        $arrReturn = array();        
        $sql = "SELECT * FROM project WHERE hot = 1 ORDER BY update_time DESC LIMIT 0,5";
        $rs = mysql_query($sql) or die(mysql_error());
        while($row =mysql_fetch_assoc($rs)){
            $arrReturn[]= $row;
        }        
        return $arrReturn;
    }
    function getListArticlesHot() {
        $arrReturn = array();        
        $sql = "SELECT * FROM articles WHERE status = 1 ORDER BY update_time DESC LIMIT 0,2";
        $rs = mysql_query($sql) or die(mysql_error());
        while($row =mysql_fetch_assoc($rs)){
            $arrReturn[]= $row;
        }        
        return $arrReturn;
    }
    function getDetailPost($id){
        $arrReturn = array();
        $str_image = "";
        $sql = "SELECT * FROM post WHERE post_id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row =mysql_fetch_assoc($rs);
        $arrReturn['data']= $row;

        $sql = "SELECT * FROM images WHERE object_id = $id AND object_type = 1";
        $rs = mysql_query($sql) or die(mysql_error());
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn['images'][] = $row;
            $str_image.= $row['url'].";";            
        }
        $arrReturn['str_image'] = $str_image;        
        return $arrReturn;
    }
    function pagination($page, $page_show, $total_page,$r=1){
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
        $str='<div class="pagination-page"><div class="left t-page"><p>Page<span> '.$page.'</span> of <span>'.$total_page.'</span></p></div><div class="right t-pagination"><ul>';
        if ($page > 1) {
            ($page == 1) ? $class = " class='active'" : $class = "";
            $str.='<li><a ' . $class . ' href="javascript:;" attr-value="1"><</a><li>';
            echo "";
        }
        for ($i = $dau; $i < $cuoi; $i++) {
            ($page == $i) ? $class = " class='active'" : $class = "";
            $str.='<li><a ' . $class . ' href="javascript:;" attr-value="'.$i.'">'.$i.'</a><li>';
        }
        if ($page < $total_page) {
            ($page == $total_page) ? $class = " class='active end'" : $class = " class='end' ";
            $str.='<li><a ' . $class . ' href="javascript:;" attr-value="'.$total_page.'">></a><li>';
        }
        $str.="</ul></div></div>";
        return $str;

    }
    function getRouteNameByID($id,$lang="vi") {
        $sql = "SELECT route_name_vi,route_name_en FROM route WHERE route_id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row['route_name_'.$lang];
    }
    function countReviewByEmailID($email_id) {
        $sql = "SELECT count(detail_id) as total FROM rating_detail WHERE email_id = $email_id AND status = 1";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row['total'];
    }
    function countUsefulByEmailID($email_id) {
        $sql = "SELECT count(detail_id) as total FROM rating_detail WHERE email_id = $email_id AND status = 1 AND is_helpful = 1";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row['total'];
    }
    function getListNhaxeHaveTicket($vstart,$vend,$dstart){
        $arrResult = array();
        try{
            $sql = "SELECT nhaxe_id FROM ticket WHERE status > 0 AND tinh_id_start = $vstart AND tinh_id_end = $vend
            AND date_start = $dstart GROUP BY nhaxe_id "  ;
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());

            while($row = mysql_fetch_assoc($rs)){
                $nhaxe_id = $row['nhaxe_id'];
                $arrResult[$nhaxe_id] = $this->getDetailNhaxe2($nhaxe_id);
            }

        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Nhaxe','function' => 'getListNhaxeHaveTicket' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }

        return $arrResult;
    }
    function paginationex($page,$page_show,$total_page,$link,$option=1){
        $dau=1;
        $cuoi=0;
        $dau=$page - floor($page_show/2);       
        $p = "";
        if($dau<1) $dau=1;  
        $cuoi=$dau+$page_show;
        if($cuoi>$total_page)
        {
            
            $cuoi=$total_page+1;
            $dau=$cuoi-$page_show;
            if($dau<1) $dau=1;
        }
        echo '<ul class="pagination">';
        if($page > 1){
            $p = $option == 1 ? ".html" :"";
            $class = ($page==1) ? " class='active'" : "first" ;    
            echo "<li ".$class."><a  href=".$link.$p.">«</a></li>"    ;                           
        }
        for($i=$dau; $i<$cuoi; $i++)
        {
            $p = $option == 1 ? "_$i.html" :"&page=$i";
            ($page==$i) ? $class = " class='active'" : $class="inactive" ;        
            echo "<li ".$class."><a  href=".$link.$p.">$i</a></li>";         
        }
        if($page < $total_page) { 
            $p = $option == 1 ? "_$total_page.html" :"&page=$total_page";
            $class = ($page==$total_page) ?  "class='active'" : "last" ;        
            echo "<li ".$class."><a  href=".$link.$p.">»</a></li>";
        }
        echo "</ul>";
    }
}
?>
