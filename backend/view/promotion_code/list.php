<?php

require_once "model/Backend.php";

$model = new Backend;

$link = "index.php?mod=promotion_code&act=list";


if (isset($_GET['status']) && $_GET['status'] > -1) {

    $status = (int) $_GET['status'];      

    $link.="&status=$status";

} else {

    $status = -1;

}


$limit = 20;

$arrTotal = $model->getListCode($status, -1, -1);



$total_page = ceil($arrTotal['total'] / $limit);



$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;



$offset = $limit * ($page - 1);



$arrList = $model->getListCode($status,$offset, $limit);

?>



<div class="row">

    <div class="col-md-12">

    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=promotion_code&act=form'">Tạo mới</button>        
    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=promotion_code&act=mail'">Gửi mail</button>        
    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=promotion_code&act=listmail'">List mail</button>        

         <div class="box-header">

                <h3 class="box-title">Danh sách promotion code</h3>

            </div><!-- /.box-header -->

        <div class="box">

            <div class="box_search">

                

                <form method="get" id="form_search" name="form_search">

                    <input type="hidden" name="mod" value="promotion_code" />

                    <input type="hidden" name="act" value="list" />

                   Trạng thái
                    <select name="status" class="event_change select_search">

                        <option value="-1">Tất cả</option>  

                        <option value="1" <?php echo ($status==1) ? "selected" : ""; ?>>Chưa kich hoat</option>   

                        <option value="2" <?php echo ($status==2) ? "selected" : ""; ?>>Đã kich hoat</option>        

                    </select>                   

                </form>

            </div>

            <div class="box-body">

                <table class="table table-bordered table-striped">

                    <tbody><tr>

                        <th style="width: 10px">STT</th>

                        <th width="300">Mã</th>
                        <th width="140">Loại</th>
                        <th width="140">Số lượng</th>
                        <th width="140">Giá trị</th>
                        <th width="1%">Trạng thái</th>                                              

                        <th style="width: 40px">Thao tác</th>

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
                        <?php echo $row['type']==1 ? "Giảm giá" : ($row['type']==2 ? "Trừ tiền" : "Quà tặng"); ?>
                        </td>
                        <td>
                        <?php echo $row['amount']; ?>
                        </td>
                                                              
                        <td>
                        <?php echo $row['code_value']; ?>
                        </td>    
                        <td align="center">
                        <?php if($row['status']==1){ ?>
                            <img src="<?php echo STATIC_URL; ?>/img/ok.png" title="Đã kích hoạt" alt="Đã kích hoạt" class="active" 
                            data-id="<?php echo $row['code_id']; ?>" data-status="2" style="cursor:pointer"
                            />
                        <?php }else{ ?>
                            <img src="<?php echo STATIC_URL; ?>/img/error.png" title="Chưa kích hoạt" alt="Chưa kích hoạt" class="active" 
                            data-id="<?php echo $row['code_id']; ?>" data-status="1" style="cursor:pointer"
                            />
                        <?php } ?>
                        </td>                                    

                        <td style="white-space:nowrap">                            

                            <a href="index.php?mod=promotion_code&act=form&code_id=<?php echo $row['code_id']; ?>">

                                <i class="fa fa-fw fa-edit"></i>

                            </a>

                            <a href="javascript:;" alias="<?php echo $row['code']; ?>" id="<?php echo $row['code_id']; ?>" mod="promotion_code" class="link_delete" >    

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