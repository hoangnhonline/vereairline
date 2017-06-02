<?php
require_once "model/Backend.php";
$modelBE = new Backend;

$link = "index.php?mod=order&act=list-customer";

$customer_id = (int) $_GET['customer_id'];
$detail = $model->getDetailCustomer($customer_id);
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
    $sort_column = (int) $_GET['sort_column'];      
    $link.="&sort_column=$sort_column";
    $link_form.="&sort_column=$sort_column";
} else {
    $sort_column = 'delivery_date';
}
if (isset($_GET['sort_value'])) {
    $sort_value = (int) $_GET['sort_value'];      
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
$intfromdate = null;
if ($fromdate)
{
    list($intDay, $intMonth, $intYear) = explode('-', $fromdate);
    $intfromdate = mktime(0, 0, 0, $intMonth, $intDay, $intYear);
    $intfromdate -= 60;
}
$inttodate = null;
if ($todate)
{
    list($intDay, $intMonth, $intYear) = explode('-', $todate);
    $inttodate = mktime(0, 0, 0, $intMonth, $intDay, $intYear);
    $inttodate += 60 * 60 * 24;
}
if (isset($_GET['full_name']) && $_GET['full_name'] != '') {       
    $back_url .="&full_name=".$_GET['full_name'];
}
if (isset($_GET['username']) && $_GET['username'] != '') {       
    $back_url .="&username=".$_GET['username'];
}
if (isset($_GET['handphone']) && $_GET['handphone'] != '') {       
    $back_url .="&handphone=".$_GET['handphone'];
}
if (isset($_GET['address']) && $_GET['address'] != '') {       
    $back_url .="&address=".$_GET['address'];
}
if (isset($_GET['email']) && $_GET['email'] != '') {       
    $back_url .="&email=".$_GET['email'];
}
if (isset($_GET['status']) && $_GET['status'] > -1) {    
    $back_url.="&status=".$_GET['status'];
}
$arrTotal = $modelBE->getListOrderCustomer($customer_id,$status,$method_id,$intfromdate,$inttodate, -1, -1);
$limit = 64;
$total_page = ceil($arrTotal['total'] / $limit);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$offset = $limit * ($page - 1);

$arrList = $modelBE->getListOrderCustomer($customer_id,$status,$method_id,$intfromdate,$inttodate,$offset, $limit);
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
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=customer&act=list<?php echo $back_url; ?>'">Back</button> 
         <div class="box-header">
                <h3 class="box-title">Danh sách đơn hàng của khách hàng: <span style="color:blue"><?php echo $detail['full_name']; ?></span></h3>
            </div><!-- /.box-header -->
        <div class="box">
            <div class="box_search">                                    
                   <table width="100%" id="search_advance">                        
                        <tr>
                            <td>Thanh toán</td>
                            <td>
                                <select name="method_id" class="select_search" id="method_id">
                                    <option value="-1">Tất cả</option>
                                    <option value="1" <?php echo ($_GET['method_id']==1) ? "selected" : ""; ?>>CHUYỂN KHOẢN QUA NGÂN HÀNG</option>                        
                                    <option value="2" <?php echo ($_GET['method_id']==2) ? "selected" : ""; ?>>THANH TOÁN TẠI CỬA HÀNG</option>                        
                                    <option value="3" <?php echo ($_GET['method_id']==3) ? "selected" : ""; ?>>GIAO HÀNG THU TIỀN TẬN NƠI (COD)</option>                        
                                </select>
                            </td>
                            <td>Trạng thái</td>
                            <td>
                                <select name="status" class="select_search" id="status">
                                    <option value="-1">Tất cả</option>
                                    <option value="1" <?php echo ($_GET['status']==1) ? "selected" : ""; ?>>Đang xử lý</option>                        
                                    <option value="2" <?php echo ($_GET['status']==2) ? "selected" : ""; ?>>Mới</option>
                                    <option value="4" <?php echo ($_GET['status']==4) ? "selected" : ""; ?>>Hoàn thành</option>
                                    <option value="3" <?php echo ($_GET['status']==3) ? "selected" : ""; ?>>Huỷ</option>
                                </select>
                            </td>                            

                            <td>Từ ngày</td>
                            <td>
                                <input type="text" class="text_order" id="fromdate" name="fromdate" value="<?php echo (trim($fromdate)!='') ? $fromdate: ""; ?>" /> 
                            </td>

                            <td>Đến ngày</td>
                            <td>
                                <input type="text" class="text_order" id="todate" name="todate" value="<?php echo (trim($todate)!='') ? $todate: ""; ?>" /> 
                            </td>
                            <td><button class="btn btn-primary btn-sm right" id="btnSearch" type="button">Tìm kiếm</button></td>
                        </tr>
                   </table>                                     
                
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped" id="tbl_list">
                    <tbody><tr>
                        <th style="width: 1%">STT</th> 
                        <th>Mã ĐH</th>                      
                        <th>Người mua</th>
                        <th>Email</th>
                        <th style="text-align:right">Điện thoại</th>                  
                        <th style="text-align:right">Tổng SP</th>
                        <th style="text-align:right">Tổng tiền</th> 
                        <th>Ngày mua</th>                        
                        <th>Ngày giao</th>                        
                        <th>Trạng thái</th>    
                        <th style="width: 40px;white-space:nowrap">Thao tác</th>
                    </tr>
                    <?php
                    if(!empty($arrList['data'])){
                    $i = ($page-1) * $limit;                    
                    foreach($arrList['data'] as $row){
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>                        
                        <td><?php echo $row['order_code']; ?></td>
                        <td><?php echo $row['buyer_name']; ?></td>
                        <td><?php echo $row['buyer_email']; ?></td>
                        <td align="right"><?php echo $row['buyer_handphone']; ?></td>
                        <td align="right"><?php echo $row['total_amount']; ?></td>
                        <td align="right"><?php echo number_format($row['total']); ?></td>
                        <td><?php echo date('d-m-Y H:i',$row['created_at']); ?></td>  
                        <td><?php echo date('d-m-Y H:i',$row['delivery_date']); ?></td>                          
                        <td><?php 
                        $status = $row['status'];
                        if($status == 1) echo "Đang xử lý";
                        if($status == 2) echo "Mới";                        
                        if($status == 3) echo "Hủy";
                        if($status == 4) echo "Hoàn thành";
                        ?>
                        </td>    
                                              
                        <td style="white-space:nowrap">
                            <a title="Click để xem chi tiết" href="index.php?mod=order&act=detail-customer&order_id=<?php echo $row['order_id']; ?><?php echo $link_form; ?>"     

                                <i class="fa fa-fw fa-file-text-o"></i>

                            </a>
                            <a title="Click để chỉnh sửa" href="index.php?mod=order&act=form-customer&order_id=<?php echo $row['order_id']; ?><?php echo $link_form; ?>">
                                <i class="fa fa-fw fa-edit"></i>
                            </a>
                            <a title="Click để xóa" href="javascript:;" alias="<?php echo $row['order_code']; ?>" id="<?php echo $row['order_id']; ?>" mod="order" class="link_delete" >    
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
               
                <?php echo $modelBE->phantrang($page, PAGE_SHOW, $total_page, $link); ?>
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
        $('#method_id,#status').change(function(){
            search();
        });
        $('#btnSearch').click(function(){
            search();
        });     
    });   
    function search(){
        var str_link = "index.php?mod=order&act=list-customer&customer_id=<?php echo $customer_id; ?>";
        
        var tmp = $('#method_id').val();
        if(tmp > 0){
            str_link += "&method_id=" + tmp ;
        }
        tmp = $('#status').val();
        if(tmp > 0){
            str_link += "&status=" + tmp ;
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