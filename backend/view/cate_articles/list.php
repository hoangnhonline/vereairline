<?php
require_once "model/Backend.php";
$model = new Backend;

$arrList = $model->getListCateArticles();

?>
<div class="row">
    <div class="col-md-12">
        <?php if($model->checkprivilege(35)){ ?>
        <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=cate_articles&act=form'">Tạo mới</button>
        <?php } ?>
        <div class="box-header">
            <h3 class="box-title">Danh mục bài viết</h3>
        </div><!-- /.box-header -->
        <div class="box">           
            <div class="box-body">
                <table class="table table-bordered table-striped" id="tbl_list">
                    <thead>
                        <tr>
                            <th width="1%">STT </th>
                            <!--<th width="1%"  style="white-space:nowrap">Sắp xếp</th>-->
                            <th width="30%">Tên danh mục </th>
                           <!-- <th width="20%">Ảnh đại diện</th>-->     
                            <th width="1%" style="white-space:nowrap">SL bài viết </th> 
                            <!--<th width="1%"  style="white-space:nowrap">Trạng thái</th>-->
                            <th width="1%"  style="white-space:nowrap">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $i = 0;

                        if(!empty($arrList)){                   

                        foreach($arrList as $cate){

                        $i++;

                        ?>
                        <tr id="row-<?php echo $cate['cate_id']; ?>" >
                            <td width="1%"><span class="order"><?php echo $i; ?></span></td>
                            <!--<td style="width:1%"><img src="img/drag.png" class="dragHandle" /></td>-->
                            <td width="30%">
                                <a href="index.php?mod=cate_articles&act=form&id=<?php echo $cate['cate_id']; ?>">
                                    <?php echo $cate['cate_name']; ?>
                                </a>
                                <!--
                                <?php if($cate['is_hot']==1) { ?>
                                &nbsp;&nbsp;&nbsp;<img src="static/img/ok.gif" width="20" alt="Danh mục nổi bật " title="Danh mục nổi bật"/>
                                <?php } ?>-->
                            </td>
                            <!--<td>
                                <?php $url_image = ($cate['image_url']) ? "../".$cate['image_url'] : STATIC_URL."img/no_image.jpg"; ?>
                                <img src="<?php echo $url_image; ?>" width="80" />
                            </td>-->                            
                            <td style="width:1%;white-space:nowrap;text-align:center">
                                <a title="Click để xem bài viết" href="index.php?mod=articles&act=list&cate_id=<?php echo $cate['cate_id']; ?>" >
                                    <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
                                </a>
                                   <br /> <span style="color:red;font-weight:bold;font-size:18px"> 
                                    <?php echo $model->getNumberArticlesByCate($cate['cate_id']); ?> </span>
                            </td>
                            <!--<td style="text-align:center"><?php echo $cate['hidden'] == 0 ? "<span style='color:blue'>Bật</span>" : "<span style='color:red'>Tắt</span>"; ?></td>-->
                            <td style="white-space:nowrap;width:1%">
                                
                                <a title="Click để chỉnh sửa" href="index.php?mod=cate_articles&act=form&id=<?php echo $cate['cate_id']; ?>">
                                    <i class="fa fa-fw fa-edit"></i>
                                </a>
                                
                                <a title="Click để xóa" href="javascript:;" alias="<?php echo $cate['cate_name']; ?>" id="<?php echo $cate['cate_id']; ?>" mod="article_cate" class="link_delete" >    
                                    <i class="fa fa-fw fa-trash-o"></i>
                                </a>  
                                
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
        $('#cate_type_id').change(function(){
            $('#form_search').submit();
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
                        'action' : 'updateOrderCateArticles',
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
        });  
    });
</script>