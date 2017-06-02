 <div class="row-fluid" id="canbiet" style="margin-top:20px">
    <div class="col-md-12">
        <div class="main-color block-title">
            <img src="libs/images/ic4.png" alt="Christmas" style="margin-top: -3px">
            <?php echo $arrText[8]; ?></div><div class="stripe-line"></div>
        <div class=" block-article">
            <div class="row">
                                <div class="col-md-6">
                    <div  class="link-title"><a href="ve-may-bay-quoc-te.html"><?php echo $arrText[9]; ?></a></div>
                    <div class="row-fluid">
                        <ul class="col-md-12">
                            <?php 
                            $arr = $model->getListArticles(2, 0, 8);
                            if(!empty($arr['data'])){
                                foreach ($arr['data'] as $value) {                    
                            ?>
                            <li>
                               <a href="chi-tiet/<?php echo $value['article_alias']; ?>.html">                                    
                                    <?php echo $value['article_title']; ?>
                                </a>
                            </li>                          
                            <?php }} else{ ?>
                            <li>                              
                               <a title="Hệ thống đang cập nhật">Hệ thống đang cập nhật!</a>
                            </li>
                            <?php } ?>

                        </ul>                       
                    </div>
                </div>
                <div class="col-md-6">
                    <div  class="link-title"><a href="ve-may-bay-noi-dia.html"><?php echo $arrText[10]; ?></a></div>
                    <div class="row-fluid">
                        <ul class="col-md-12">
                            <?php 
                            $arr = $model->getListArticles(1, 0, 8);
                            if(!empty($arr['data'])){
                                foreach ($arr['data'] as $value) {                    
                            ?>
                            <li>
                               <a href="chi-tiet/<?php echo $value['article_alias']; ?>.html">                                    
                                    <?php echo $value['article_title']; ?>
                                </a>
                            </li>                          
                            <?php }} else{ ?>
                            <li>                              
                               <a title="Hệ thống đang cập nhật">Hệ thống đang cập nhật!</a>
                            </li>
                            <?php } ?>

                        </ul>                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  