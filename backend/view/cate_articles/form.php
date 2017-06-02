<?php 
require_once "model/Backend.php";
$model = new Backend;

$link = "index.php?mod=cate&act=list";
$detail = array();
if(isset($_GET['id'])){

    $id = (int) $_GET['id'];

    require_once "model/Backend.php";

    $model = new Backend;

    $data = $model->getDetailCateArticles($id);         
    
}
?>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=cate_articles&act=list'">Danh sách</button>
        <form method="post"  action="controller/CateArticles.php" enctype="multipart/form-data">

        <div class="col-md-6">

            <!-- Custom Tabs -->

            <div style="clear:both;margin-bottom:10px"></div>

            <div class="box-header">

                <h3 class="box-title"><?php echo (isset($id) && $id> 0) ? "Cập nhật" : "Tạo mới" ?> 
                    danh mục <?php echo (isset($id) && $id> 0) ? " : ".$data['cate_name'] : ""; ?></h3>

                <?php if(isset($id) && $id> 0){ ?>

                <input type="hidden" value="<?php echo $id; ?>" name="cate_id" />

                <?php } ?>

            </div><!-- /.box-header -->

            <div class="nav-tabs-custom">

                <div class="button">                    

                    <div class="row">
                            
                        <div class="col-md-12" >
                            <div class="form-group">
                                <label>Tên danh mục</label>
                                <input type="text" name="cate_name" id="cate_name" class="form-control" value="<?php if(!empty($data)) echo $data['cate_name']; ?>" />
                            </div> 
                            <!--<div class="form-group">
                                <label>Slug <span class="required"> ( * ) </span></label>-->
                                <input type="hidden" name="cate_alias" id="cate_alias" class="form-control" value="<?php if(!empty($data)) echo $data['cate_alias']; ?>" />
                            <!--</div>-->
                            
                            <div class="form-group">
                                <label>Ảnh đại diện</label>
                                <input type="radio" id="choose_img_sv" name="choose_img" value="1" checked="checked"/> Chọn ảnh từ server
                                &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="choose_img_cp" name="choose_img" value="2" /> Chọn ảnh từ máy tính
                                <div id="from_sv">
                                    <input type="hidden" name="image_url" id="image_url" class="form-control" value="<?php if(!empty($data['image_url'])) echo "../".$data['image_url']; ?>" /><br />
                                    <?php if(!empty($data['image_url'])){ ?>
                                    <img id="img_thumnails" src="../<?php echo $data['image_url']; ?>" height="200" />
                                    <?php }else{ ?>
                                    <img id="img_thumnails" src="static/img/no_image.jpg" width="200" />
                                    <?php } ?>
                                    <button class="btn btn-default" type="button" onclick="BrowseServer('Images:/','image_url')" >Upload</button>
                                </div>
                                <div id="from_cp" style="display:none;padding:15px;margin-bottom:10px">
                                    <input type="file" name="image_url_upload" />
                                </div>

                            </div>
                             <div class="form-group">
                                <label>Mô tả ngắn</span></label>
                                <textarea name="description" id="description" class="form-control" rows="3"><?php if(!empty($data)) echo $data['description']; ?></textarea>
                            </div>       
                            <input type="hidden" value="0" name="is_hot" id="is_hot" />   
                            <input type="hidden" value="0" name="hidden" id="hidden" />                
                            <!--<div class="form-group">                                
                                <input type="checkbox" name="is_hot" id="is_hot" value="1" <?php if(!empty($data['is_hot']) && $data['is_hot']==1) echo "checked"; ?> />
                                <label style="color:red">Danh mục nổi bật</label>
                            </div>
                            <div class="form-group">                                
                                <input type="checkbox" name="hidden" id="hidden" value="1" <?php if(!empty($data['hidden']) && $data['hidden']==1) echo "checked"; ?> />
                                <label style="color:red">Danh mục ẩn</label>
                            </div>-->
                        </div>                   
                    </div>               
                </div>
            </div><!-- nav-tabs-custom -->

        </div><!-- /.col -->

        <div class="col-md-6">

            <!-- Custom Tabs -->
            <div style="clear:both;margin-bottom:30px"></div>
            <div class="box-header">
                
            </div><!-- /.box-header -->
            <div class="nav-tabs-custom" style="margin-top:30px" >

                <div class="button">
                    <div class="col-md-12" >
                        <h4 class="box-title">SEO information</h4>
                        <div class="form-group">
                            <label>Title</label>
                            <textarea name="meta_title" id="meta_title" class="form-control" rows="2"><?php if(!empty($data)) echo $data['meta_title']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Meta description</label>
                            <textarea name="meta_description" id="meta_description" class="form-control" rows="2"><?php if(!empty($data)) echo $data['meta_description']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Meta keyword</label>
                            <textarea name="meta_keyword" id="meta_keyword" class="form-control" rows="2"><?php if(!empty($data)) echo $data['meta_keyword']; ?></textarea>
                        </div>
                        
                    </div>        
                </div>  
                <div style="clear:both"></div>
            </div><!-- nav-tabs-custom -->
        </div><!-- /.col -->

        <div class="col-md-12 nav-tabs-custom">
            <!--<div class="row">               
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Details</span></label>
                        <textarea name="content" id="content" class="form-control" rows="10"><?php if(!empty($data)) echo $data['content']; ?></textarea>
                    </div>
                </div>
            </div>
       
            <div class="form-group">
                <label>SEO TEXT</span></label>
                <textarea name="seo_text" id="seo_text" class="form-control" rows="5"><?php if(!empty($data)) echo $data['seo_text']; ?></textarea>
            </div>
             -->
            <div class="button">
                <button class="btn btn-primary btnSave" type="submit" >Save</button>
                <button class="btn btn-primary" type="button" onclick="location.href='index.php?mod=cate_articles&act=list'">Cancel</button>
            </div>

        </div>
        </form>
    </div>
</div>
<link href="static/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript">
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

$(function(){
     $('#cate_name').blur(function(){
        if($('#meta_title').val()==''){
            $('#meta_title').val($(this).val());
        }
        if($('#meta_keyword').val()==''){
            $('#meta_keyword').val($(this).val());
        }
        if($('#meta_description').val()==''){
            $('#meta_description').val($(this).val());
        }  
         if($('#cate_alias').val()==''){
            $.ajax({
                url: "ajax/Ajax.php",
                type: "POST",       
                data: {
                    'action' : 'ten-slug',
                    'name' : $('#cate_name').val()
                },
                success: function(data){                         
                    $('#cate_alias').val(data);
                }
            });
        }      
    });
    $('#choose_img_sv').click(function(){
        $('#from_sv').show();
        $('#from_cp').hide();
    });
    $('#choose_img_cp').click(function(){
        $('#from_cp').show();
        $('#from_sv').hide();
    }); 
    configEditor['height'] = '150px';
    var editor2 = CKEDITOR.replace( 'seo_text',configEditor); 
});
</script>