<?php 
$str_tag = "";
require_once "model/Backend.php";

    $model = new Backend;
$link = "index.php?mod=team&act=list";
$detail = array();
if(isset($_GET['id'])){

    $id = (int) $_GET['id'];    

    $data = $model->getDetailTeam($id);     
}
?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="static/js/ajaxupload.js"></script>
<div class="row">

<div class="col-md-12">
    <button class="btn btn-primary btn-sm" onclick="location.href='<?php echo $link; ?>'">List team</button>
        <form method="post" action="controller/Team.php">            

        <!-- Custom Tabs -->
        <div style="clear:both;margin-bottom:10px"></div>
        <div class="box box-primary">    
         <div class="box-header">

                <h3 class="box-title"><?php echo (isset($id) && $id> 0) ? "Cập nhật" : "Tạo mới" ?> team <?php echo (isset($id) && $id> 0) ? " : ".$data['article_title'] : ""; ?></h3>

                <?php if(isset($id) && $id> 0){ ?>

                <input type="hidden" value="<?php echo $id; ?>" name="id" />

                <?php } ?>

            </div><!-- /.box-header -->

        <div class="box-body">   
            <div class="col-md-12">
            <div class="col-md-6">
                <div role="tabpanel">

                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><img src="img/vi.png" /></a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><img src="img/en.png" /></a></li>                
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="col-md-6" style="margin-top:10px">
              
                           <div class="form-group">

                                <label>Ten<span class="required"> ( * ) </span></label>

                                <input type="text" name="name_vi" class="form-control required" value="<?php echo isset($data['name_vi'])  ? $data['name_vi'] : "" ?>">

                            </div> 
                            <div class="form-group">

                                    <label>Chuc danh<span class="required"> ( * ) </span></label>

                                    <input type="text" name="job_vi" class="form-control required" value="<?php echo isset($data['job_vi'])  ? $data['job_vi'] : "" ?>">

                            </div>              

                        </div> 
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">
                        <div class="col-md-6" style="margin-top:10px">
              
                            <div class="form-group">

                                <label>Name<span class="required"> ( * ) </span></label>

                                <input type="text" name="name_en" class="form-control required" value="<?php echo isset($data['name_en'])  ? $data['name_en'] : "" ?>">

                            </div> 
                            <div class="form-group">

                                    <label>Job<span class="required"> ( * ) </span></label>

                                    <input type="text" name="job_en" class="form-control required" value="<?php echo isset($data['job_en'])  ? $data['job_en'] : "" ?>">

                            </div>                   

                        </div>
                    </div>              
                  </div>

                </div>
                  <div style="clear:both"></div>
                <div class="form-group">

                        <label>Twitter<span class="required"> ( * ) </span></label>

                        <input type="text" name="twitter_url" class="form-control required" value="<?php echo isset($data['twitter_url'])  ? $data['twitter_url'] : "" ?>">

                </div>  
                <div class="form-group">

                        <label>Facebook<span class="required"> ( * ) </span></label>

                        <input type="text" name="fb_url" class="form-control required" value="<?php echo isset($data['fb_url'])  ? $data['fb_url'] : "" ?>">

                </div>  
                <div class="form-group">

                        <label>Display order<span class="required"> ( * ) </span></label>

                        <input type="text" name="display_order" class="form-control required" value="<?php echo isset($data['display_order'])  ? $data['display_order'] : "" ?>">

                </div>           
                       

            </div>                         
         
            </div>         
            <label>Ảnh đại diện<span class="required"> ( * ) </span></label>
                <input type="hidden" name="image_url" id="image_url" class="form-control" value="<?php if(!empty($data['image_url'])) echo "../".$data['image_url']; ?>" /><br />
                <?php if(!empty($data['image_url'])){ ?>
                <img src="../<?php echo $data['image_url']; ?>" height="120" />
                <?php }else{ ?>
                <img id="img_thumnails" src="static/img/no_image.jpg" width="120" />
                <?php } ?>
                <button class="btn btn-default" type="button" onclick="BrowseServer('Images:/','image_url')" >Upload</button>                                           

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