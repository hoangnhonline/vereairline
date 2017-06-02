<?php
require_once "model/Backend.php";

$model = new Backend;

$link = "index.php?mod=articles&act=list";
$link_form='';
if (isset($_GET['cate_id']) && $_GET['cate_id'] > -1) {

    $cate_id = (int) $_GET['cate_id'];      

    $link.="&cate_id=$cate_id";
    $link_form.="&cate_id=$cate_id";
    
} else {

    $cate_id = -1;

}
if (isset($_GET['hidden']) && $_GET['hidden'] > -1) {

    $hidden = (int) $_GET['hidden'];      

    $link.="&hidden=$hidden";
    $link_form.="&hidden=$hidden";
    
} else {

    $hidden = -1;

}
if(isset($_GET['keyword'])){

    $keyword = $model->processData($_GET['keyword']);

    $link.='&keyword='.$keyword;
    $link_form.='&keyword='.$keyword;

}else{

    $keyword='';

}
if(isset($_GET['tungay'])){

    $tungay = $model->processData($_GET['tungay']);

    $link.='&tungay='.$tungay;
    $link_form.='&tungay='.$tungay;

}else{

    $tungay='';

}
if(isset($_GET['denngay'])){

    $denngay = $model->processData($_GET['denngay']);

    $link.='&denngay='.$denngay;
    $link_form.='&denngay='.$denngay;

}else{

    $denngay='';

}
$limit = 20;

$arrTotal = $model->getListArticle($keyword,$cate_id,$tungay,$denngay,$hidden,-1, -1);

$arrListCate = $model->getListCateArticles();

$total_page = ceil($arrTotal['total'] / $limit);



$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$link_form.='&page='.$page;


$offset = $limit * ($page - 1);



$arrList = $model->getListArticle($keyword,$cate_id,$tungay,$denngay,$hidden,$offset, $limit);

?>



<div class="row">

    <div class="col-md-12">
    <?php if($model->checkprivilege(39)){ ?>    
    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=articles&act=form<?php echo $link_form; ?>'">Tạo mới</button>        
    <?php } ?>
         <div class="box-header">

                <h3 class="box-title">Danh sách bài viết</h3>

            </div><!-- /.box-header -->

        <div class="box">

            <div class="box_search">                

                <form method="get" id="form_search" name="form_search">

                    <input type="hidden" name="mod" value="articles" />

                    <input type="hidden" name="act" value="list" />
                    Danh mục 
                    <select name="cate_id" id="cate_id" style="width:200px !important;height:25px;">
                    <option value="-1">Tất cả</option>
                     <?php foreach ($arrListCate as $cate){ ?>
                        <option value="<?php echo $cate['cate_id']; ?>" <?php echo $cate_id==$cate['cate_id'] ? "selected" : ""; ?>><?php echo $cate['cate_name']; ?></option>
                        <?php } ?>   
                   
                    </select>  
                    <!--&nbsp;&nbsp;&nbsp;Từ ngày      
                    <input type="text" class="text_search datetime" style="width:80px" name="tungay" value="<?php echo (trim($tungay)!='') ? date('d-m-Y',strtotime($tungay)) : ""; ?>" /> 
                    &nbsp;&nbsp;&nbsp;Đến ngày     
                    <input type="text" class="text_search datetime" style="width:80px" name="denngay" value="<?php echo (trim($denngay)!='') ? date('d-m-Y',strtotime($denngay)) : ""; ?>" /> 
                    -->
                    Tiêu đề &nbsp;<input type="text" class="text_search" name="keyword" value="<?php echo (trim($keyword)!='') ? $keyword: ""; ?>" />                                 
                    &nbsp;&nbsp;&nbsp;         
                    Trạng thái
                    <select name="hidden" id="hidden" style="width:80px !important;height:25px;">
                        <option value="-1">Tất cả</option>
                        <option value="1" <?php if($hidden==1) echo "selected"; ?>>Tắt</option>                        
                        <option value="0" <?php if($hidden==0) echo "selected"; ?>>Bật</option>                        
                    </select> 
                    <button class="btn btn-primary btn-sm right" type="submit">Tìm kiếm</button>

                </form>

            </div>

            <div class="box-body">

                <table class="table table-bordered table-striped" id="tbl_list">

                    <tbody><tr>

                        <th style="width: 10px">STT </th>

                        <th width="300">Tiêu đề</th>

                        <th width="140">Ảnh </th>
                        <th>Mô tả ngắn</th>

                        <th width="140">Ngày cập nhật</th>
                        <th width="140">Trạng thái</th> 
                        <th style="width: 40px;white-space:nowrap" >Thao tác</th>

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

                            <a href="index.php?mod=articles&act=form&article_id=<?php echo $row['article_id']; ?>">

                                <?php echo $row['article_title']; ?> 

                            </a>
                        </td>

                        <td>
                        <?php $url_image = ($row['image_url']) ? "../".$row['image_url'] :"static/img/no_image.jpg"; ?>
                        <img src="<?php echo $url_image; ?>" width="120" /></td>
                            
                        <td style="vertical-align:top"><?php echo $row['description']; ?></td>
                        <td><?php echo date('d-m-Y',$row['updated_at']); ?></td>                                             
                        <td style="text-align:center"><?php echo $row['hidden'] == 0 ? "<span style='color:blue'>Bật</span>" : "<span style='color:red'>Tắt</span>"; ?></td>
                        <td style="white-space:nowrap">                            
                        <?php if($model->checkprivilege(40)){ ?>
                            <a title="Click để chỉnh sửa" href="index.php?mod=articles&act=form&article_id=<?php echo $row['article_id']; ?><?php echo $link_form; ?>">

                                <i class="fa fa-fw fa-edit"></i>

                            </a>
                            <?php } ?>
                            <?php if($model->checkprivilege(41)){ ?>
                            <a title="Click để xóa" href="javascript:;" alias="<?php echo $row['article_title']; ?>" id="<?php echo $row['article_id']; ?>" mod="articles" class="link_delete" >    

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
         $('.datetime').datetimepicker({
            format:'d-m-Y',
            timepicker:false
        });
    });
</script>