<?php 
$str_tag = "";
require_once "model/Backend.php";

    $model = new Backend;
$link = "index.php?mod=about&act=list";
$detail = array();
if(isset($_GET['id'])){

    $id = (int) $_GET['id'];

    

    $data = $model->getDetailAbout($id);         
} 
?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="static/js/ajaxupload.js"></script>
<div class="row">

<div class="col-md-12">   
    <?php if(isset($_GET['mess'])) echo "<h1 style='color:red'>".$_GET['mess']."</h1>";?> 
        <form method="post" action="controller/About.php">            

        <!-- Custom Tabs -->
        <div style="clear:both;margin-bottom:10px"></div>
        <div class="box box-primary">    
         <div class="box-header">

                <h3 class="box-title"><?php echo (isset($id) && $id> 0) ? "Cập nhật" : "Tạo mới" ?> about <?php echo (isset($id) && $id> 0) ? " : ".$data['article_title'] : ""; ?></h3>

                <?php if(isset($id) && $id> 0){ ?>

                <input type="hidden" value="<?php echo $id; ?>" name="id" />

                <?php } ?>

            </div><!-- /.box-header -->

        <div class="box-body">   
            <div class="col-md-12">
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

                                    <label>Ten block 1<span class="required"> ( * ) </span></label>

                                    <input type="text" name="name_1_vi" class="form-control required" value="<?php echo isset($data['name_1_vi'])  ? $data['name_1_vi'] : "" ?>">

                            </div> 
                            <div class="form-group">

                                <label>Noi dung block 1</label>                        

                                <textarea rows="10" class="form-control" name="content_1_vi"><?php if(isset($data['content_1_vi'])) echo $data['content_1_vi']; ?></textarea>

                            </div>   
                            <div class="form-group">

                                    <label>Ten block 2<span class="required"> ( * ) </span></label>

                                    <input type="text" name="name_2_vi" class="form-control required" value="<?php echo isset($data['name_2_vi'])  ? $data['name_2_vi'] : "" ?>">

                            </div> 
                            <div class="form-group">

                                <label>Noi dung block 2</label>                        

                                <textarea rows="10" class="form-control" name="content_2_vi"><?php if(isset($data['content_2_vi'])) echo $data['content_2_vi']; ?></textarea>

                            </div>               

                        </div> 
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">
                        <div class="col-md-6" style="margin-top:10px">
              
                             <div class="form-group">

                                    <label>Name block 1<span class="required"> ( * ) </span></label>

                                    <input type="text" name="name_1_en" class="form-control required" value="<?php echo isset($data['name_1_en'])  ? $data['name_1_en'] : "" ?>">

                            </div> 
                            <div class="form-group">

                                <label>Content block 1</label>                        

                                <textarea rows="10" class="form-control" name="content_1_en"><?php if(isset($data['content_1_en'])) echo $data['content_1_en']; ?></textarea>

                            </div>   
                            <div class="form-group">

                                    <label>Name block 2<span class="required"> ( * ) </span></label>

                                    <input type="text" name="name_2_en" class="form-control required" value="<?php echo isset($data['name_2_en'])  ? $data['name_2_en'] : "" ?>">

                            </div> 
                            <div class="form-group">

                                <label>Content block 2</label>                        

                                <textarea rows="10" class="form-control" name="content_2_en"><?php if(isset($data['content_2_en'])) echo $data['content_2_en']; ?></textarea>

                            </div>                    

                        </div>
                    </div>              
                  </div>

                </div>
            <div class="col-md-6">                
                       
                             

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