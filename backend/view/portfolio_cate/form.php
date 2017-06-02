<?php 
require_once "model/Backend.php";
$model = new Backend;

$link = "index.php?mod=cate&act=list";
$detail = array();
if(isset($_GET['id'])){

    $id = (int) $_GET['id'];

    require_once "model/Backend.php";

    $model = new Backend;

    $data = $model->getDetailPortfolioCate($id);         
    
}
?>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=portfolio_cate&act=list'">List</button>
        <form method="post"  action="controller/PortfolioCate.php">

        <div class="col-md-6">

            <!-- Custom Tabs -->

            <div style="clear:both;margin-bottom:10px"></div>

            <div class="box-header">

                <h3 class="box-title"><?php echo (isset($id) && $id> 0) ? "Update" : "Create" ?> portfolio cate <?php echo (isset($id) && $id> 0) ? " : ".$data['article_title'] : ""; ?></h3>

                <?php if(isset($id) && $id> 0){ ?>

                <input type="hidden" value="<?php echo $id; ?>" name="cate_id" />

                <?php } ?>

            </div><!-- /.box-header -->

            <div class="nav-tabs-custom">

                <div class="button">                    

                    <div class="row">
                            
                        <div class="col-md-12" >
                            <div class="form-group">
                                <label>Name <img src="img/vi.png"></label>
                                <input type="text" name="cate_name_vi" id="cate_name_vi" class="form-control" value="<?php if(!empty($data)) echo $data['cate_name_vi']; ?>" />
                            </div>                                                    
                            <div class="form-group">
                                <label>Name <img src="img/en.png"></label>
                                <input type="text" name="cate_name_en" id="cate_name_en" class="form-control" value="<?php if(!empty($data)) echo $data['cate_name_en']; ?>" />
                            </div>  
                        </div>                   
                    </div>               
                </div>
            </div><!-- nav-tabs-custom -->

        </div><!-- /.col -->

       

        <div class="col-md-12 nav-tabs-custom">           

            <div class="button">
                <button class="btn btn-primary btnSave" type="submit" >Save</button>
                <button class="btn btn-primary" type="reset">Cancel</button>
            </div>

        </div>
        </form>
    </div>
</div>