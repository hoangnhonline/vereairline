<div class="row-fluid" id="article">
    <div class="col-md-8">
        <ol class="breadcrumb">
            <li><a href="<?php echo $baseUrl; ?>">Trang chủ</a></li>
            <li><a href="<?php echo $detailCate['cate_alias']; ?>.html"><?php echo $detailCate['cate_name']; ?></a></li>
            <li><?php echo $data['article_title']; ?></li>
        </ol>        
        <div class="ps-page-content">
            <h1 class="page-title" style="text-align:center"><?php echo $data['article_title']; ?></h1>
            <p><?php echo str_replace('../', '', $data['content']); ?></p>
        </div>
        
    </div>
    <?php include "blocks/cate/right.php"; ?>
</div> 