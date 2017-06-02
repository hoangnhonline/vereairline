<?php

require_once "model/Backend.php";

$model = new Backend;

$link = "index.php?mod=skills&act=list";


$arrList = $model->getListSkills();

?>



<div class="row">

    <div class="col-md-12">

    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=skills&act=form'">Add new</button>        

         <div class="box-header">

                <h3 class="box-title">Skills List</h3>

            </div><!-- /.box-header -->

        <div class="box">

            <div class="box_search">

                


            </div>

            <div class="box-body">

                <table class="table table-bordered table-striped">

                    <tbody><tr>

                        <th style="width: 10px">No.</th>

                        <th width="300">Name</th>

                        <th width="140">Point</th>                                                                         

                        <th style="width: 40px">Action</th>

                    </tr>

                    <?php

                    $i = ($page-1) * $limit; 

                    if(!empty($arrList)){                   

                    foreach($arrList as $row){

                    $i++;

                    ?>

                    <tr>

                        <td><?php echo $i; ?></td>

                        <td>

                            <a href="index.php?mod=skills&act=form&id=<?php echo $row['id']; ?>">

                                <?php echo $row['name_vi']; ?> 

                            </a>
                        </td>
                        <td><?php echo $row['point']; ?></td>                        
                                                                                 

                        <td style="white-space:nowrap">                            

                            <a href="index.php?mod=skills&act=form&id=<?php echo $row['id']; ?>">

                                <i class="fa fa-fw fa-edit"></i>

                            </a>

                            <a href="javascript:;" alias="<?php echo $row['name']; ?>" id="<?php echo $row['id']; ?>" mod="skills" class="link_delete" >    

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