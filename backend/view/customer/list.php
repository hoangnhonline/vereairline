<?php
require_once "model/Backend.php";
$model = new Backend;
if (isset($_GET['status']) && $_GET['status'] > -1) {
    $status = (int) $_GET['status'];    
    $link.="&status=$status";
    $link_form.="&status=$status";    
} else {
    $status = -1;
}
if(isset($_GET['full_name'])){
    $full_name = $model->processData($_GET['full_name']);
    $link.='&full_name='.$full_name;
    $link_form.='&full_name='.$full_name;
}else{
    $full_name='';
}
if(isset($_GET['handphone'])){
    $handphone = $model->processData($_GET['handphone']);
    $link.='&handphone='.$handphone;
    $link_form.='&handphone='.$handphone;
}else{
    $handphone='';
}
if(isset($_GET['address'])){
    $address = $model->processData($_GET['address']);
    $link.='&address='.$address;
    $link_form.='&address='.$address;
}else{
    $address='';
}
if(isset($_GET['email'])){
    $email = $model->processData($_GET['email']);
    $link.='&email='.$email;
    $link_form.='&email='.$email;
}else{
    $email='';
}
if(isset($_GET['username'])){
    $username = $model->processData($_GET['username']);
    $link.='&username='.$username;
    $link_form.='&username='.$username;
}else{
    $username='';
}
$limit = 20;
$arrTotal = $model->getListCustomer($full_name,$handphone,$address,$email,$username,$status,-1, -1);
$total_page = ceil($arrTotal['total'] / $limit);
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$link_form.='&page='.$page;
$offset = $limit * ($page - 1);
$arrList = $model->getListCustomer($full_name,$handphone,$address,$email,$username,$status,$offset, $limit);
?>
<div class="row">
    <div class="col-md-12">        
        <div class="box-header">
            <h3 class="box-title">Danh sách khách hàng</h3>
        </div><!-- /.box-header -->
        <div class="box">
            <div class="box_search">
                <form method="get" id="form_search" name="form_search">
                    <input type="hidden" name="mod" value="customer" />
                    <input type="hidden" name="act" value="list" />
                    Tên khách hàng
                    <input type="text" name="full_name" value="<?php if(isset($_GET['full_name'])) echo $_GET['full_name']; ?>" id="full_name" />                 
                    &nbsp;&nbsp;&nbsp;      
                    Số điện thoại
                    <input type="text" style="width:100px" name="handphone" value="<?php if(isset($_GET['handphone'])) echo $_GET['handphone']; ?>" id="handphone" />                 
                    &nbsp;&nbsp;&nbsp;  
                    Địa chỉ
                    <input type="text" name="address" value="<?php if(isset($_GET['address'])) echo $_GET['address']; ?>" id="address" />                 
                    <br />
                    Email
                    <input type="text" name="email" value="<?php if(isset($_GET['email'])) echo $_GET['email']; ?>" id="email" />                 
                   &nbsp;&nbsp;&nbsp; Tên đăng nhập
                    <input type="text" name="username" value="<?php if(isset($_GET['username'])) echo $_GET['username']; ?>" id="username" />                 
                    &nbsp;&nbsp;&nbsp; 
                    Trạng thái
                    <select name="status" id="hidden" style="width:80px !important;height:25px;">
                        <option value="-1">Tất cả</option>
                        <option value="1" <?php if($status==1) echo "selected"; ?>>Bật</option>
                        <option value="0" <?php if($status==0) echo "selected"; ?>>Tắt</option>
                    </select>    
                    &nbsp;&nbsp;&nbsp;
                    <button class="btn btn-primary btn-sm right" type="submit">Tìm kiếm</button>
                </form>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped" id="tbl_list">
                    <thead>
                        <tr>
                            <th width="1%">STT </th>                            
                            <th width="30%">Tên</th>
                            <th width="8%" style="white-space:nowrap">Điện thoại</th>
                            <th width="40%">Địa chỉ</th>  
                            <th width="20%">Email</th>
                            <th width="20%" style="white-space:nowrap">Tên đăng nhập</th>                                                      
							<th width="8%" style="white-space:nowrap">Ngày ĐK</th>
							<th width="8%" style="white-space:nowrap">Login cuối</th>
                            <th width="1%" style="white-space:nowrap">Trạng thái </th>
                            <th width="1%" style="white-space:nowrap">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $i = 0;

                        if(!empty($arrList['data'])){                   

                        foreach($arrList['data'] as $customer){

                        $i++;                                                
                        ?>
                        <tr id="row-<?php echo $customer['id']; ?>">
                            <td style="width:1%"><span class="order"><?php echo $i; ?></span></td>                           
                            <td>
                                <a href="index.php?mod=customer&act=form&id=<?php echo $customer['id']; ?><?php echo $link_form; ?>">
                                    <?php echo $customer['full_name']; ?>
                                </a>                              
                            </td>  
                            <td style="vertical-align:top">
                                <?php echo $customer['handphone']; ?>                             
                            </td>                
                            <td style="vertical-align:top">
                                <?php echo $customer['address']; ?>                             
                            </td>                                 
                            <td style="vertical-align:top">
                                <?php echo $customer['email']; ?>                             
                            </td>
                            <td style="vertical-align:top">
                                <?php echo $customer['username']; ?>                             
                            </td>
							
							
							<td style="vertical-align:top;white-space:nowrap">
                                <?php echo date('d-m-Y',$customer['created_at']); ?>                             
                            </td>
                            <td style="white-space:nowrap"><?php echo date('d-m-Y',$customer['last_login']); ?></td>                                             
                            <td style="text-align:center"><?php echo $customer['status'] == 1 ? "<span style='color:blue'>Bật</span>" : "<span style='color:red'>Tắt</span>"; ?></td>
                            <td style="white-space:nowrap">
                                <a title="Xem đơn hàng" href="index.php?mod=order&act=list-customer&customer_id=<?php echo $customer['id']; ?><?php echo $link_form; ?>"     

                                    <i class="fa fa-fw fa-file-text-o"></i>

                                </a>
                                <?php if($model->checkprivilege(24)){ ?>
                                <a href="index.php?mod=customer&act=form&id=<?php echo $customer['id']; ?><?php echo $link_form; ?>">
                                    <i class="fa fa-fw fa-edit"></i>
                                </a>
                                <?php } ?>
                                <?php if($model->checkprivilege(25)){ ?>
                                <a href="javascript:;" alias="<?php echo $customer['full_name']; ?>" id="<?php echo $customer['id']; ?>" mod="customer" class="link_delete" >    
                                    <i class="fa fa-fw fa-trash-o"></i>
                                </a>
                                <?php } ?>
                            </td>
                        </tr> 
                        <?php } }else{ ?>   
                        <tr>
                            <td colspan="10" class="error_data">Không tìm thấy dữ liệu!</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix"></div>

        </div><!-- /.box -->                           

    </div><!-- /.col -->
</div>
<script type="text/javascript">
    $(function(){
        $('#is_hot,#cate_type_id').change(function(){
            $('#form_search').submit();
        });
        
    });
</script>