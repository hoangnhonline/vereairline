<?php
require_once "model/Backend.php";
$modelBE = new Backend;
$link = "index.php?mod=order&act=detail";
$order_id = (int) $_GET['order_id'];
$sql = "SELECT * FROM order_detail WHERE order_id = $order_id ";

$rs = mysql_query($sql);

$arrDetail = $modelBE->getDetailOrder($order_id);
if (isset($_GET['customer_name']) && trim($_GET['customer_name']) != '') {
    $customer_name = $_GET['customer_name'];      
    $link.="&customer_name=$customer_name";
    $link_form.="&customer_name=$customer_name";
} else {
    $customer_name = '';
}
if (isset($_GET['phone_number']) && trim($_GET['phone_number']) != '') {
    $phone_number = $_GET['phone_number'];      
    $link.="&phone_number=$phone_number";
     $link_form.="&phone_number=$phone_number";
} else {
    $phone_number = '';
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
if (isset($_GET['sort_column'])) {
    $sort_column = $_GET['sort_column'];      
    $link.="&sort_column=$sort_column";
    $link_form.="&sort_column=$sort_column";
} else {
    $sort_column = 'delivery_date';
}
if (isset($_GET['sort_value'])) {
    $sort_value = $_GET['sort_value'];      
    $link.="&sort_value=$sort_value";
    $link_form.="&sort_value=$sort_value";
} else {
    $sort_value = 'asc';
}
if (isset($_GET['order_type']) && $_GET['order_type'] > 0) {
    $order_type = (int) $_GET['order_type'];      
    $link.="&order_type=$order_type";
    $link_form.="&order_type=$order_type";
} else {
    $order_type = -1;
}

if(isset($_GET['fromdate'])){
    $fromdate = $_GET['fromdate'];
    
}else{
    $fromdate = "01-".date('m')."-".date('Y');
}
$link_form.="&fromdate=".$fromdate;
if(isset($_GET['todate'])){
    $todate = $_GET['todate'];
    
}else{
    $todate = date('d-m-Y',time());
}
$link_form.="&todate=".$todate;
?>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=order&amp;act=list<?php echo $link_form; ?>'">Quay lại</button>    
         <div class="box-header">
                <h3 class="box-title">Chi tiết đơn hàng : <?php echo $arrDetail['id']; ?></h3>
            </div><!-- /.box-header -->
        <div class="box">            
            <div class="box-body">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Thông tin đơn hàng
                    </a>
                  </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                       <div class="col-md-12" >
                          <table class="table table-bordered tbl_value">
                            <tr>
                              <td>Phân loại</td>
                              <td class="value"><?php
                                if($arrDetail['order_type'] == 1) echo "Đặt mua" ;
                                if($arrDetail['order_type'] == 2) echo "Đặt giữ hàng" ;
                                if($arrDetail['order_type'] == 3) echo "Đặt trước" ;
                               ?></td>
                            </tr>   
                             <tr>
                              <td width="200px">Sản phẩm </td>
                              <td class="value"><?php echo $model->getProductName($arrDetail['product_id']); ?></td>
                            </tr>
                            <tr>
                              <td width="200px">Ngày đặt hàng</td>
                              <td class="value"><?php echo date('d-m-Y H:i',$arrDetail['created_at']); ?></td>
                            </tr>
                            <tr>
                              <td>Ngày giao hàng </td>
                              <td class="value"><?php echo date('d-m-Y',$arrDetail['delivery_date']); ?> - Trước <?php echo $arrDetail['delivery_hour']; ?> giờ</td>
                            </tr>                                                        
                            <tr>
                              <td>Phí giao hàng</td>
                              <td class="value"><?php echo number_format($arrDetail['ship']); ?></td>
                            </tr>  
                            <?php if($arrDetail['use_voucher']==1){ ?>                           
                           <tr>
                              <td>Mã giảm giá</td>
                              <td class="value"><?php echo ($arrDetail['voucher_code']); ?></td>
                            </tr>                                   
                            <?php } ?>                                         
                            <tr>
                              <td>Nhân viên cập nhật</td>
                              <td class="value"><?php  if($arrDetail['updated_by'] > 0) echo $model->getUserById($arrDetail['updated_by']); ?></td>
                            </tr>
                            <tr>
                              <td>Ngày cập nhật</td>
                              <td class="value"><?php  if($arrDetail['updated_at'] > 0) echo date('d-m-Y H:i',($arrDetail['updated_at'])); ?></td>
                            </tr>
                          </table>                           
                           
                      </div>  
                  </div>
                </div>
              </div>              
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                  <h4 class="panel-title">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      Thông tin người mua
                    </a>
                  </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body">
                      <div class="col-md-12" >
                          <table class="table table-bordered tbl_value">
                            <tr>
                              <td width="200px">Họ tên</td>
                              <td class="value"><?php echo $arrDetail['customer_name']; ?></td>
                            </tr>
                             <tr>
                              <td width="200px">Giới tính</td>
                              <td class="value"><?php echo $arrDetail['gender']==1 ? "Nam" : "Nữ"; ?></td>
                            </tr>
                            <tr>
                              <td width="200px">Địa chỉ</td>
                              <td class="value"><?php echo $arrDetail['address']; ?></td>
                            </tr>
                            <tr>
                              <td width="200px">Tỉnh/TP</td>
                              <td class="value"><?php echo $model->getCityById($arrDetail['city_id']); ?></td>
                            </tr>
                            <tr>
                              <td width="200px">Email</td>
                              <td class="value"><?php echo $arrDetail['email']; ?></td>
                            </tr>                          
                            <tr>
                              <td width="200px">Di động</td>
                              <td class="value"><?php echo $arrDetail['phone_number']; ?></td>
                            </tr>                                                    
                          </table>                           
                           
                      </div>   
                  </div>
                </div>
              </div>
              <?php if($arrDetail['export_order']==1){ ?>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingFour">
                  <h4 class="panel-title">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                      Thông tin xuất hóa đơn
                    </a>
                  </h4>
                </div>
                <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                  <div class="panel-body">
                     <div class="col-md-12" >
                          <table class="table table-bordered tbl_value">
                            <tr>
                              <td width="200px">Tên CTY</td>
                              <td class="value"><?php echo $arrDetail['company_name']; ?></td>
                            </tr>
                             
                            <tr>
                              <td width="200px">Địa chỉ CTY</td>
                              <td class="value"><?php echo $arrDetail['company_address']; ?></td>
                            </tr>                           
                            <tr>
                              <td width="200px">Mã số thuế</td>
                              <td class="value"><?php echo $arrDetail['tax_no']; ?></td>
                            </tr>                                                     
                          </table>                           
                           
                      </div> 
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
                
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
                <?php echo $modelBE->phantrang($page, PAGE_SHOW, $total_page, $link); ?>
            </div>
        </div><!-- /.box -->                           
    </div><!-- /.col -->
   
</div>
<link href="<?php echo STATIC_URL; ?>css/jquery-ui.css" rel="stylesheet" type="text/css" />
<style type="text/css">
  td.value{
    font-weight: bold;
    font-size:16px;
    background-color: #FFF !important;
  }
  .tbl_value td{
    background-color: #f9f9f9
  }
</style>
<script type="text/javascript">
    $(function(){
        $('#fromdate,#todate').datepicker({            
            dateFormat: "dd-mm-yy" ,
            changeMonth: true,
            changeYear: true               
        });
        
        $('#order_type,#status').change(function(){
            search();
        });
        $('#btnSearch').click(function(){
            search();
        });
        $('#email,#customer_name,#code,#phone_number').keypress(function (e) {
          if (e.which == 13) {
            search();
          }
        });
    });   
    function search(){
        var str_link = "index.php?mod=order&act=list";
       
       
        var tmp = $('#order_type').val();
        if(tmp > 0){
            str_link += "&order_type=" + tmp ;
        }
        tmp = $('#status').val();
        if(tmp > 0){
            str_link += "&status=" + tmp ;
        }
        

        tmp = $.trim($('#order').val());
        if(tmp != ''){
            str_link += "&order=" + tmp ;   
        }
       
        tmp = $.trim($('#customer_name').val());
        if(tmp != ''){
            str_link += "&customer_name=" + tmp ;   
        }
        tmp = $.trim($('#phone_number').val());
        if(tmp != ''){
            str_link += "&phone_number=" + tmp ;   
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