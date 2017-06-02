<?php
require_once "model/Backend.php";

$model = new Backend;

$link = "index.php?mod=page&act=list";

$arrList = $model->getListPage(-1);

?>


<div class="row">

    <div class="col-md-12">
    <?php if($model->checkprivilege(31)){ ?>
    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=page&act=form'">Tạo mới</button>        
    <?php } ?>
         <div class="box-header">

                <h3 class="box-title">Danh sách trang</h3>

            </div><!-- /.box-header -->

        <div class="box">

            <div class="box_search">             

                

            </div>

            <div class="box-body">

                <table class="table table-bordered table-striped" id="tbl_list">

                    <tbody><tr>

                        <th style="width: 1%">STT </th>
                        <th width="300">Tên trang</th>
 <th width="200">Slug</th>
                        <th width="300">Đường dẫn</th> 
                        <th style="width: 40px">Thao tác</th>

                    </tr>

                    <?php

                    $i = 0; 

                    if(!empty($arrList)){                   

                    foreach($arrList as $row){

                    $i++;

                    ?>

                    <tr>

                        <td><?php echo $i; ?></td>

                        <td>
                            <a href="index.php?mod=page&act=form&id=<?php echo $row['id']; ?>">

                                <?php echo $row['page_name']; ?> 

                            </a>
                        </td>
                         <td><?php echo $row['page_alias']; ?> </td>
                        <td><b><?php echo $row['page_alias'];?>.html</b></td>
                        <td style="white-space:nowrap">                            
                        <?php if($model->checkprivilege(32)){ ?>
                            <a href="index.php?mod=page&act=form&id=<?php echo $row['id']; ?>" title="Click để chỉnh sửa">

                                <i class="fa fa-fw fa-edit"></i>

                            </a>
                            <?php } ?>
                        <?php if($model->checkprivilege(33)){ ?>
                            <a title="Click để xóa" href="javascript:;" alias="<?php echo $row['page_name']; ?>" id="<?php echo $row['id']; ?>" mod="page" class="link_delete" >    

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

                </tbody></table>

            </div><!-- /.box-body -->

            <div class="box-footer clearfix">
              
            </div>

        </div><!-- /.box -->                           

    </div><!-- /.col -->

   

</div>