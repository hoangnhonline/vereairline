<?php
require_once "model/Backend.php";
$model = new Backend;
$arrList = $model->getListCateType();
?>
<div class="row">
    <div class="col-md-12">
        <div id="breadcrumb">
            <ul>
                <li>Dashboard</li>
                <li class="arrow"><img src="img/arrow.png"></li>
                <li>
                    <a href="index.php?mod=catetype&act=list">Menu danh mục</a>
                </li>
            </ul>
        </div>
        <?php if($model->checkprivilege(10)){ ?>
        <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=catetype&act=form'">Tạo mới</button>
        <?php } ?>
        <div class="box-header">
            <h3 class="box-title">Danh sách menu danh mục</h3>
        </div><!-- /.box-header -->
        
        <div class="box">          
            <div class="box-body">
                <table class="table table-bordered table-striped" id="tbl_list">
                    <thead>
                        <tr>
                            <th width="1%">STT</th>
                            <th width="1%" style="white-space:nowrap">Thứ tự</th>
                            <th width="50%">Tên</th>
                            <th width="30%">Ảnh đại diện</th>                            
                            <th width="17%">Danh mục con</th>
                            <th width="17%">Ngày tạo</th>
                            <th width="1%" style="white-space:nowrap">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $i = 0;

                        if(!empty($arrList)){                   

                        foreach($arrList as $catetype){

                        $i++;

                        ?>
                        <tr id="row-<?php echo $catetype['id']; ?>">
                            <td width="1%"><span class="order"><?php echo $i; ?></span></td>
                            <td width="1%"><img src="img/drag.png" class="dragHandle" /></td>
                            <td width="50%">
                                <a href="index.php?mod=catetype&act=form&id=<?php echo $catetype['id']; ?>">
                                    <?php echo $catetype['cate_type_name']; ?>
                                </a>                               
                            </td>
                            <td width="30%">
                                <?php $url_image = ($catetype['image_url']) ? "../".$catetype['image_url'] : STATIC_URL."img/no_image.jpg"; ?>
                                <img class="thumbnail" src="<?php echo $url_image; ?>" height="80" />
                            </td>      
                            <td width="17%" style="white-space:nowrap;text-align:center">
                                <a href="index.php?mod=cate&act=list&cate_type_id=<?php echo $catetype['id']; ?>" title="Click để xem danh mục con">
                                    <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
                                </a><br />
                                Số lượng : 
                                <span style="color:red;font-weight:bold;font-size:18px"> <?php echo $model->getNumberParentCate($catetype['id']); ?></span>
                            </td>                                                  
                            <td width="17%" style="white-space:nowrap"><?php echo date('d-m-Y',$catetype['created_at']); ?></td>                                             

                            <td width="1%" style="white-space:nowrap">
                                <?php if($model->checkprivilege(3)){ ?>
                                <a href="index.php?mod=catetype&act=form&id=<?php echo $catetype['id']; ?>" title="Click để chỉnh sửa">
                                    <i class="fa fa-fw fa-edit"></i>
                                </a>
                                <?php } ?>
                                <?php if($model->checkprivilege(4)){ ?>
                                <a title="Click để xóa" href="javascript:;" alias="<?php echo $catetype['cate_type_name']; ?>" id="<?php echo $catetype['id']; ?>" mod="catetype" class="link_delete" >    
                                    <i class="fa fa-fw fa-trash-o"></i>
                                </a>  
                                <?php } ?>
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
                        'action' : 'updateOrderCateType',
                        'str_id_order' : strOrder
                    },
                    success: function(data){
                        var countRow = $('#tbl_list tbody span.order').length;
                        for(var i = 0 ; i < countRow ; i ++ ){
                            $('span.order').eq(i).html(i+1);
                        }
                        $('#tbl_list tbody img.thumbnail').show();        
                    }
                }); 
            }
        }).disableSelection();
    });
</script>