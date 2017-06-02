<?php
require_once "model/Backend.php";
$modelBE = new Backend;
$link = "index.php?mod=book&act=detail";
$id = (int) $_GET['id'];

$cityArr = $model->getListCity();

$link_form  = "";
$arrDetail = $modelBE->getDetailBooking($id);

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
if (isset($_GET['national_type']) && $_GET['national_type'] > 0) {
    $national_type = (int) $_GET['national_type'];      
    $link.="&national_type=$national_type";
    $link_form.="&national_type=$national_type";
} else {
    $national_type = -1;
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
<div class="arrDetail">
    <div class="col-md-12">
        <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=book&amp;act=list<?php echo $link_form; ?>'">Quay lại</button>    
         <div class="box-header">
                <h3 class="box-title">Cập nhật đặt vé của KH : <?php echo $arrDetail['fullname']; ?></h3>
            </div><!-- /.box-header -->
        <div class="box">            
            <div class="box-body">
              <form action="controller/Order.php" method="POST">
                <input type="hidden" name="book_id" value="<?php echo $id; ?>">
                <input type="hidden" name="back_url" value="<?php echo $link_form; ?>">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Thông tin đặt vé
                    </a>
                  </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                       <div class="col-md-12" >
                          <table class="table table-bbooked tbl_value">
                             
                            <tr>
                              <td width="200px">Trạng thái</td>
                              <td class="value">
                                <select name="status" class="form-control" id="status">  
                                <?php if($arrDetail['status'] != 3 ) { ?>                                  
                                    <option value="2" <?php echo ($arrDetail['status']==2) ? "selected" : ""; ?>>Mới</option>
                                    <option value="1" <?php echo ($arrDetail['status']==1) ? "selected" : ""; ?>>Đã xác nhận</option>
                                    <?php } ?>                                    
                                    <option value="3" <?php echo ($arrDetail['status']==3) ? "selected" : ""; ?>>Huỷ</option>
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td width="200px">Loại vé</td>
                              <td class="value">
                                <?php 
                                if($arrDetail['national_type'] < 3){
                                    if($arrDetail['national_type'] == 1){
                                        echo "Trong nước";
                                    }else{
                                        echo "Quốc tế";
                                    } 
                                }
                                ?>                                
                                <?php 
                                if($arrDetail['type'] == 0){
                                    echo " ( Yêu cầu đặt vé )";
                                }else{
                                    if($arrDetail['type'] == 1){
                                        echo "( Một chiều )";
                                    }else{
                                        echo " ( Khứ hồi )";
                                    } 
                                }
                                
                                ?>   
                              </td>
                            </tr>
                            <tr>
                              <td>Địa điểm</td>
                              <td class="value">
                                   <?php 
                                  if($arrDetail['national_type'] == 1){
                                      $noi_di = $cityArr[$arrDetail['noi_di']]['city_name'];
                                      $noi_den = $cityArr[$arrDetail['noi_den']]['city_name'];
                                  }else{
                                      $noi_di = $arrDetail['noi_di_ngoai'];
                                      $noi_den = $arrDetail['noi_den_ngoai'];
                                  }
                                  ?>
                                  <p>
                                      <span>Nơi đi:</span> <span class="value"><?php echo $noi_di; ?></span>
                                  </p>
                                  <p>
                                      <span>Nơi đến:</span> <span class="value"><?php echo $noi_den; ?></span>
                                  </p>
                              </td>
                            </tr>
                            <tr>
                              <td>Họ tên</td>
                              <td class="value">
                                <input type="text" class="form-control"  value="<?php echo $arrDetail['fullname']; ?>" name="fullname" id="fullname"/>
                              </td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td class="value">
                                <input type="text" class="form-control"  value="<?php echo $arrDetail['email']; ?>" name="email" id="email"/>
                              </td>
                            </tr>
                            <tr>
                              <td>Phone</td>
                              <td class="value">
                                <input type="text" class="form-control"  value="<?php echo $arrDetail['phone']; ?>" name="phone" id="phone"/>
                              </td>
                            </tr>
                            <tr>
                              <td>Địa chỉ</td>
                              <td class="value">
                                <input type="text" class="form-control"  value="<?php echo $arrDetail['address']; ?>" name="address" id="address"/>
                              </td>
                            </tr>
                             <tr>
                              <td width="200px">Ngày đi</td>
                              <td>                                                                
                                <input type="text" class="form-control datetime " value="<?php echo date('d-m-Y', ($arrDetail['depatureDate'])); ?>" name="depatureDate" id="depatureDate"/>
                              </td>
                            </tr>
                            <tr>
                              <td width="200px">Ngày về</td>
                              <td>                                
                                <input type="text" class="form-control datetime " value="<?php if($arrDetail['returnDate'] > 0 )echo date('d-m-Y H:i', ($arrDetail['depatureDate'])); ?>" name="returnDate" id="returnDate"/>
                              </td>
                            </tr>
                            <tr>
                              <td width="200px">Người lớn</td>
                              <td class="value">
                                <select class="form-control" name="adultNo" id="adultNo">                                  
                                  <option value="1" <?php echo ($arrDetail['adultNo'] == 1) ? "selected" : ""; ?>>1</option>
                                  <option value="2" <?php echo ($arrDetail['adultNo'] == 2) ? "selected" : ""; ?>>2</option>
                                  <option value="3" <?php echo ($arrDetail['adultNo'] == 3) ? "selected" : ""; ?>>3</option>
                                  <option value="4" <?php echo ($arrDetail['adultNo'] == 4) ? "selected" : ""; ?>>4</option>
                                </select>                                
                              </td>
                            </tr>
                            <tr>
                              <td width="200px">Trẻ em</td>
                              <td class="value">
                                <select class="form-control" name="childNo" id="childNo">                                  
                                  <option value="0" <?php echo ($arrDetail['childNo'] == 0) ? "selected" : ""; ?>>0</option>
                                  <option value="1" <?php echo ($arrDetail['childNo'] == 1) ? "selected" : ""; ?>>1</option>
                                  <option value="2" <?php echo ($arrDetail['childNo'] == 2) ? "selected" : ""; ?>>2</option>
                                  <option value="3" <?php echo ($arrDetail['childNo'] == 3) ? "selected" : ""; ?>>3</option>
                                  <option value="4" <?php echo ($arrDetail['childNo'] == 4) ? "selected" : ""; ?>>4</option>
                                </select>                                
                              </td>
                            </tr>
                            <tr>
                              <td width="200px">Em bé</td>
                              <td class="value">
                                <select class="form-control" name="infantNo" id="infantNo">                                  
                                  <option value="0" <?php echo ($arrDetail['infantNo'] == 0) ? "selected" : ""; ?>>0</option>
                                  <option value="1" <?php echo ($arrDetail['infantNo'] == 1) ? "selected" : ""; ?>>1</option>
                                  <option value="2" <?php echo ($arrDetail['infantNo'] == 2) ? "selected" : ""; ?>>2</option>
                                  <option value="3" <?php echo ($arrDetail['infantNo'] == 3) ? "selected" : ""; ?>>3</option>
                                  <option value="4" <?php echo ($arrDetail['infantNo'] == 4) ? "selected" : ""; ?>>4</option>
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td>Đặt vào lúc</td>
                              <td class="value">
                                <?php echo date('d-m-Y H:i:s',$arrDetail['created_at']); ?>
                              </td>
                            </tr>
                            <tr>
                              <td>Ghi chú </td>
                              <td class="value">
                                <textarea name="notes" id="notes" arrDetails="5" class="form-control"><?php echo $arrDetail['notes']; ?></textarea>                                  
                              </td>
                            </tr>
                            
                          </table>                           
                           
                      </div>  
                  </div>
                </div>
              </div>
            </div>
           

            <div class="button">

                <button class="btn btn-success btnSave" type="submit">Save</button>

                <button class="btn btn-success" onclick="location.href='index.php?mod=book&amp;act=list<?php echo $link_form; ?>'" type="button">Cancel</button>

            </div>

           </form>
            </div><!-- /.box-body -->
           
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
        $('select.amount').change(function(){          
          var amount = $(this).val();          
          var id =  $(this).find('option:selected').attr('data-id');          
          var id = $(this).find('option:selected').attr('data-book');          
          var price = $('#price_' + id).val();
          var vat = $('#vat').val();
          var ship = $('#ship').val();
          $.ajax({
                url: "ajax/book.php",
                type: "POST",
                async: true,
                dataType :'json',
                data: {
                    'id' : id,
                    'id' : id,
                    'amount' : amount,
                    'price' : price,
                    'vat' : vat,
                    'ship' : ship
                },
                success: function(data){      
                  var total_detail = data.total_detail; 
                  var totalAmount = data.totalAmount; 
                  var totalPrice =   data.totalPrice;
                  var totalPay =   data.totalPay;
                  $('#total_amount').val(addCommas(totalAmount)); 
                  $('#sub_total').val(addCommas(totalPrice));
                  $('#total_'+ id).html(addCommas(total_detail));   
                  $('#total').val(addCommas(totalPay));
                }
            });
        });
  $('a.deleteSP').click(function(){       
      if(confirm('Bạn có chắc chắn xóa ?')){                      
            var id =  $(this).attr('data-id');          
            var id = $(this).attr('data-book');                    
            var vat = $('#vat').val();
            var ship = $('#ship').val();
            var obj = $(this);
            $.ajax({
                  url: "ajax/book.php",
                  type: "POST",
                  async: true,
                  dataType :'json',
                  data: {
                      'id' : id,
                      'id' : id,
                      'amount' : 0,                      
                      'vat' : vat,
                      'ship' : ship
                  },
                  success: function(data){                          
                    var totalAmount = data.totalAmount;                     
                    var totalPay =   data.totalPay;
                    var totalPrice =   data.totalPrice;
                    $('#total_amount').val(addCommas(totalAmount));                                      
                    $('#total').val(addCommas(totalPay));
                    $('#sub_total').val(addCommas(totalPrice));
                    obj.parent().parent().remove();
                  }
              });
          }
        });
        $('.datetime').datetimepicker({
            format:'d-m-Y H:i'
        });
        
        $('#national_type,#status').change(function(){
            //search();
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
        var str_link = "index.php?mod=book&act=list";
       
       
        var tmp = $('#national_type').val();
        if(tmp > 0){
            str_link += "&national_type=" + tmp ;
        }
        tmp = $('#status').val();
        if(tmp > 0){
            str_link += "&status=" + tmp ;
        }
        

        tmp = $.trim($('#book').val());
        if(tmp != ''){
            str_link += "&book=" + tmp ;   
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
function addCommas(nStr)
{
  nStr += '';
  x = nStr.split('.');
  x1 = x[0];
  x2 = x.length > 1 ? '.' + x[1] : '';
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(x1)) {
    x1 = x1.replace(rgx, '$1' + ',' + '$2');
  }
  return x1 + x2;
}
</script>