<?php

require_once "model/Backend.php";

$model = new Backend;

$link = "index.php?mod=promotion_code&act=list";


if (isset($_GET['status']) && $_GET['status'] > -1) {

    $status = (int) $_GET['status'];      

    $link.="&status=$status";

} else {

    $status = 1;

}
if (isset($_GET['code_id']) && $_GET['code_id'] > -1) {

    $code_id = (int) $_GET['code_id'];      

    $link.="&code_id=$code_id";

} else {

    $code_id = -1;

}


$limit = 20;

$arrTotal = $model->getListEmailNhanCode($code_id, $status, -1, -1);



$total_page = ceil($arrTotal['total'] / $limit);



$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;



$offset = $limit * ($page - 1);



$arrList = $model->getListEmailNhanCode($code_id,$status,$offset, $limit);


// list nha xe

$arrTotal = $model->getListCode(1, -1, -1);

?>



<div class="row">

    <div class="col-md-12">

    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=promotion_code&act=list'">BACK</button>        

         <div class="box-header">

                <h3 class="box-title">Danh sách email nhan promotion code</h3>

            </div><!-- /.box-header -->

        <div class="box">

            <div class="box_search">

                

                <form method="get" id="form_search" name="form_search">

                    <input type="hidden" name="mod" value="promotion_code" />

                    <input type="hidden" name="act" value="listmail" />
                    CODE <select class="event_change select_search" style="width:200px" name="code_id" id="code_id">

                        <option value="-1">---Tất cả---</option> 

                         <?php if(!empty($arrTotal['data'])){

                            foreach ($arrTotal['data'] as $value) {

                                ?>

                                <option <?php echo $code_id == $value['code_id'] ? "selected" : ""; ?> value="<?php echo $value['code_id']; ?>"><?php echo $value['code']; ?></option> 

                                <?php 

                            }}

                            ?>                           

                    </select>
                   Status
                    <select name="status" class="event_change select_search">

                        <option value="0">Chọn</option>                        

                        <option value="1" <?php echo ($status==1) ? "selected" : ""; ?>>Chưa sử dụng</option>   

                        <option value="2" <?php echo ($status==2) ? "selected" : ""; ?>>Đã sử dụng</option>        

                    </select>                   

                </form>

            </div>

            <div class="box-body">

                <table class="table table-bordered table-striped">

                    <tbody><tr>

                        <th style="width: 1%">No.</th>
                        <th width="70">Code</th>
                        <th width="150">Email</th>                     
                        
                        <th width="1%">Status</th>                                              

                        <th style="width: 1%">Action</th>

                    </tr>

                    <?php

                    $i = ($page-1) * $limit; 

                    if(!empty($arrList['data'])){                   

                    foreach($arrList['data'] as $row){

                    $i++;

                    ?>

                    <tr>

                        <td align="center"><?php echo $i; ?></td>                        
                        <td>
                        <?php echo $row['code']; ?>
                       </td>
                        <td>
                        <?php echo $row['email']; ?>
                       </td>
                        <td align="center">
                        <?php if($row['status']==1){ ?>
                            <img src="<?php echo STATIC_URL; ?>/img/ok.png" title="Chưa sử dụng" alt="Chưa sử dụng" class="active" 
                            data-id="<?php echo $row['code_id']; ?>" data-status="2" style="cursor:pointer"
                            />
                        <?php }elseif($row['status']==2){ ?>
                            <img src="<?php echo STATIC_URL; ?>/img/error.png" title="Đã sử dụng" alt="Đã sử dụng" class="active" 
                            data-id="<?php echo $row['code_id']; ?>" data-status="1" style="cursor:pointer"
                            />
                        <?php }else{ ?>
                        <span style="color:red">Chưa đánh giá</span>
                        <?php } ?>
                        </td>                                    

                        <td style="white-space:nowrap;text-align:center">                                                        
                            <a href="javascript:;" alias="<?php echo $row['email']; ?>" id="<?php echo $row['id']; ?>" mod="email_code" class="link_delete" >    

                                <i class="fa fa-fw fa-trash-o"></i>

                            </a>    

                            

                        </td>

                    </tr>      

                    <?php } }else{ ?>              

                    <tr>

                        <td colspan="8" class="error_data">Không tìm thấy dữ liệu!</td>

                    </tr>

                    <?php } ?>

                </tbody></table>

            </div><!-- /.box-body -->

            <div class="box-footer clearfix">           

                <?php echo $model->phantrang($page, PAGE_SHOW, $total_page, $link); ?>

            </div>

        </div><!-- /.box -->                           

    </div><!-- /.col -->

   

</div>
<script type="text/javascript">
$(function(){
    $('img.active').click(function(){
        var obj = $(this);
        var status = obj.attr('data-status');
        var str_confirm = (status==2) ? "Bạn có chắc chắn bỏ kích hoạt ?" : "Bạn có chắc chắn kích hoạt ?";
        var src_img = (status==2) ? "<?php echo STATIC_URL; ?>/img/error.png" : "<?php echo STATIC_URL; ?>/img/ok.png";
        if(confirm(str_confirm)){
            $.ajax({
                url: "ajax/process.php",
                type: "POST",
                async: true,
                data: {
                    'code_id' : obj.attr('data-id'),
                    'status' : status,
                    'mod' : 'code',
                    'action' : 'active'
                },
                success: function(data){                    
                    obj.attr('src',src_img);
                    alert(data);                    
                }
            });
        }else{
            return false;
        }
    });
});
</script>