<?php
require_once "model/Backend.php";
$model = new Backend;
$cateTypeArr = $model->getListCateType();
$link = "index.php?mod=manu&act=list";
if (isset($_GET['is_hot']) && $_GET['is_hot'] > -1) {
    $is_hot = (int) $_GET['is_hot'];      
    $link.="&is_hot=$is_hot";
} else {
    $is_hot = -1;
}
if (isset($_GET['hidden']) && $_GET['hidden'] > -1) {
    $hidden = (int) $_GET['hidden'];      
    $link.="&hidden=$hidden";
} else {
    $hidden = -1;
}
if (isset($_GET['manu_name']) && $_GET['manu_name'] > -1) {
    $manu_name = $_GET['manu_name'];      
    $link.="&manu_name=$manu_name";
} else {
    $manu_name = '';
}
$arrTotal = $model->getListManu($is_hot,$hidden,$manu_name,-1,-1);
$limit = 20;
$total_page = ceil($arrTotal['total'] / $limit);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$offset = $limit * ($page - 1);

$arrList = $model->getListManu($is_hot,$hidden,$manu_name,$offset,$limit);

?>
<div class="row">
    <div class="col-md-12">
        <?php if($model->checkprivilege(20)){ ?>
        <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=manu&act=form'">Tạo mới</button><?php } ?>
        <div class="box-header">
            <h3 class="box-title">Danh sách thương hiệu</h3>
        </div><!-- /.box-header -->
        <div class="box">
            <div class="box_search">
                <form method="get" id="form_search" name="form_search">
                    <input type="hidden" name="mod" value="manu" />
                    <input type="hidden" name="act" value="list" />
                    Tên thương hiệu
                    <input type="text" name="manu_name" value="<?php if(isset($_GET['manu_name'])) echo $_GET['manu_name']; ?>" id="manu_name" />                 
                    &nbsp;&nbsp;&nbsp;
                    Nổi bật
                    <select name="is_hot" id="is_hot" style="width:200px !important;height:25px;">
                        <option value="-1">Tất cả</option>
                        <option value="0" <?php if($is_hot==0) echo "selected"; ?>>Không</option>
                        <option value="1" <?php if($is_hot==1) echo "selected"; ?>>Có</option>
                        
                    </select> 
                    &nbsp;&nbsp;&nbsp;
                    Trạng thái
                    <select name="hidden" id="hidden" style="width:200px !important;height:25px;">
                        <option value="-1">Tất cả</option>
                        <option value="1" <?php if($hidden==1) echo "selected"; ?>>Tắt</option>
                        <option value="0" <?php if($hidden==0) echo "selected"; ?>>Bật</option>
                        
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
                            <!--<th width="1%">Sắp xếp</th>-->
                            <th width="30%">Thương hiệu</th>
                            <th width="15%">Menu danh mục</th>
                            <th width="15%">Ảnh</th>                            
                            <th width="15%" style="text-align:center">Nổi bật</th>
                            <th width="15%" style="text-align:center">Trạng thái</th>
                            <th width="8%">Ngày tạo</th>
                            <th width="1%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $i = ($page-1)*$limit;

                        if(!empty($arrList['data'])){                   

                        foreach($arrList['data'] as $manu){

                        $i++;                                                
                        ?>
                        <tr id="row-<?php echo $manu['id']; ?>">
                            <td style="width:1%"><span class="order"><?php echo $i; ?></span></td>
                            <!--<td style="width:1%"><img src="img/drag.png" class="dragHandle" /></td>-->
                            <td>
                                <a href="index.php?mod=manu&act=form&id=<?php echo $manu['id']; ?>">
                                    <?php echo $manu['manu_name']; ?>
                                </a>
                                <?php if($manu['is_hot']==1) { ?>
                                &nbsp;&nbsp;&nbsp;<img src="static/img/ok.gif" width="20" alt="Danh mục nổi bật " title="Danh mục nổi bật"/>
                                <?php } ?>
                            </td>
                            <td>
                                <?php 
                                $arrCate = $model->getListDetailCateTypeManu($manu['id']);
                                if(!empty($arrCate)){
                                ?>
                                <ul>
                                    <?php foreach ($arrCate as $value) { ?>                                        
                                    <li><?php echo $value[0]['cate_type_name']; ?></li>    
                                    <?php
                                    } ?>
                                    
                                </ul>
                                <?php } ?>
                            </td>
                            <td>
                                <?php $url_image = ($manu['image_url']) ? "../".$manu['image_url'] : STATIC_URL."img/no_image.jpg"; ?>
                                <img class="thumbnail" src="<?php echo $url_image; ?>" height="50" />
                            </td>                            
                            <td style="vertical-align:top;text-align:center">
                                <?php echo ($manu['is_hot']==1) ? "<span style='color:red'>Có</span>" : "Không"; ?>                             
                            </td>
                            <td style="vertical-align:top;text-align:center">
                                <?php echo ($manu['hidden']==1) ? "<span style='color:red'>Tắt</span>" : "<span style='color:blue'>Bật</span>"; ?>                             
                            </td>
                            <td style="white-space:nowrap"><?php echo date('d-m-Y',$manu['created_at']); ?></td>                                             

                            <td style="white-space:nowrap">
                            <?php if($model->checkprivilege(21)){ ?>
                                <a href="index.php?mod=manu&act=form&id=<?php echo $manu['id']; ?>" title="Click để chỉnh sửa">
                                    <i class="fa fa-fw fa-edit"></i>
                                </a><?php } ?>
                                <?php if($model->checkprivilege(22)){ ?>
                                <a title="Click để xóa" href="javascript:;" alias="<?php echo $manu['manu_name']; ?>" id="<?php echo $manu['id']; ?>" mod="manu" class="link_delete" >    
                                    <i class="fa fa-fw fa-trash-o"></i>
                                </a> <?php } ?> 
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
            <div class="box-footer clearfix">               
                <?php echo $model->phantrang($page, PAGE_SHOW, $total_page, $link); ?>
            </div>

        </div><!-- /.box -->                           

    </div><!-- /.col -->
</div>
<script type="text/javascript">
    $(function(){
        $('#is_hot,#hidden,#cate_type_id').change(function(){
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
                        'action' : 'updateOrderManu',
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