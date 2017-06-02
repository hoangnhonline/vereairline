<?php
require_once "model/Backend.php";
$model = new Backend;
$arrList = $model->getListCity();
?>
<div class="row">
    <div class="col-md-12">
        <div id="breadcrumb">
            <ul>
                <li>Dashboard</li>
                <li class="arrow"><img src="img/arrow.png"></li>
                <li>
                    <a href="index.php?mod=city&act=list">Tỉnh/TP</a>
                </li>
            </ul>
        </div>        
        <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=city&act=form'">Tạo mới</button>        
        <div class="box-header">
            <h3 class="box-title">Danh sách Tỉnh/TP</h3>
        </div><!-- /.box-header -->
        
        <div class="box">          
            <div class="box-body">
                <table class="table table-bordered table-striped" id="tbl_list">
                    <thead>
                        <tr>
                            <th width="1%">STT</th>
                            <th width="1%" style="white-space:nowrap">Thứ tự</th>
                            <th width="50%">Tên</th>
                            <th width="20%">Quận/Huyện</th>
                            <th width="1%" style="white-space:nowrap">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $i = 0;

                        if(!empty($arrList)){                   

                        foreach($arrList as $city){

                        $i++;

                        ?>
                        <tr id="row-<?php echo $city['city_id']; ?>">
                            <td width="1%"><span class="order"><?php echo $i; ?></span></td>
                            <td width="1%"><img src="img/drag.png" class="dragHandle" /></td>
                            <td width="50%">
                                <a href="index.php?mod=city&act=form&id=<?php echo $city['city_id']; ?>">
                                    <?php echo $city['city_name']; ?>
                                </a>                               
                            </td>                            
                            <td>
                                <a href="index.php?mod=state&act=list&city_id=<?php echo $city['city_id']; ?>">
                                    SL : <?php echo $model->countStateByCity($city['city_id']); ?>
                                </a>
                            </td>
                            <td width="1%" style="white-space:nowrap">
                              
                                <a href="index.php?mod=city&act=form&id=<?php echo $city['city_id']; ?>" title="Click để chỉnh sửa">
                                    <i class="fa fa-fw fa-edit"></i>
                                </a>
                              
                                <a title="Click để xóa" href="javascript:;" alias="<?php echo $city['city_name']; ?>" id="<?php echo $city['city_id']; ?>" mod="city" class="link_delete" >    
                                    <i class="fa fa-fw fa-trash-o"></i>
                                </a>  
                              
                            </td>
                        </tr>  
                       <?php }} else{ ?>   
                        <tr>
                            <td colspan="8" class="error_data">Không tìm thấy dữ liệu!</td>
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
        $('#cate_type_id').change(function(){
            $('#form_search').submit();
        });
        $('#tbl_list tbody').sortable({
            handle: ".dragHandle",
            sort: function(e) {
              
            },
            axis: "y",
            update: function() {
                var rows = $('#tbl_list tbody tr');
                var strOrder = '';
                var strTemp = '';
                for (var i=0; i<rows.length; i++) {
                    strTemp = rows[i].id;
                    strOrder += strTemp.replace('row-','') + ";";
                }      

                $.ajax({
                    url: "ajax/process.php",
                    type: "POST",
                    async: false,
                    data: {
                        'action' : 'updateOrderCity',
                        'str_id_order' : strOrder
                    },
                    success: function(data){
                        var countRow = $('#tbl_list tbody span.order').length;
                        for(var i = 0 ; i < countRow ; i ++ ){
                            $('span.order').eq(i).html(i+1);
                        }                        
                    }
                }); 
            }
        });
    });
</script>