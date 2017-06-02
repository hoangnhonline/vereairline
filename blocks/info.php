 <div id="service">
    <div class="main-color block-title">
        <img src="libs/images/h1.png" alt="Christmas" style="margin-top: -3px">
        <?php echo $arrText[7]; ?>
    </div>
    <div class="stripe-line"></div>
    <div class="block-article left-col">
        <ul>
            <?php 
            $arr = $model->getListArticles(5, 0, 5);
            if(!empty($arr['data'])){
                foreach ($arr['data'] as $value) {                    
            ?>
            <li>
               <a href="chi-tiet/<?php echo $value['article_alias']; ?>.html">
                    <i class="fa fa-plane"></i>
                    <?php echo $value['article_title']; ?>
                </a>
            </li>                          
            <?php }} else{ ?>
            <li>                              
               <a title="Hệ thống đang cập nhật">Hệ thống đang cập nhật!</a>
            </li>
            <?php } ?>
        </ul>
        <?php if(!empty($arr['data'])){ ?>
        <hr>

        <div class="clearfix"></div>
        <div class="article-view">
            <i class="icon-view fa fa-angle-right"></i>
            <a href="thong-tin-can-biet.html">XEM TIẾP</a>
        </div>
        <?php } ?>
    </div>
</div>
<div id="service">
    <div class="main-color block-title">
        <img src="libs/images/h1.png" alt="Christmas" style="margin-top: -3px">
        <?php echo $arrText[12]; ?>
    </div>
    <div class="stripe-line"></div>
    <div class="block-article left-col">
        <ul>
            <?php 
            $arr = $model->getListArticles(6, 0, 5);
            if(!empty($arr['data'])){
                foreach ($arr['data'] as $value) {                    
            ?>
            <li>
               <a href="chi-tiet/<?php echo $value['article_alias']; ?>.html">
                    <i class="fa fa-plane"></i>
                    <?php echo $value['article_title']; ?>
                </a>
            </li>                          
            <?php }} else{ ?>
            <li>                              
               <a title="Hệ thống đang cập nhật">Hệ thống đang cập nhật!</a>
            </li>
            <?php } ?>
        </ul>
        <?php if(!empty($arr['data'])){ ?>
        <hr>

        <div class="clearfix"></div>
        <div class="article-view">
            <i class="icon-view fa fa-angle-right"></i>
            <a href="cau-hoi-thuong-gap.html">XEM TIẾP</a>
        </div>
        <?php } ?>
    </div>
</div>