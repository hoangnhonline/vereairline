<?php
require_once "model/Backend.php";
$modelBE = new Backend;
$link = "index.php?mod=order&act=detail";
$order_id = (int) $_GET['order_id'];
$sql = "SELECT * FROM order_detail WHERE order_id = $order_id ";

$rs = mysql_query($sql);

$arrDetail = $modelBE->getDetailOrder($order_id);
if (isset($_GET['status']) && $_GET['status'] > 0) {
    $status = (int) $_GET['status'];      
    $link.="&status=$status";
    $link_form.="&status=$status";
} else {
    $status = -1;
}
if (isset($_GET['customer_id']) && $_GET['customer_id'] > 0) {
    $customer_id = (int) $_GET['customer_id'];      
    $link.="&customer_id=$customer_id";
    $link_form.="&customer_id=$customer_id";
}
if (isset($_GET['method_id']) && $_GET['method_id'] > 0) {
    $method_id = (int) $_GET['method_id'];      
    $link.="&method_id=$method_id";
    $link_form.="&method_id=$method_id";
} else {
    $method_id = -1;
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
$arrMethod = $model->getListMethod();
$arrCity = $model->getListCity();
?>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=order&amp;act=list-customer<?php echo $link_form; ?>'">Quay lại</button>    
         <div class="box-header">
                <h3 class="box-title">Cập nhật đơn hàng : <?php echo $arrDetail['order_code']; ?></h3>
            </div><!-- /.box-header -->
        <div class="box">            
            <div class="box-body">
              <form action="controller/Order.php" method="POST">
                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                <input type="hidden" name="back_url" value="<?php echo $link_form; ?>">
                <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
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
                              <td class="value">
                                <input type="text" class="form-control datetime " value="<?php echo date('d-m-Y H:i',$arrDetail['created_at']); ?>" name="created_at" id="created_at"/>
                              </td>
                            </tr>
                            <tr>
                              <td>Ngày giao hàng </td>
                              <td class="value">
                                <input type="text" class="form-control datetime"  value="<?php echo date('d-m-Y H:i',$arrDetail['delivery_date']); ?>" name="delivery_date" id="delivery_date"/>
                              </td>
                            </tr>
                            <tr>
                              <td>Số lượng sản phẩm </td>
                              <td class="value">
                                <input type="text" class="form-control" value="<?php echo number_format($arrDetail['total_amount']); ?>" name="total_amount" id="total_amount"/>
                              </td>
                            </tr>
                            <tr>
                              <td>Giá trị sản phẩm</td>
                              <td class="value">
                                <input type="text" class="form-control" value="<?php echo number_format($arrDetail['sub_total']) ;?>" name="sub_total" id="sub_total"/>
                              </td>
                            </tr>
                            <tr>
                              <td>VAT</td>
                              <td class="value">
                                <input type="text" value="<?php echo $arrDetail['vat']; ?>" name="vat" id="vat"/> %
                              </td>
                            </tr>
                            <tr>
                              <td>Phí giao hàng</td>
                              <td class="value">
                                <input type="text" class="form-control" value="<?php echo number_format($arrDetail['ship']); ?>" name="ship" id="ship"/>
                              </td>
                            </tr>
                            <tr>
                              <td>Tổng tiền</td>
                              <td class="value">
                                <input type="text" class="form-control" value="<?php echo number_format($arrDetail['total']); ?>" name="total" id="total"/>
                              </td>
                            </tr>  
                            <tr>
                              <td>Phương thức thanh toán </td>
                              <td class="value">
                                <select name="method_id" id="method_id" class="form-control">
                                  <?php foreach ($arrMethod as $key => $value) {
                                    ?>
                                    <option value="<?php echo $key; ?>"
                                      <?php if($arrDetail['method_id']== $key) echo "selected"; ?>
                                      ><?php echo $value; ?></option>
                                    <?php
                                  } ?>
                                </select>
                              </td>
                            </tr>                                                  
                            
                            <tr>
                              <td>Ghi chú</td>
                              <td class="value">
                                <textarea name="order_note" id="order_note" rows="5" class="form-control"><?php echo $arrDetail['order_note']; ?></textarea>                               
                              </td>
                            </tr>
                            <tr>
                              <td>Nhân viên giao hàng </td>
                              <td class="value">
                                <input type="text" class="form-control" value="<?php echo $arrDetail['staff_name']; ?>" name="staff_name" id="staff_name"/>
                              </td>
                            </tr>
                            <tr>
                              <td>Ghi chú cho nhân viên</td>
                              <td class="value">
                                <textarea name="staff_note" id="staff_note" rows="5" class="form-control"><?php echo $arrDetail['staff_note']; ?></textarea>                                  
                              </td>
                            </tr>
                            <tr>
                              <td>Nhân viên cập nhật</td>
                              <td class="value"><?php  if($arrDetail['updated_by'] > 0) echo $model->getUserById($arrDetail['updated_by']); ?></td>
                            </tr>
                            <tr>
                              <td>Ngày cập nhật</td>
                              <td class="value"><?php if($arrDetail['updated_at'] > 0) echo date('d-m-Y H:i',$arrDetail['updated_at']); ?></td>
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
                              <td class="value">
                                <input type="text" value="<?php echo $arrDetail['buyer_name']; ?>" class="form-control" name="buyer_name" id="buyer_name"/>
                              </td>
                            </tr>
                             <tr>
                              <td width="200px">Giới tính</td>
                              <td class="value">
                                <select name="buyer_gender" id="buyer_gender" class="form-control">                              
                                    <option value="1" <?php if($arrDetail['buyer_gender']== 1) echo "selected"; ?>>Nam</option>
                                    <option value="2" <?php if($arrDetail['buyer_gender']== 2) echo "selected"; ?>>Nữ</option>                                  
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td width="200px">Địa chỉ</td>
                              <td class="value">
                                <textarea name="buyer_address" id="buyer_address" rows="5" class="form-control"><?php echo $arrDetail['buyer_address']; ?></textarea>                               
                                
                              </td>
                            </tr>
                            <tr>
                              <td width="200px">Tỉnh/TP</td>
                              <td class="value">
                                <select name="buyer_city_id" id="buyer_city_id" class="form-control">
                                  <?php foreach ($arrCity as $value) {
                                    ?>
                                    <option value="<?php echo $value['city_id']; ?>"
                                      <?php if($arrDetail['buyer_city_id']== $value['city_id']) echo "selected"; ?>
                                      ><?php echo $value['city_name']; ?></option>
                                    <?php
                                  } ?>
                                </select>                                
                              </td>
                            </tr>
                            <tr>
                              <td width="200px">Email</td>
                              <td class="value">
                                <input type="text" value="<?php echo $arrDetail['buyer_email']; ?>" class="form-control" name="buyer_email" id="buyer_email"/>
                              </td>
                            </tr>
                            <tr>
                              <td width="200px">ĐT bàn</td>
                              <td class="value">
                                <input type="text" value="<?php echo $arrDetail['buyer_phone']; ?>" class="form-control" name="buyer_phone" id="buyer_phone"/>
                              </td>
                            </tr>
                            <tr>
                              <td width="200px">Di động</td>
                              <td class="value">
                                <input type="text" class="form-control" value="<?php echo $arrDetail['buyer_handphone']; ?>" name="buyer_handphone" id="buyer_handphone"/>
                              </td>
                            </tr>
                            <tr>
                              <td width="200px">CMND</td>
                              <td class="value">
                                <input type="text" class="form-control" value="<?php echo $arrDetail['buyer_indentity_card']; ?>" name="buyer_indentity_card" id="buyer_indentity_card"/>
                              </td>
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
                              <td class="value">
                                <input type="text" class="form-control" value="<?php echo $arrDetail['recipients_name']; ?>" name="recipients_name" id="recipients_name"/>
                              </td>
                            </tr>
                             <tr>
                              <td width="200px">Giới tính</td>
                              <td class="value">
                                <select name="recipients_gender" id="recipients_gender" class="form-control">                              
                                    <option value="1" <?php if($arrDetail['recipients_gender']== 1) echo "selected"; ?>>Nam</option>
                                    <option value="2" <?php if($arrDetail['recipients_gender']== 2) echo "selected"; ?>>Nữ</option>                                  
                                </select> 
                              </td>
                            </tr>
                            <tr>
                              <td width="200px">Địa chỉ</td>
                              <td class="value">
                                <input type="text" class="form-control" value="<?php echo $arrDetail['recipients_address']; ?>" name="recipients_address" id="recipients_address"/>
                              </td>
                            </tr>
                            <tr>
                              <td width="200px">Tỉnh/TP</td>
                              <td class="value">
                                <select name="recipients_city_id" id="recipients_city_id" class="form-control">
                                  <?php foreach ($arrCity as $value) {
                                    ?>
                                    <option value="<?php echo $value['city_id']; ?>"
                                      <?php if($arrDetail['recipients_city_id']== $value['city_id']) echo "selected"; ?>
                                      ><?php echo $value['city_name']; ?></option>
                                    <?php
                                  } ?>
                                </select> 
                              </td>
                            </tr>
                            <tr>
                              <td width="200px">Email</td>
                              <td class="value">
                                <input type="text" class="form-control" value="<?php echo $arrDetail['recipients_email']; ?>" name="recipients_email" id="recipients_email"/>
                              </td>
                            </tr>
                            <tr>
                              <td width="200px">ĐT bàn</td>
                              <td class="value">
                                <input type="text" class="form-control" value="<?php echo $arrDetail['recipients_phone']; ?>" name="recipients_phone" id="recipients_phone"/>
                              </td>
                            </tr>
                            <tr>
                              <td width="200px">Di động</td>
                              <td class="value">
                                <input type="text" class="form-control" value="<?php echo $arrDetail['recipients_handphone']; ?>" name="recipients_handphone" id="recipients_handphone"/>                                
                            </td>
                            </tr>
                            <tr>
                              <td width="200px">CMND</td>
                              <td class="value">
                                <input type="text"class="form-control"  value="<?php echo $arrDetail['recipients_indentity_card']; ?>" name="recipients_indentity_card" id="recipients_indentity_card"/>
                              </td>
                            </tr>                           
                          </table>                           
                           
                      </div> 
                  </div>
                </div>
              </div>
            </div>
           

            <div class="button">

                <button class="btn btn-danger btnSave" type="submit">Save</button>

                <button class="btn btn-danger" onclick="location.href='index.php?mod=order&amp;act=list-customer<?php echo $link_form; ?>'">Cancel</button>

            </div>

           </form>
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
        $('.datetime').datetimepicker({
            format:'d-m-Y H:i'
        });
        
        $('#method_id,#status').change(function(){
           // search();
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