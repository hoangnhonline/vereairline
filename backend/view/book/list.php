<?php
require_once "model/Backend.php";
$model = new Backend;
$link_form  = "";
$link = "index.php?mod=book&act=list";
$cityArr = $model->getListCity();
if (isset($_GET['fullname']) && trim($_GET['fullname']) != '') {
    $fullname = $_GET['fullname'];      
    $link.="&fullname=$fullname";
    $link_form.="&fullname=$fullname";
} else {
    $fullname = '';
}
if (isset($_GET['phone']) && trim($_GET['phone']) != '') {
    $phone = $_GET['phone'];      
    $link.="&phone=$phone";
     $link_form.="&phone=$phone";
} else {
    $phone = '';
}

if (isset($_GET['email']) && trim($_GET['email']) != '') {
    $email = $_GET['email'];      
    $link.="&email=$email";
    $link_form.="&email=$email";
} else {
    $email = '';
}

if (isset($_GET['status']) && $_GET['status'] > 0) {
    $status = (int) $_GET['status'];      
    $link.="&status=$status";
    $link_form.="&status=$status";
} else {
    $status = -1;
}
if (isset($_GET['type']) && $_GET['type'] > 0) {
    $type = (int) $_GET['type'];      
    $link.="&type=$type";
    $link_form.="&type=$type";
} else {
    $type = -1;
}
if (isset($_GET['national_type']) && $_GET['national_type'] > -1) {
    $national_type = (int) $_GET['national_type'];      
    $link.="&national_type=$national_type";
    $link_form.="&national_type=$national_type";
} else {
    $national_type = -1;
}


if(isset($_GET['fromdate'])){
    $fromdate = $_GET['fromdate'];
}else{
    $fromdate = date('Y-m-d',time());
}
$link_form.="&fromdate=$fromdate";
if(isset($_GET['todate'])){
    $todate = $_GET['todate'];
}else{
    $todate = date('Y-m-d',time());
}
$link_form.="&todate=$todate";

//$mave='',$order_code="",$fullname="",$phone="",
//$email="",$status=-1,$national_type=-1,$is_pay=-1,$fromdate=-1,$todate=-1,$offset = -1, $limit = -1
$arrTotal = $model->getListBooking($fullname,$phone,$email,$status,$national_type,$type, $fromdate,$todate, -1, -1);

$limit = 64;

$total_page = ceil($arrTotal['total'] / $limit);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$offset = $limit * ($page - 1);

$arrList = $model->getListBooking($fullname,$phone,$email,$status,$national_type,$type, $fromdate,$todate,$offset, $limit);

?>
<style>
input.text_order {
    width: 130px;
    border: 1px solid #ccc;
    height: 25px;
}
select.select_search{
    width:130px;
}
#search_advance td{
    text-align: left;
}

</style>
<div class="row">
    <div class="col-md-12">    
         <div class="box-header">
                <h3 class="box-title">Danh sách đặt bàn</h3>
            </div><!-- /.box-header -->
        <div class="box">
            <div class="box_search">                                    
                   <table width="100%" id="search_advance">
                        <tr style="height:40px">                            

                            <td>Họ tên</td>
                            <td><input type="text" class="text_order" id="fullname" name="fullname" value="<?php echo (trim($fullname)!='') ? $fullname: ""; ?>" /> </td>
                            <td>Điện thoại</td>
                            <td><input type="text" class="text_order" id="phone" name="phone" value="<?php echo (trim($phone)!='') ? $phone: ""; ?>" /> </td>
                            <td>Email</td>
                            <td><input type="text" class="text_order" id="email" name="email" value="<?php echo (trim($email)!='') ? $email: ""; ?>" /> </td>
                            
                        </tr>
                        <tr>
                            <td>Loại vé</td>
                            <td>
                                <select name="national_type" class="select_search" id="national_type">
                                    <option value="-1">Tất cả</option>                                    
                                    <option value="1" <?php if(isset($_GET['national_type']) && $_GET['national_type']==1) echo "selected" ; ?>>Trong nước</option>
                                    <option value="2" <?php if(isset($_GET['national_type']) && $_GET['national_type']==2) echo "selected" ; ?>>Quốc tế</option>
                                    <option value="3" <?php if(isset($_GET['national_type']) && $_GET['national_type']==3) echo "selected" ; ?>>Yêu cầu đặt vé</option>
                                </select>
                            </td>
                            <td>Trạng thái</td>
                            <td>
                                <select name="status" class="select_search" id="status">
                                    <option value="-1">Tất cả</option>
                                    <option value="2" <?php echo (isset($_GET['status']) && $_GET['status']==2) ? "selected" : ""; ?>>Mới</option>
                                    <option value="1" <?php echo (isset($_GET['status']) && $_GET['status']==1) ? "selected" : ""; ?>>Đã xác nhận</option>                                    
                                    <option value="3" <?php echo (isset($_GET['status']) && $_GET['status']==3) ? "selected" : ""; ?>>Huỷ</option>
                                </select>
                            </td>                            

                            <td>Từ ngày</td>
                            <td>
                                <input type="text" class="text_order" id="fromdate" name="fromdate" value="<?php echo (trim($fromdate)!='') ? date('d-m-Y',strtotime($fromdate)): ""; ?>" /> 
                            </td>

                            <td>Đến ngày</td>
                            <td>
                                <input type="text" class="text_order" id="todate" name="todate" value="<?php echo (trim($todate)!='') ? date('d-m-Y',strtotime($todate)): ""; ?>" /> 
                            </td>
                            <td><button class="btn btn-primary btn-sm right" id="btnSearch" type="button">Tìm kiếm</button></td>
                        </tr>                       
                   </table>                                     

            </div>
            <div class="box-body">                
                <table class="table table-bordered table-striped" id="tbl_list">
                    <tbody><tr>
                        <th style="width: 1%">STT</th>
                        <th style="width:10%">Loại vé</th>
                        <th style="width:15%">Địa điểm</th>                        
                        <th style="width:13%">Ngày</th>
                        <th>Lượng khách</th>
                        <th>Họ tên</th>
                        <th style="text-align:right">Điện thoại</th>                          
                        <th>Đặt vào lúc</th> 
                        <th style="text-align:center">Trạng thái</th>    
                        <th style="width: 40px">Thao tác</th>
                    </tr>
                    <?php
                    if(!empty($arrList['data'])){
                    $i = ($page-1) * $limit;                    
                    foreach($arrList['data'] as $row){
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td> 
                        <td>
                            <?php 
                            if($row['national_type'] < 3){
                                if($row['national_type'] == 1){
                                    echo "Trong nước";
                                }else{
                                    echo "Quốc tế";
                                } 
                            }
                            ?>
                            <br />
                            <?php 
                            if($row['type'] == 0){
                                echo " ( Yêu cầu đặt vé )";
                            }else{
                                if($row['type'] == 1){
                                    echo "( Một chiều )";
                                }else{
                                    echo " ( Khứ hồi )";
                                } 
                            }
                            
                            ?>                           
                        </td>
                        <td>
                            <?php 
                            if($row['national_type'] == 1){
                                $noi_di = $cityArr[$row['noi_di']]['city_name'];
                                $noi_den = $cityArr[$row['noi_den']]['city_name'];
                            }else{
                                $noi_di = $row['noi_di_ngoai'];
                                $noi_den = $row['noi_den_ngoai'];
                            }
                            ?>
                            <p>
                                <span>Nơi đi:</span> <br /> &nbsp;&nbsp;&nbsp;-<span class="value"><?php echo $noi_di; ?></span>
                            </p>
                            <p>
                                <span>Nơi đến:</span> <br /> &nbsp;&nbsp;&nbsp;-<span class="value"><?php echo $noi_den; ?></span>
                            </p>
                        </td>
                                                                
                        <td>
                            <p>
                                <span>Ngày đi:</span> <br /> &nbsp;&nbsp;&nbsp;<span class="value"><?php echo date('d-m-Y' ,$row['depatureDate']); ?></span>
                            </p>
                            <?php if($row['returnDate'] > 0 ){ ?>
                            <p>
                                <span>Ngày về:</span> <br /> &nbsp;&nbsp;&nbsp;<span class="value"><?php echo date('d-m-Y' ,$row['returnDate']); ?></span>
                            </p>
                            <?php } ?>
                        </td>
                        <td>
                            <p>
                                <span>Người lớn:</span> <span class="value"><?php echo $row['adultNo']?></span>
                            </p>
                            <?php if($row['childNo'] > 0 ){ ?>
                            <p>
                                <span>Trẻ em:</span> <span class="value"><?php echo $row['childNo']?></span>
                            </p>
                            <?php } ?>
                            <?php if($row['infantNo'] > 0 ){ ?>
                            <p>
                                <span>Em bé:</span> <span class="value"><?php echo $row['infantNo']?></span>
                            </p>
                            <?php } ?>
                        </td>
                        <td><?php echo $row['fullname']; ?></td>                        
                        <td align="right"><?php echo $row['phone']; ?></td>                                        
                            
                        <td><?php echo date('d-m-Y H:i',$row['created_at']); ?></td>  
                                            
                        <td style="text-align:center">
                        <?php 
                        $status = $row['status'];                        
                        if($status == 2) echo '<span class="label label-success">Mới</span>';                        
                        if($status == 3) echo '<span class="label label-danger">Hủy</span>';
                        if($status == 1) echo '<span class="label label-info">Đã xác nhận</span>';                        
                        ?>
                    
                        </td>    
                                              
                        <td style="white-space:nowrap"> 
                            <?php if($row['status']==2) { ?>

                            <button class="btn btn-info btn-xs" onclick='location.href="xacnhan.php?id=<?php echo $row['id']; ?><?php echo $link_form; ?>"'>Xác nhận</button>
                                                                             
                            <?php } ?>
                            <a title="Click để chỉnh sửa" href="index.php?mod=book&act=form&id=<?php echo $row['id']; ?><?php echo $link_form; ?>">
                                <i class="fa fa-fw fa-edit"></i>
                            </a>
                            <a title="Click để xóa" href="javascript:;" id="<?php echo $row['id']; ?>" mod="book" class="link_delete" >    
                                <i class="fa fa-fw fa-trash-o"></i>
                            </a>    
                            
                        </td>
                    </tr>      
                    <?php }  }else{ ?>              
                    <tr>
                        <td colspan="11" class="error_data">Không tìm thấy dữ liệu!</td>
                    </tr>
                    <?php } ?>             
                </tbody></table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <!--
                <ul class="pagination pagination-sm no-margin pull-right">
                    <li><a href="#">«</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">»</a></li>
                </ul>-->
                <?php echo $model->phantrang($page, PAGE_SHOW, $total_page, $link); ?>
            </div>
        </div><!-- /.box -->                           
    </div><!-- /.col -->
   
</div>
<link href="<?php echo STATIC_URL; ?>css/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    $(function(){
        $('#fromdate,#todate').datepicker({            
            dateFormat: "dd-mm-yy" ,
            changeMonth: true,
            changeYear: true               
        });        
        $('#filter_id').change(function(){
            var id = $(this).val();
            if(id==1){
                $('.ticket_code').hide();
                $('.order_code').show();
            }else{
                $('.ticket_code').show();   
                $('.order_code').hide();
            }
        });
        $('#national_type,#status,#sort_column,#sort_value').change(function(){
            search();
        });
        $('#btnSearch').click(function(){
            search();
        });
        $('#email,#fullname,#code,#order_code,#phone').keypress(function (e) {
          if (e.which == 13) {
            search();
          }
        });
    });   
    function search(){
        var str_link = "index.php?mod=book&act=list";
        var tmp = $('#filter_id').val();        
        tmp = $('#national_type').val();
        if(tmp > 0){
            str_link += "&national_type=" + tmp ;
        }
        tmp = $('#type').val();
        if(tmp > 0){
            str_link += "&type=" + tmp ;
        }
        tmp = $('#status').val();
        if(tmp > 0){
            str_link += "&status=" + tmp ;
        }
        tmp = $('#sort_column').val();
        if(tmp){
            str_link += "&sort_column=" + tmp ;
        }
        tmp = $('#sort_value').val();
        if(tmp){
            str_link += "&sort_value=" + tmp ;
        }       
        tmp = $.trim($('#fullname').val());
        if(tmp != ''){
            str_link += "&fullname=" + tmp ;   
        }
        tmp = $.trim($('#phone').val());
        if(tmp != ''){
            str_link += "&phone=" + tmp ;   
        }
        tmp = $.trim($('#email').val());
        if(tmp != ''){
            str_link += "&email=" + tmp ;   
        }  
        tmp = $.trim($('#fromdate').val());
        if(tmp != ''){
            str_link += "&fromdate=" + tmp ;   
        }
        tmp = $.trim($('#todate').val());
        if(tmp != ''){
            str_link += "&todate=" + tmp ;   
        }         
        location.href= str_link;
    }   
</script>
<style type="text/css">
span.value{
    font-weight: bold;
}
</style>