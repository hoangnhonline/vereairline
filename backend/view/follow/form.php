<?php 
$str_tag = "";
require_once "model/Backend.php";

    $model = new Backend;
$link = "index.php?mod=follow&act=list";
$detail = array();
if(isset($_GET['id'])){

    $id = (int) $_GET['id'];    

    $data = $model->getDetailFollow($id);     
}
?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="static/js/ajaxupload.js"></script>
<div class="row">

<div class="col-md-12">
    <button class="btn btn-primary btn-sm" onclick="location.href='<?php echo $link; ?>'">List follow</button>
        <form method="post" action="controller/Follow.php">            

        <!-- Custom Tabs -->
        <div style="clear:both;margin-bottom:10px"></div>
        <div class="box box-primary">    
         <div class="box-header">

                <h3 class="box-title"><?php echo (isset($id) && $id> 0) ? "Cập nhật" : "Tạo mới" ?> follow <?php echo (isset($id) && $id> 0) ? " : ".$data['article_title'] : ""; ?></h3>

                <?php if(isset($id) && $id> 0){ ?>

                <input type="hidden" value="<?php echo $id; ?>" name="id" />

                <?php } ?>

            </div><!-- /.box-header -->

        <div class="box-body">   
            <div class="col-md-12">
            <div class="col-md-6">
                
                <div class="form-group">

                        <label>Name<span class="required"> ( * ) </span></label>

                        <input type="text" name="name" class="form-control required" value="<?php echo isset($data['name'])  ? $data['name'] : "" ?>">

                </div> 
                <div class="form-group">

                        <label>Link <span class="required"> ( * ) </span></label>

                        <input type="text" name="link_url" class="form-control required" value="<?php echo isset($data['link_url'])  ? $data['link_url'] : "" ?>">

                </div>   
                      
                       

            </div>                         
         
            </div>                  
            <div class="button">

                <button class="btn btn-primary btnSave" type="submit">Save</button>

                <button class="btn btn-primary" type="reset">Cancel</button>

            </div>
        </div><!-- nav-tabs-custom -->
        </div>
    </form>

    </div><!-- /.col --> 

</div>

<link href="<?php echo STATIC_URL; ?>css/jquery-ui.css" rel="stylesheet" type="text/css" />
<script src="js/form.js" type="text/javascript"></script>
<script type="text/javascript" src="ckfinder/ckfinder.js"></script>


<script type="text/javascript">
  
    
function split(val) {
    return val.split(/;\s*/);
}

function extractLast(term) {
    return split(term).pop();
}
function BrowseServer( startupPath, functionData ){    
    var finder = new CKFinder();
    finder.basePath = 'ckfinder/'; //Đường path nơi đặt ckfinder
    finder.startupPath = startupPath; //Đường path hiện sẵn cho user chọn file
    finder.selectActionFunction = SetFileField; // hàm sẽ được gọi khi 1 file được chọn
    finder.selectActionData = functionData; //id của text field cần hiện địa chỉ hình
    //finder.selectThumbnailActionFunction = ShowThumbnails; //hàm sẽ được gọi khi 1 file thumnail được chọn    
    finder.popup(); // Bật cửa sổ CKFinder
} //BrowseServer

function SetFileField( fileUrl, data ){
    document.getElementById( data["selectActionData"] ).value = fileUrl;
    $('#hinh_dai_dien').attr('src','../' + fileUrl).show();
}
</script>