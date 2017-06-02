<?php 
$str_tag = "";
require_once "model/Backend.php";

    $model = new Backend;
$link = "index.php?mod=portfolio&act=list";
$detail = array();
if(isset($_GET['id'])){

    $id = (int) $_GET['id'];

    

    $data = $model->getDetailPortfolio($id);         

   
    $link.="&cate_id=".$data['cate_id'];
}
 $arrListCate = $model->getListPortfolioCate();
?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="static/js/ajaxupload.js"></script>
<div class="row">

<div class="col-md-12">
    <button class="btn btn-primary btn-sm" onclick="location.href='<?php echo $link; ?>'">List portfolio</button>
        <form method="post" action="controller/Portfolio.php">            

        <!-- Custom Tabs -->
        <div style="clear:both;margin-bottom:10px"></div>
        <div class="box box-primary">    
         <div class="box-header">

                <h3 class="box-title"><?php echo (isset($id) && $id> 0) ? "Cập nhật" : "Tạo mới" ?> portfolio <?php echo (isset($id) && $id> 0) ? " : ".$data['article_title'] : ""; ?></h3>

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
                        <?php foreach ($arrListCate as $cate){ ?>
                        <option value="<?php echo $cate['id']; ?>" <?php echo !empty($data) && $data['cate_id']==$cate['id'] ? "selected" : ""; ?>><?php echo $cate['cate_name_vi']; ?></option>
                        <?php } ?>                      
                            
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

                                    <label>Ten du an<span class="required"> ( * ) </span></label>

                                    <input type="text" name="portfolio_name_vi" class="form-control required" value="<?php echo isset($data['portfolio_name_vi'])  ? $data['portfolio_name_vi'] : "" ?>">

                            </div> 
                            <div class="form-group">

                                    <label>Ten khach hang<span class="required"> ( * ) </span></label>

                                    <input type="text" name="client_vi" class="form-control required" value="<?php echo isset($data['client_vi'])  ? $data['client_vi'] : "" ?>">

                            </div> 
                            <div class="form-group">

                                    <label>Text hien thi Link<span class="required"> ( * ) </span></label>

                                    <input type="text" name="text_link_vi" class="form-control required" value="<?php echo isset($data['text_link_vi'])  ? $data['text_link_vi'] : "" ?>">

                            </div>     
                                    
                            <div class="form-group">

                                <label>Mo ta du an</label>                        

                                <textarea rows="10" class="form-control" name="description_vi"><?php if(isset($data['description_vi'])) echo $data['description_vi']; ?></textarea>

                            </div>                

                        </div> 
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">
                        <div class="col-md-6" style="margin-top:10px">
              
                            <div class="form-group">

                                    <label>Name<span class="required"> ( * ) </span></label>

                                    <input type="text" name="portfolio_name_en" class="form-control required" value="<?php echo isset($data['portfolio_name_en'])  ? $data['portfolio_name_en'] : "" ?>">

                            </div> 
                            <div class="form-group">

                                    <label>Client<span class="required"> ( * ) </span></label>

                                    <input type="text" name="client_en" class="form-control required" value="<?php echo isset($data['client_en'])  ? $data['client_en'] : "" ?>">

                            </div> 
                            <div class="form-group">

                                    <label>Text link<span class="required"> ( * ) </span></label>

                                    <input type="text" name="text_link_en" class="form-control required" value="<?php echo isset($data['text_link_en'])  ? $data['text_link_en'] : "" ?>">

                            </div>     
                                    
                            <div class="form-group">

                                <label>Description</label>                        

                                <textarea rows="10" class="form-control" name="description_en"><?php if(isset($data['description_en'])) echo $data['description_en']; ?></textarea>

                            </div>                

                        </div>
                    </div>              
                  </div>

                </div>
                                    
         
            </div>
          
            <div class="form-group">

                    <label>Link<span class="required"> ( * ) </span></label>

                    <input type="text" name="link_url" class="form-control required" value="<?php echo isset($data['link_url'])  ? $data['link_url'] : "" ?>">

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