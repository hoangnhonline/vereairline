<?php 
require_once "model/Backend.php";
$model = new Backend;

$link = "index.php?mod=age&act=list";
$data = array();
if(isset($_GET['id'])){

    $id = (int) $_GET['id'];

    require_once "model/Backend.php";

    $model = new Backend;

    $data = $model->getDetailAgeRange($id);           
}
?>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=age&act=list'">Danh sách</button>
        <form method="post"  action="controller/Age.php">

        <div class="col-md-6">

            <!-- Custom Tabs -->

            <div style="clear:both;margin-bottom:10px"></div>

            <div class="box-header">

                <h3 class="box-title"><?php echo (isset($id) && $id> 0) ? "Cập nhật" : "Tạo mới" ?> <?php echo (isset($id) && $id> 0) ? " : ".$data['range'] : ""; ?></h3>

                <?php if(isset($id) && $id> 0){ ?>

                <input type="hidden" value="<?php echo $id; ?>" name="id" />

                <?php } ?>

            </div><!-- /.box-header -->

            <div class="nav-tabs-custom">

                <div class="button">                    

                    <div class="row">
                            
                        <div class="col-md-12" >
                            <div class="form-group">
                                <label>Độ tuổi</label>
                                <input type="text" name="range" id="range" class="form-control" value="<?php if(!empty($data)) echo $data['range']; ?>" />
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