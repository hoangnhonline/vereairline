<?php
require_once "model/Backend.php";
$model = new Backend;
$city_id = isset($_GET['city_id'])  ? (int) $_GET['city_id'] : 1;
$arrListCity = $model->getListCity();
$cityDetail = $model->getDetailCity($city_id);
$arrList = $model->getListStateByCity($city_id);
?>
<div class="row">
    <div class="col-md-12">
        <div id="breadcrumb">
            <ul>
                <li>Dashboard</li>
                <li class="arrow"><img src="img/arrow.png"></li>
                <li>
                    <a href="index.php?mod=state&act=list">Quận/Huyện</a>
                </li>
            </ul>
        </div>        
        <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=state&act=form&city_id=<?php echo $city_id; ?>'">Tạo mới</button>        
        <div class="box-header">
            <h3 class="box-title">Danh sách quận/huyện thuộc tỉnh/tp : <?php echo $cityDetail['city_name']; ?></h3>
        </div><!-- /.box-header -->
        <div class="box" style="text-align:right">
            <div class="box_search">
                <label for="city_id">Tỉnh/TP</label>
                <select name="city_id" id="city_id" style="width:200px !important;height:25px;">
                    <option value="0">--select--</option>
                    <?php foreach ($arrListCity as $key => $value) {
                    ?>
                    <option <?php if($city_id == $value['city_id']) echo "selected"; ?> value="<?php echo $value['city_id']; ?>"><?php echo $value['city_name']; ?></option>
                    <?php } ?>
                </select>
                <div style="clear:both"></div>
            </div>
        </div>
        <div class="box">          
            <div class="box-body">
                <table class="table table-bordered table-striped" id="tbl_list">
                    <thead>
                        <tr>
                            <th width="1%">STT</th>
                            <th width="1%" style="white-space:nowrap">Thứ tự</th>
                            <th width="50%">Tên</th>                            
                            <th width="1%" style="white-space:nowrap">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $i = 0;

                        if(!empty($arrList)){                   

                        foreach($arrList as $state){

                        $i++;

                        ?>
                        <tr id="row-<?php echo $state['id']; ?>">
                            <td width="1%"><span class="order"><?php echo $i; ?></span></td>
                            <td width="1%"><img src="img/drag.png" class="dragHandle" /></td>
                            <td width="50%">
                                <a href="index.php?mod=state&act=form&id=<?php echo $state['id']; ?>&city_id=<?php echo $state['city_id']; ?>">
                                    <?php echo $state['state_name']; ?>
                                </a>                               
                            </td>                                                        
                            <td width="1%" style="white-space:nowrap">
                              
                                <a href="index.php?mod=state&act=form&id=<?php echo $state['id']; ?>&city_id=<?php echo $state['city_id']; ?>" title="Click để chỉnh sửa">
                                    <i class="fa fa-fw fa-edit"></i>
                                </a>
                              
                                <a title="Click để xóa" href="javascript:;" alias="<?php echo $state['state_name']; ?>" id="<?php echo $state['id']; ?>" mod="state" class="link_delete" >    
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

        $('#city_id').change(function(){
            location.href="index.php?mod=state&act=list&city_id=" + $(this).val();
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