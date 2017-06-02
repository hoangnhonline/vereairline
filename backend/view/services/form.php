<?php 
$str_tag = "";
require_once "model/Backend.php";

    $model = new Backend;
$link = "index.php?mod=services&act=list";
$detail = array();
if(isset($_GET['id'])){

    $id = (int) $_GET['id'];   

    $data = $model->getDetailServices($id);         

   
    $link.="&cate_id=".$data['cate_id'];
}
?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="static/js/ajaxupload.js"></script>
<div class="row">

<div class="col-md-12">
    <button class="btn btn-primary btn-sm" onclick="location.href='<?php echo $link; ?>'">List services</button>
        <form method="post" action="controller/Services.php">            

        <!-- Custom Tabs -->
        <div style="clear:both;margin-bottom:10px"></div>
        <div class="box box-primary">    
         <div class="box-header">

                <h3 class="box-title"><?php echo (isset($id) && $id> 0) ? "Cập nhật" : "Tạo mới" ?> services <?php echo (isset($id) && $id> 0) ? " : ".$data['article_title'] : ""; ?></h3>

                <?php if(isset($id) && $id> 0){ ?>

                <input type="hidden" value="<?php echo $id; ?>" name="id" />

                <?php } ?>

            </div><!-- /.box-header -->

        <div class="box-body">   
            <div class="col-md-12">
                 <div class="col-md-6">
                <div class="form-group">

                        <label>Category <span class="required"> ( * ) </span></label>

                        <select name="cate_id" id="cate_id" class="form-control">
                        <option>Chọn</option>
                        <option value="1" <?php echo !empty($data) && $data['cate_id']==1 ? "selected" : ""; ?>>Services</option>
                        <option value="2" <?php echo !empty($data) && $data['cate_id']==2 ? "selected" : ""; ?>>Featured</option>                                        
                            
                        </select>

                </div>

            </div>
            <div style="clear:both"></div>
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

                                    <label>Name<img src="img/vi.png"><span class="required"> ( * ) </span></label>

                                    <input type="text" name="name_vi" class="form-control required" value="<?php echo isset($data['name_vi'])  ? $data['name_vi'] : "" ?>">

                            </div> 
                            <div class="form-group">

                                    <label>Description<span class="required"> ( * ) </span></label>

                                    <input type="text" name="description_vi" class="form-control required" value="<?php echo isset($data['description_vi'])  ? $data['description_vi'] : "" ?>">

                            </div>   
                                 
                            <div class="form-group">

                                <label>Content</label>                        

                                <textarea rows="10" class="form-control" name="content_vi"><?php if(isset($data['content_vi'])) echo $data['content_vi']; ?></textarea>

                            </div>  
                                            

                        </div> 
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">
                        <div class="col-md-6" style="margin-top:10px">
                            <div class="form-group">

                                    <label>Name <img src="img/en.png"><span class="required"> ( * ) </span></label>

                                    <input type="text" name="name_en" class="form-control required" value="<?php echo isset($data['name_en'])  ? $data['name_en'] : "" ?>">

                            </div> 
                            <div class="form-group">

                                    <label>Description<span class="required"> ( * ) </span></label>

                                    <input type="text" name="description_en" class="form-control required" value="<?php echo isset($data['description_en'])  ? $data['description_en'] : "" ?>">

                            </div>   
                                 
                            <div class="form-group">

                                <label>Content</label>                        

                                <textarea rows="10" class="form-control" name="content_en"><?php if(isset($data['content_en'])) echo $data['content_en']; ?></textarea>

                            </div> 
                                       

                        </div>
                    </div>              
                  </div>

                </div>
         
            </div>         
            <label>Ảnh đại diện<span class="required"> ( * ) </span></label>
                <input type="hidden" name="image_url" id="image_url" class="form-control" value="<?php if(!empty($data['image_url'])) echo "../".$data['image_url']; ?>" /><br />
                <?php if(!empty($data['image_url'])){ ?>
                <img src="../<?php echo $data['image_url']; ?>" height="120" id="img_thumnails"/>
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
    $('#img_thumnails').attr('src',fileUrl).show();
}
</script>