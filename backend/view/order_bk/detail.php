<?php
require_once "model/Backend.php";
$modelBE = new Backend;
$link = "index.php?mod=order&act=detail";
$order_id = (int) $_GET['order_id'];
$sql = "SELECT * FROM order_detail WHERE order_id = $order_id ";

$rs = mysql_query($sql);

$arrDetail = $modelBE->getDetailOrder($order_id);
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
if (isset($_GET['method_id']) && $_GET['method_id'] > 0) {
    $method_id = (int) $_GET['method_id'];      
    $link.="&method_id=$method_id";
    $link_form.="&method_id=$method_id";
} else {
    $method_id = -1;
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
                <h3 class="box-title">Chi tiết đơn hàng : <?php echo $arrDetail['order_code']; ?></h3>
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
                              <td width="200px">Mã đơn hàng </td>
                              <td class="value"><?php echo $arrDetail['order_code']; ?></td>
                            </tr>
                            <tr>
                              <td width="200px">Ngày đặt hàng</td>
                              <td class="value"><?php echo date('d-m-Y H:i',$arrDetail['created_at']); ?></td>
                            </tr>
                            <tr>
                              <td>Ngày giao hàng </td>
                              <td class="value"><?php echo date('d-m-Y H:i',$arrDetail['delivery_date']); ?></td>
                            </tr>
                            <tr>
                              <td>Số lượng sản phẩm </td>
                              <td class="value"><?php echo number_format($arrDetail['total_amount']); ?></td>
                            </tr>
                            <tr>
                              <td>Giá trị sản phẩm</td>
                              <td class="value"><?php echo number_format($arrDetail['sub_total']) ;?></td>
                            </tr>
                            <tr>
                              <td>VAT</td>
                              <td class="value"><?php echo $arrDetail['vat']; ?> %</td>
                            </tr>
                            <tr>
                              <td>Phí giao hàng</td>
                              <td class="value"><?php echo number_format($arrDetail['ship']); ?></td>
                            </tr>
                            <tr>
                              <td>Tổng tiền</td>
                              <td class="value"><?php echo number_format($arrDetail['total']); ?></td>
                            </tr>  
                            <tr>
                              <td>Phương thức thanh toán </td>
                              <td class="value"><?php echo $model->getMethodById($arrDetail['method_id']); ?></td>
                            </tr>                                                  
                            
                            <tr>
                              <td>Ghi chú</td>
                              <td class="value"><?php echo $arrDetail['order_note']; ?></td>
                            </tr>
                            <tr>
                              <td>Nhân viên giao hàng </td>
                              <td class="value"><?php echo $arrDetail['staff_name']; ?></td>
                            </tr>
                            <tr>
                              <td>Ghi chú cho nhân viên</td>
                              <td class="value"><?php echo $arrDetail['staff_note']; ?></td>
                            </tr>
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
                <div class="panel-heading" role="tab" id="headingTwo">
                  <h4 class="panel-title">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      Sản phẩm đơn hàng
                    </a>
                  </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                  <div class="panel-body">
                    <table class="table table-bordered table-striped">
                        <tbody><tr>
                            <th style="width: 1%">STT</th>                                           
                            <th style="text-align:left" width="300px">Tên sản phẩm </th> 
                            <th>Ảnh</th> 
                            <th style="text-align:right">Số lượng </th>  
                            <th style="text-align:right">Đơn giá</th>  
                            <th style="text-align:right">Thành tiền</th>                                                                                                          
                        </tr>
                        <?php                    
                        $i = ($page-1) * $limit;                    
                       while($row = mysql_fetch_assoc($rs)){                        
                        $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>                                                
                            <td><?php echo $row['product_name']; ?></td>
                            <td><img src="../<?php echo $model->getImageById($row['product_id']); ?>" width="80" /></td>                                                
                            <td align="right"><?php echo $row['amount']; ?></td>  
                            <td align="right"><?php echo number_format($row['price']); ?></td>
                            <td align="right"><?php echo number_format($row['total']); ?></td>
                        </tr>      
                        <?php } ?>            
                    </tbody>
                    </table>
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
                              <td class="value"><?php echo $arrDetail['buyer_name']; ?></td>
                            </tr>
                             <tr>
                              <td width="200px">Giới tính</td>
                              <td class="value"><?php echo $arrDetail['buyer_gender']==1 ? "Nam" : "Nữ"; ?></td>
                            </tr>
                            <tr>
                              <td width="200px">Địa chỉ</td>
                              <td class="value"><?php echo $arrDetail['buyer_address']; ?></td>
                            </tr>
                            <tr>
                              <td width="200px">Tỉnh/TP</td>
                              <td class="value"><?php echo $model->getCityById($arrDetail['buyer_city_id']); ?></td>
                            </tr>
                            <tr>
                              <td width="200px">Email</td>
                              <td class="value"><?php echo $arrDetail['buyer_email']; ?></td>
                            </tr>
                            <tr>
                              <td width="200px">ĐT bàn</td>
                              <td class="value"><?php echo $arrDetail['buyer_phone']; ?></td>
                            </tr>
                            <tr>
                              <td width="200px">Di động</td>
                              <td class="value"><?php echo $arrDetail['buyer_handphone']; ?></td>
                            </tr>
                            <tr>
                              <td width="200px">CMND</td>
                              <td class="value"><?php echo $arrDetail['buyer_indentity_card']; ?></td>
                            </tr>                           
                          </table>                           
                           
                      </div>   
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingFour">
                  <h4 class="panel-title">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                      Thông tin người nhận
                    </a>
                  </h4>
                </div>
                <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                  <div class="panel-body">
                     <div class="col-md-12" >
                          <table class="table table-bordered tbl_value">
                            <tr>
                              <td width="200px">Họ tên</td>
                              <td class="value"><?php echo $arrDetail['recipients_name']; ?></td>
                            </tr>
                             <tr>
                              <td width="200px">Giới tính</td>
                              <td class="value"><?php echo $arrDetail['recipients_gender']==1 ? "Nam" : "Nữ"; ?></td>
                            </tr>
                            <tr>
                              <td width="200px">Địa chỉ</td>
                              <td class="value"><?php echo $arrDetail['recipients_address']; ?></td>
                            </tr>
                            <tr>
                              <td width="200px">Tỉnh/TP</td>
                              <td class="value"><?php echo $model->getCityById($arrDetail['recipients_city_id']); ?></td>
                            </tr>
                            <tr>
                              <td width="200px">Email</td>
                              <td class="value"><?php echo $arrDetail['recipients_email']; ?></td>
                            </tr>
                            <tr>
                              <td width="200px">ĐT bàn</td>
                              <td class="value"><?php echo $arrDetail['recipients_phone']; ?></td>
                            </tr>
                            <tr>
                              <td width="200px">Di động</td>
                              <td class="value"><?php echo $arrDetail['recipients_handphone']; ?></td>
                            </tr>
                            <tr>
                              <td width="200px">CMND</td>
                              <td class="value"><?php echo $arrDetail['recipients_indentity_card']; ?></td>
                            </tr>                           
                          </table>                           
                           
                      </div> 
                  </div>
                </div>
              </div>
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
        
        $('#method_id,#status').change(function(){
            search();
        });
        $('#btnSearch').click(function(){
            search();
        });
        $('#email,#fullname,#code,#phone').keypress(function (e) {
          if (e.which == 13) {
            search();
          }
        });
    });   
    function search(){
        var str_link = "index.php?mod=order&act=list";
       
       
        var tmp = $('#method_id').val();
        if(tmp > 0){
            str_link += "&method_id=" + tmp ;
        }
        tmp = $('#status').val();
        if(tmp > 0){
            str_link += "&status=" + tmp ;
        }
        

        tmp = $.trim($('#order').val());
        if(tmp != ''){
            str_link += "&order=" + tmp ;   
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