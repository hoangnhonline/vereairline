<div class="col-md-6">
            <div class="contentbox">
    <!-- Place somewhere in the <body> of your page -->
    <div id="slider" class="flexslider">
        <?php $arr = $model->getListBannerByPosition(2,-1); ?>
            
        <ul class="slides">
            <?php
              if(!empty($arr)){           
                  foreach($arr as $img){                    
                    
              ?>
            <li>
                <img src="<?php echo $img['image_url']; ?>" alt="<?php echo $img['name_event']; ?>" title="<?php echo $img['name_event']; ?>"/>            	
            </li>
            <?php } } ?>
        </ul>
    </div>    
</div>        
</div>