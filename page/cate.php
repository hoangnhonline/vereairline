<?php
$cate_id = (int) $cate_id == 0 ? 1 : $cate_id;
$detailCate  = $model->getDetailCateArticles($cate_id);
$page_show = 5;
$arrTotal = $model->getListArticles($cate_id, -1, -1);
$limit = 20;
$page = 1;
$page = (isset($_GET['trang'])) ? (int) $_GET['trang'] : 1;
$total_page = ceil($arrTotal['total'] / $limit);
$offset = $limit * ($page - 1);
$arrList = $model->getListArticles($cate_id, $offset, $limit);
$link = 'danh-muc/'.$detailCate['cate_alias']."-".$detailCate['cate_id'].".html";
?>		
 <div class="row-fluid" id="article">
    <div class="col-md-8">
        <ol class="breadcrumb">
            <li><a href="<?php echo $baseUrl; ?>">Trang chủ</a></li>
            <li><a href="<?php echo $detailCate['cate_alias']; ?>.html"><?php echo $detailCate['cate_name']; ?></a></li>
        </ol>

        <div class="ps-page-header">
            <div class="main-color block-title">
               <?php echo $detailCate['cate_name']; ?>           </div>
            <div class="stripe-line"></div>
            <a class="rss" href="#"><i class="fa fa-rss"></i></a>
        </div>
        <div class="ps-page-content">
        	<?php if(!empty($arrList['data'])){ 
        		foreach ($arrList['data'] as $key => $value) {
        	?>
            <div class="row-fluid post-content">
                <div class="post-title">
                	<a href="chi-tiet/<?php echo $value['article_alias']; ?>.html">
                		<h1><?php echo $value['article_title']; ?></h1>
                	</a>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="post-img">
                        	<img  src="<?php echo str_replace('../','',$value['image_url']); ?>" class="img-thumbnail" alt="<?php echo $value['article_title']; ?>" title="<?php echo $value['article_title']; ?>"/>
                        </div>
                    </div>
                    <div class="col-md-9"><div class="post-date"><?php echo date('d-m-Y H:i', $value['created_at']); ?></div>
                        <div class="post-description">
                        	<?php echo $value['description']; ?>
                        </div>                        
                    </div>
                </div>
            </div>
            <div class="row"><hr></div>
            <?php }} ?>
                       
                        
        </div>
        <div class="ps-page-footer">      </div>        
    </div>
<?php include "blocks/cate/right.php"; ?>
</div>
