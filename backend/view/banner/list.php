<?php
require_once "model/Backend.php";
$model = new Backend;
$link = "index.php?mod=banner&act=list";
$position_id = (int) $_GET['position_id'];
$arrList = $model->getListBannerByPosition($position_id);
?>
<div class="row">
    <div class="col-md-12">
        <div id="breadcrumb">
            <ul>
                <li>Dashboard</li>
                <li class="arrow"><img src="img/arrow.png"></li>
                <li>
                    <a href="index.php?mod=banner&act=index">Banner</a>
                </li>
                <li class="arrow"><img src="img/arrow.png"></li>
                <li>
                    <a href="index.php?mod=cate&act=list&position_id=<?php echo $position_id ; ?>"> vị trí <?php echo $position_id; ?></a>
                </li>
            </ul>
        </div>        
        <button class="btn btn-primary btn-sm right" 
        onclick="location.href='index.php?mod=banner&act=form&position_id=<?php echo $position_id; ?>'">
        Tạo mới</button>        
        <button class="btn btn-primary btn-sm right" 
        onclick="location.href='index.php?mod=banner&act=index'">
        Back</button>
        <div class="box-header">
            <h3 class="box-title">Danh sách banner :: vị trí <?php echo $position_id; ?></h3>
        </div><!-- /.box-header -->
        <div class="box">
            
            <div class="box-body">
                <table class="table table-bordered table-striped" id="tbl_list" style="width:700px !important;">
                    <thead>
                        <tr>
                            <th width="1%">STT</th>
                            <th width="1%" style="white-space:nowrap">Tên sự kiện/ Banner</th>                               
                            <th width="20%">Ảnh banner</th>                                                          
                            <th width="1%" style="white-space:nowrap">Thao tác</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php

                        $i = 0;

                        if(!empty($arrList)){                   

                        foreach($arrList as $value){

                        $i++;

                        ?>
                         <tr id="row-<?php echo $value['id']; ?>">
                           <td width="1%"><?php echo $i; ?></th>
                            <td width="1%" style="white-space:nowrap"><?php echo $value['name_event']; ?></td>
                           
                            <td width="20%">
                                <img src="../<?php echo $value['image_url'];?>" width="300" />
                            </td>                               
                           
                            <td width="1%" style="white-space:nowrap;text-align:center">

                                <a href="index.php?mod=banner&act=form&id=<?php echo $value['id']; ?>&position_id=<?php echo $position_id?>" title="Click để chỉnh sửa">
                                    <i class="fa fa-fw fa-edit"></i>
                                </a>
                                
                                <a title="Click để xóa" href="javascript:;" alias="<?php echo $value['name_event']; ?>" id="<?php echo $value['id']; ?>" mod="banner" class="link_delete" >    
                                    <i class="fa fa-fw fa-trash-o"></i>
                                </a>  
                                
                            </td>
                        </tr>                         
                        <?php } }else{ ?>   
                        <tr>
                            <td colspan="9" class="error_data">Không tìm thấy dữ liệu!</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix"></div>

        </div><!-- /.box -->                           

    </div><!-- /.col -->
</div>