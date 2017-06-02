<?php
require_once "model/Backend.php";
$model = new Backend;

$link = "index.php?mod=age&act=list";

$arrList = $model->getListAgeRange();

?>
<div class="row">
    <div class="col-md-12">
        <?php if($model->checkprivilege(43)){ ?>
        <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=age&act=form'">Tạo mới</button>
        <?php } ?>
        <div class="box-header">
            <h3 class="box-title">Danh sách</h3>
        </div><!-- /.box-header -->
        <div class="box">
            <div class="box_search">               
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped" id="tbl_list">
                    <thead>
                        <tr>
                            <th width="1%">No.</th>
                            <th width="80%">Độ tuổi</th>                           
                            <th width="1%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $i = 0;

                        if(!empty($arrList)){                   

                        foreach($arrList as $range){

                        $i++;                                                
                        ?>
                        <tr id="row-<?php echo $range['id']; ?>">
                            <td style="width:1%"><span class="order"><?php echo $i; ?></span></td>                           
                            <td>
                                <a href="index.php?mod=age&act=form&id=<?php echo $range['id']; ?>">
                                    <?php echo $range['range']; ?>
                                </a>                               
                            </td>                                                               

                            <td style="white-space:nowrap">
                                <?php if($model->checkprivilege(44)){ ?>    
                                <a href="index.php?mod=age&act=form&id=<?php echo $range['id']; ?>">
                                    <i class="fa fa-fw fa-edit"></i>
                                </a>
                                <?php } ?>
                                <?php if($model->checkprivilege(45)){ ?>
                                <a href="javascript:;" alias="<?php echo $range['range']; ?>" id="<?php echo $range['id']; ?>" mod="range" class="link_delete" >    
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
        $('#is_hot,#cate_type_id').change(function(){
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
                        'action' : 'updateOrderrange',
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