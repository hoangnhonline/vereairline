<div class="row-fluid" id="article">
    <div class="col-md-8">
        <ol class="breadcrumb">
            <li><a href="<?php echo $baseUrl; ?>">Trang chủ</a></li>            
            <li><?php echo $data['page_name']; ?></li>
        </ol>        
        <div class="ps-page-content">
            <h1 class="page-title" style="text-align:center"><?php echo $data['page_name']; ?></h1>
            <p><?php echo str_replace('../', '', $data['content']); ?></p>
        </div>
        
    </div>
    <?php include "blocks/cate/right.php"; ?>
</div> 