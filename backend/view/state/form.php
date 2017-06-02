<?php 
require_once "model/Backend.php";
$model = new Backend;
$city_id =  isset($_GET['city_id']) ? (int) $_GET['city_id']: 1;
$link = "index.php?mod=state&act=list&city_id=".$city_id;
$data = array();
if(isset($_GET['id'])){

    $id = (int) $_GET['id'];

    require_once "model/Backend.php";

    $model = new Backend;

    $data = $model->getDetailState($id);           
}
$arrListCity = $model->getListCity();
?>
<div class="row">
    <div class="col-md-12">
        <div id="breadcrumb">
            <ul>
                <li>Dashboard</li>
                <li class="arrow"><img src="img/arrow.png"></li>
                <li>
                    <a href="index.php?mod=state&act=list">Quận/Huyện</a>
                </li>
            </ul>
        </div>     
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=state&act=list&city_id=<?php echo $city_id; ?>'">Back</button>
        <form method="post"  action="controller/State.php">

        <div class="col-md-6">

            <!-- Custom Tabs -->

            <div style="clear:both;margin-bottom:10px"></div>

            <div class="box-header">

                <h3 class="box-title"><?php echo (isset($id) && $id> 0) ? "Cập nhật" : "Tạo mới" ?> <?php echo (isset($id) && $id> 0) ? " : ".$data['state_name'] : ""; ?></h3>

                <?php if(isset($id) && $id> 0){ ?>

                <input type="hidden" value="<?php echo $id; ?>" name="state_id" />

                <?php } ?>

            </div><!-- /.box-header -->

            <div class="nav-tabs-custom">

                <div class="button">                    

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="city_id"> Tỉnh/TP</label>
                                <select name="city_id" id="city_id" class="form-control">
                                    <option value="0">--select--</option>
                                    <?php foreach ($arrListCity as $key => $value) {
                                    ?>
                                    <option <?php if($data['city_id'] == $value['city_id'] || $city_id == $value['city_id']) echo "selected"; ?> value="<?php echo $value['city_id']; ?>"><?php echo $value['city_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" >
                            <div class="form-group">
                                <label>Tên</label>
                                <input type="text" name="state_name" id="state_name" class="form-control" value="<?php if(!empty($data)) echo $data['state_name']; ?>" />
                            </div>                                                       
                            
                        </div>                   
                    </div>               
                </div>
            </div><!-- nav-tabs-custom -->

        </div><!-- /.col -->


        <div class="col-md-12 nav-tabs-custom">         

            <div class="button">
                <button class="btn btn-primary btnSave" type="submit" onclick="return validates()" >Save</button>
                <button class="btn btn-primary" type="reset">Cancel</button>
            </div>

        </div>
        </form>
    </div>
</div>
<script type="text/javascript">
function validates(){
    var flag = true;
    if($('#city_id').val()==0){
        alert('Vui lòng chọn Tỉnh/TP!');
        flag = false;
        return false;
    }
    if($('#state_name').val()==''){
        alert('Vui lòng nhập tên quận/huyện!');
        $('#state_name').focus();
        flag = false;
    }
    return flag;
}
</script>