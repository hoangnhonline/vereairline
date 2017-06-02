<div class="row-fluid article-list" style="margin-bottom:20px">
    <?php $arr = $model->getListBannerByPosition(3,1); ?>
    <?php
      if(!empty($arr)){           
          foreach($arr as $img){                    
            
     ?>
            <img src="<?php echo $img['image_url']; ?>" alt="<?php echo $img['name_event']; ?>" title="<?php echo $img['name_event']; ?>" style="width:100%"/>
    <?php } } ?>
    
</div> 