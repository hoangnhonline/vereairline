<?php

require_once "model/Promotion.php";

$model = new Promotion;

$link = "index.php?mod=promotion&act=list";

if (isset($_GET['hot']) && $_GET['hot'] > -1) {

    $hot = (int) $_GET['hot'];      

    $link.="&hot=$hot";

} else {

    $hot = -1;

}

if(isset($_GET['keyword'])){

    $keyword = $model->processData($_GET['keyword']);

    $link.='&keyword='.$keyword;

}else{

    $keyword='';

}

$limit = 20;

$arrTotal = $model->getListPromotion($keyword,$hot, -1, -1);



$total_page = ceil($arrTotal['total'] / $limit);



$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;



$offset = $limit * ($page - 1);



$arrList = $model->getListPromotion($keyword,$hot,$offset, $limit);

?>



<div class="row">

    <div class="col-md-12">

    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=promotion&act=form'">Tạo mới</button>        

         <div class="box-header">

                <h3 class="box-title">Danh sách khuyến mãi</h3>

            </div><!-- /.box-header -->

        <div class="box">

            <div class="box_search">

                

                <form method="get" id="form_search" name="form_search">

                    <input type="hidden" name="mod" value="promotion" />

                    <input type="hidden" name="act" value="list" />

                    Tiêu đề &nbsp;<input type="text" class="text_search" name="keyword" value="<?php echo (trim($keyword)!='') ? $keyword: ""; ?>" /> 

                   
                    &nbsp;&nbsp;&nbsp;Loại 

                    <select name="hot" class="event_change select_search">

                        <option value="-1">Tất cả</option>  

                        <option value="0" <?php echo ($hot==0) ? "selected" : ""; ?>>Bình thường</option>   

                        <option value="1" <?php echo ($hot==1) ? "selected" : ""; ?>>Tin Hot</option>        

                    </select>

                    &nbsp;&nbsp;&nbsp;

                    <button class="btn btn-primary btn-sm right" type="submit">Tìm kiếm</button>

                </form>

            </div>

            <div class="box-body">

                <table class="table table-bordered table-striped">

                    <tbody><tr>

                        <th style="width: 10px">No.</th>

                        <th width="300">Tiêu đề</th>

                        <th width="140">Ảnh đại diện</th>
                        <th>Mô tả ngắn</th>

                        <th width="140">Ngày tạo</th>                                               

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

                            <a href="index.php?mod=promotion&act=form&promotion_id=<?php echo $row['promotion_id']; ?>">

                                <?php echo $row['title_vi']; ?> 

                            </a>

                            <?php if($row['hot']==1) { ?>

                            &nbsp;&nbsp;&nbsp;<img src="static/img/ok.gif" width="20" alt="Tin hot" title="Tin hot"/>

                            <?php } ?>

                        </td>

                        <td>
                        <?php $url_image = ($row['image_url']) ? "../".str_replace("images","_thumbs/Images", $row['image_url']) : STATIC_URL."img/noimage.gif"; ?>
                        <img src="<?php echo $url_image; ?>" width="120" /></td>
                            
                        <td style="vertical-align:top"><?php echo $row['description_vi']; ?></td>
                        <td><?php echo date('d-m-Y',$row['creation_time']); ?></td>                                             

                        <td style="white-space:nowrap">                            

                            <a href="index.php?mod=promotion&act=form&promotion_id=<?php echo $row['promotion_id']; ?>">

                                <i class="fa fa-fw fa-edit"></i>

                            </a>

                            <a href="javascript:;" alias="<?php echo $row['title']; ?>" id="<?php echo $row['promotion_id']; ?>" mod="promotion" class="link_delete" >    

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