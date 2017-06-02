
<div class=" block-title">
    <a href="tin-du-lich.html" class="main-color">
        <img src="libs/images/h1.png" alt="tin tuc - su kien" style="margin-top: -2px">
        TIN TỨC - SỰ KIỆN
    </a>
</div>
<div class="stripe-line"></div>
<div class="block-article left-col">
    <?php 
    $arrList = $model->getListArticles(3, 0, 3);
    if(!empty($arrList['data'])){
        foreach ($arrList['data'] as $articles) {
            $img = is_file($articles['image_url']) ? $articles['image_url'] : 'images/no-images.jpg';
    ?>
    <div class="row">
        <div class="col-md-4">
            <a href="chi-tiet/<?php echo $articles['article_alias']; ?>.html">
                <img src="<?php echo $img; ?>" alt="<?php echo $articles['article_title']; ?>" title="<?php echo $articles['article_title']; ?>"/>
            </a>
        </div>
        <div class="col-md-8">
            <div class="article-title main-color">
                <a href="chi-tiet/<?php echo $articles['article_alias']; ?>.html">
                    <?php echo $articles['article_title']; ?>
                </a>
            </div>
            <div class="article-short"><?php echo $articles['description']; ?></div>
        </div>
    </div>
    <?php } } ?>
</div>