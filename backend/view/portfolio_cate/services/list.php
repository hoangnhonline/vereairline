<?php

require_once "model/Backend.php";

$model = new Backend;

$link = "index.php?mod=services&act=list";

if (isset($_GET['cate_id']) && $_GET['cate_id'] > -1) {

    $cate_id = (int) $_GET['cate_id'];      

    $link.="&cate_id=$cate_id";

} else {

    $cate_id = -1;

}

$limit = 20;

$arrTotal = $model->getListServices($cate_id,-1, -1);


$total_page = ceil($arrTotal['total'] / $limit);



$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;



$offset = $limit * ($page - 1);



$arrList = $model->getListServices($cate_id,$offset, $limit);

?>



<div class="row">

    <div class="col-md-12">

    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=services&act=form'">Add new</button>        

         <div class="box-header">

                <h3 class="box-title">Services List</h3>

            </div><!-- /.box-header -->

        <div class="box">

            <div class="box_search">

                

                <form method="get" id="form_search" name="form_search">

                    <input type="hidden" name="mod" value="services" />

                    <input type="hidden" name="act" value="list" />

                    Category
                    <select name="cate_id" id="cate_id" style="width:200px !important;height:25px;">
                        <option value="-1">Tất cả</option>
                        <option value="1" <?php echo $cate_id==1 ? "selected" : ""; ?>>Services</option>
                        <option value="2" <?php echo $cate_id==2 ? "selected" : ""; ?>>Featured</option>                    
                   
                    </select>                    
                    &nbsp;&nbsp;&nbsp;

                    <button class="btn btn-primary btn-sm right" type="submit">Tìm kiếm</button>

                </form>

            </div>

            <div class="box-body">

                <table class="table table-bordered table-striped">

                    <tbody><tr>

                        <th style="width: 10px">No.</th>

                        <th width="300">Name</th>

                        <th width="140">Image</th>
                        <th>Description</th>                                                             

                        <th style="width: 40px">Action</th>

                    </tr>

                    <?php

                    $i = ($page-1) * $limit; 

                    if(!empty($arrList['data'])){                   

                    foreach($arrList['data'] as $row){

                    $i++;

                    ?>

                    <tr>

                        <td><?php echo $i; ?></td>

                        <td>

                            <a href="index.php?mod=services&act=form&id=<?php echo $row['id']; ?>">

                                <?php echo $row['name_vi']; ?> 

                            </a>
                        </td>

                        <td>
                        <?php $url_image = ($row['image_url']) ? "../".$row['image_url'] : STATIC_URL."img/noimage.gif"; ?>
                        <img src="<?php echo $url_image; ?>" width="120" /></td>
                            
                        <td style="vertical-align:top"><?php echo $row['description_vi']; ?></td>                                                                

                        <td style="white-space:nowrap">                            

                            <a href="index.php?mod=services&act=form&id=<?php echo $row['id']; ?>">

                                <i class="fa fa-fw fa-edit"></i>

                            </a>

                            <a href="javascript:;" alias="<?php echo $row['article_title']; ?>" id="<?php echo $row['id']; ?>" mod="services" class="link_delete" >    

                                <i class="fa fa-fw fa-trash-o"></i>

                            </a>    

                            

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

                <!--

                <ul class="pagination pagination-sm no-margin pull-right">

                    <li><a href="#">«</a></li>

                    <li><a href="#">1</a></li>

                    <li><a href="#">2</a></li>

                    <li><a href="#">3</a></li>

                    <li><a href="#">»</a></li>

                </ul>-->

                <?php echo $model->phantrang($page, PAGE_SHOW, $total_page, $link); ?>

            </div>

        </div><!-- /.box -->                           

    </div><!-- /.col -->

   

</div>
<script type="text/javascript">
    $(function(){
        $('#cate_id').change(function(){
            $('#form_search').submit();
        });
    });
</script>