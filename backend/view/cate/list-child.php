<?php
require_once "model/Backend.php";
$model = new Backend;

$link = "index.php?mod=cate&act=list-child";
if (isset($_GET['parent_id']) && $_GET['parent_id'] > -1) {
    $parent_id = (int) $_GET['parent_id'];      
    $link.="&parent_id=$parent_id";
    $detailParent = $model->getDetailCate($parent_id);
    $cate_type_id = $detailParent['cate_type_id'];
    $detailCateType = $model->getDetailCateType($cate_type_id);
    $cateParentArr = $model->getListCateParent($cate_type_id);    
} else {
    $parent_id = -1;
}
$arrList = $model->getListCateByParent($parent_id);

?>
<div class="row">
    <div class="col-md-12">
         <div id="breadcrumb">
            <ul>
                <li>Dashboard</li>
                <li class="arrow"><img src="img/arrow.png"></li>               
                <li>
                    <a href="index.php?mod=cate&act=list&cate_type_id=<?php echo $cate_type_id ; ?>"><?php echo $detailCateType['cate_type_name']; ?></a>
                </li>
                <li class="arrow"><img src="img/arrow.png"></li>
                <li>
                    <a href="index.php?mod=cate&act=list-child&parent_id=<?php echo $parent_id ; ?>"><?php echo $detailParent['cate_name']; ?></a>
                </li>
            </ul>
        </div>
        <?php if($model->checkprivilege(7)){ ?>
        <button class="btn btn-primary btn-sm right" 
         onclick="location.href='index.php?mod=cate&act=form-child&cate_type_id=<?php echo $cate_type_id; ?>&parent_id=<?php echo $parent_id; ?>'">
        Tạo mới
        </button>
        <?php } ?>
        <button class="btn btn-primary btn-sm right" 
         onclick="location.href='index.php?mod=cate&act=list&cate_type_id=<?php echo $cate_type_id; ?>&parent_id=<?php echo $parent_id; ?>'">
        Back
        </button>
        <div class="box-header">
            <h3 class="box-title">Danh sách danh mục</h3>
        </div><!-- /.box-header -->
        <div class="box">
            <div class="box_search">
                <form method="get" id="form_search" name="form_search">
                    <input type="hidden" name="mod" value="cate" />
                    <input type="hidden" name="act" value="list-child" />
                    Danh mục cha
                    <select name="parent_id" id="parent_id" style="width:200px !important;height:25px;">                      
                        <?php if(!empty($cateParentArr)){
                            foreach($cateParentArr as $cate){ ?>
                            <option value="<?php echo $cate['id']; ?>" <?php echo $parent_id==$cate['id'] ? "selected" : ""; ?>><?php echo $cate['cate_name'] ?></option>
                            <?php }
                        } ?>
                    </select>                    
                    &nbsp;&nbsp;&nbsp;
                    <button class="btn btn-primary btn-sm right" type="submit">Tìm kiếm</button>
                </form>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped" id="tbl_list">
                    <thead>
                        <tr>
                            <th width="1%">STT</th>
                            <th style="width:9%;text-align:center">Thứ tự</th>
                            <th width="35%">Tên danh mục</th>
                            <th style="width:15%;text-align:center">Hiện trên MENU</th>
                            <!--<th style="width:10%">Ảnh banner</th>-->
                            <th style="width:20%;text-align:center">Ngày tạo</th>
                            <th style="width:10%;text-align:center">Thao tác</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php

                        $i = 0;

                        if(!empty($arrList)){                   

                        foreach($arrList as $cate){

                        $i++;

                        ?>
                         <tr id="row-<?php echo $cate['id']; ?>">
                            <td width="1%"><span class="order"><?php echo $i; ?></span></td>
                            <td style="width:9%;text-align:center">
                            <?php if($model->checkprivilege(8)){ ?>
                            <img src="img/drag.png" class="dragHandle" />
                            <?php } ?>
                            </td>
                            <td width="35%">
                                <a href="index.php?mod=cate&act=form-child&id=<?php echo $cate['id']; ?>">
                                    <?php echo $cate['cate_name']; ?>
                                </a>
                               
                            </td>
                            <td style="width:15%;text-align:center">
                                <?php if($model->checkprivilege(8)){ ?>
                                <input type="checkbox" class="checkbox_ajax" data-type="is_hot" data-id="<?php echo $cate['id']; ?>" <?php if($cate['is_hot']==1) echo "checked"; ?>>
                                 
                                    <br />
                                <?php } ?>
                            </td>
                            <!--<td style="width:10%;text-align:center">
                                <?php $url_image = ($cate['image_url']) ? "../".$cate['image_url'] : STATIC_URL."img/no_image.jpg"; ?>
                                <img class="thumbnail" src="<?php echo $url_image; ?>" height="80" />
                            </td>-->

                            <td style="width:20%;text-align:center"><?php echo date('d-m-Y',$cate['created_at']); ?></td>                                             

                            <td style="width:10%;text-align:center">
                                <?php if($model->checkprivilege(8)){ ?>
                                <a href="index.php?mod=cate&act=form-child&id=<?php echo $cate['id']; ?>" title="Click để chỉnh sửa">
                                    <i class="fa fa-fw fa-edit"></i>
                                </a>
                                <?php } ?>
                                <?php if($model->checkprivilege(9)){ ?>
                                <a title="Click để xóa" href="javascript:;" alias="<?php echo $cate['cate_name']; ?>" id="<?php echo $cate['id']; ?>" mod="cate" class="link_delete" >    
                                    <i class="fa fa-fw fa-trash-o"></i>
                                </a>  
                                <?php } ?>
                            </td>
                        </tr>                         
                        <?php } }else{ ?>   
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
        $('#parent_id').change(function(){
            $('#form_search').submit();
        });
    });

$(function(){   
    $('.checkbox_ajax').click(function(){
        var obj = $(this);
        var cate_id = obj.attr('data-id');        
        var checked = obj.is(':checked');
        if(checked == true){            
            var val = 1;                
            var mes = "Bạn có chắc chắn BẬT tính năng này ?";
        }else{           
            var val = 0;           
            var mes = "Bạn có chắc chắn TẮT tính năng này ?";
        }
        if(confirm(mes)){
            $.ajax({
                url: "ajax/Ajax.php",
                type: "POST",
                async: true,
                data: {       
                    'action' : 'cate_menu' ,                     
                    'val' : val,                    
                    'cate_id' : cate_id
                },
                success: function(data){                                               
                   
                }
            });
        }else{
            $(this).prop('checked',false);
        }
    });   
    $('#tbl_list tbody').sortable({
            handle: ".dragHandle",
            sort: function(e) {
              $('#tbl_list tbody img.thumbnail').hide();
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
                        'action' : 'updateOrderCate',
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