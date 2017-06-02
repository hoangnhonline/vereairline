<?php
require_once "model/Backend.php";
$model = new Backend;

$arrList = $model->getListPortfolioCate();

?>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=portfolio_cate&act=form'">Add new</button>
        <div class="box-header">
            <h3 class="box-title">Portfolio cate</h3>
        </div><!-- /.box-header -->
        <div class="box">           
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th width="1%">No.</th>
                            <th width="30%">Name</th>
                           <!-- <th width="20%">Ảnh đại diện</th>-->                                                        
                            <th width="1%">Action</th>
                        </tr>
                        <?php

                        $i = 0;

                        if(!empty($arrList)){                   

                        foreach($arrList as $cate){

                        $i++;

                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <a href="index.php?mod=portfolio_cate&act=form&id=<?php echo $cate['id']; ?>">
                                    <?php echo $cate['cate_name_vi']; ?>
                                </a>
                                <?php if($cate['is_hot']==1) { ?>
                                &nbsp;&nbsp;&nbsp;<img src="static/img/ok.gif" width="20" alt="Danh mục nổi bật " title="Danh mục nổi bật"/>
                                <?php } ?>
                            </td>
                            <!--<td>
                                <?php $url_image = ($cate['image_url']) ? "../".$cate['image_url'] : STATIC_URL."img/no_image.jpg"; ?>
                                <img src="<?php echo $url_image; ?>" width="80" />
                            </td>-->                            
                          

                            <td style="white-space:nowrap">
                                <a href="index.php?mod=portfolio_cate&act=form&id=<?php echo $cate['id']; ?>">
                                    <i class="fa fa-fw fa-edit"></i>
                                </a>
                                <a href="javascript:;" alias="<?php echo $cate['cate_name']; ?>" id="<?php echo $cate['id']; ?>" mod="portfolio_cate" class="link_delete" >    
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
    });
</script>