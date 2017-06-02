<?php 
require_once "model/Backend.php"; 
$model = new Backend; 
$arrCity = $model->getListCity();
if(isset($_GET[ 'id']))
{ 
    $id=( int) $_GET[ 'id']; 
    
    $detail=$model->getDetailCustomer($id);
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
?>
<div class="row">
    <div class="col-md-8">
        <!-- Custom Tabs -->
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=customer&act=list<?php echo $back_url; ?>'">Back</button>
        <div style="clear:both;margin-bottom:10px"></div>
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?php echo ($id > 0) ? "Cập nhật" : "Tạo mới" ?> khách hàng </h3> </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="controller/Customer.php">                
                <?php if($id> 0){ ?>
                <input type="hidden" value="<?php echo $id; ?>" name="id" />
                <?php } ?>
                <input type="hidden" value="<?php echo $back_url; ?>" name="back_url" />
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tên khách hàng<span class="required"> ( * ) </span></label>
                        <input value="<?php echo isset($detail['full_name'])  ? $detail['full_name'] : " " ?>" type="text" name="full_name" id="full_name" class="form-control required"> 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">ĐT bàn</label>
                        <input value="<?php echo isset($detail['phone'])  ? $detail['phone'] : " " ?>" type="text" name="phone" id="phone" class="form-control"> 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Di động<span class="required"> ( * ) </span></label>
                        <input value="<?php echo isset($detail['handphone'])  ? $detail['handphone'] : " " ?>" type="text" name="handphone" id="handphone" class="form-control"> 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Địa chỉ </label>
                        <input value="<?php echo isset($detail['address'])  ? $detail['address'] : " " ?>" type="text" name="address" id="address" class="form-control"> 
                    </div>                    
                     <div class="form-group">
                        <label for="exampleInputEmail1">Email <span class="required"> ( * ) </span></label>
                        <input value="<?php echo isset($detail['email'])  ? $detail['email'] : " " ?>" type="text" name="email" id="email" class="form-control required"> 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tên đăng nhập <span class="required"> ( * ) </span></label>
                        <input value="<?php echo isset($detail['username'])  ? $detail['username'] : " " ?>" readonly="true"  type="text" name="username" id="username" class="form-control required"> 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Ngày ĐK</label>
                        <input value="<?php echo isset($detail['created_at'])  ? date('d-m-Y H:i',$detail['created_at']) : " " ?>"  type="text" name="created_at" id="created_at" class="form-control" readonly="true"> 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Login cuối</label>
                        <input value="<?php echo isset($detail['last_login'])  ? date('d-m-Y H:i',$detail['last_login']) : " " ?>"  type="text" name="last_login" id="last_login" class="form-control" readonly="true">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Trạng thái <span class="required"> ( * ) </span></label>
                        <select name="status" id="status" class="form-control">                                                  
                            <option value="1" <?php if($detail['status']==1) echo "selected"; ?>>Bật</option>
                            <option value="0" <?php if($detail['status']==0) echo "selected"; ?>>Tắt</option>                            
                        </select> 
                    </div>                                        
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-primary btnSave" type="submit">Save</button>
                    <button class="btn btn-primary" type="button" onclick="location.href='index.php?mod=customer&act=list<?php echo $back_url; ?>'" >Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /.col -->
</div>