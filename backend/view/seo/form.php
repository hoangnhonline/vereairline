<?php 
require_once "model/Backend.php";
$model = new Backend;

$link = "index.php?mod=cate&act=list";
$detail = array();
if(isset($_GET['id'])){

    $id = (int) $_GET['id'];

    require_once "model/Backend.php";

    $model = new Backend;

    $data = $model->getDetailSeo($id);         
    
}
?>
<div class="row">
    <div class="col-md-12" >
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=seo&act=list'">SEO List</button>
        <form method="post"  action="controller/Seo.php" enctype="multipart/form-data">

        <div class="col-md-10" style="background-color:#FFF">

            <!-- Custom Tabs -->

            <div style="clear:both;margin-bottom:10px"></div>

            <div class="box-header">

                <h3 class="box-title"><?php echo (isset($id) && $id> 0) ? "Update SEO info " : "Tạo mới" ?>                      
                    <?php echo (isset($id) && $id> 0) ? " : ".$data['page_name'] : ""; ?></h3>

                <?php if(isset($id) && $id> 0){ ?>

                <input type="hidden" value="<?php echo $id; ?>" name="id" />

                <?php } ?>

            </div><!-- /.box-header -->

            <div class="">

                <div class="button">                    

                    <div class="row">
                            
                        <div class="col-md-12" >
                            <div class="form-group">
                                <label>Page name</label>
                                <input type="text" readonly="readonly" name="page_name" id="page_name" class="form-control" value="<?php if(!empty($data)) echo $data['page_name']; ?>" />
                            </div>                          
                           
                        </div>                   
                        <div style="margin-top:30px" >

                <div class="button">
                    <div class="col-md-12" >
                        <h4 class="box-title">SEO information</h4>
                        <div class="form-group">
                            <label>Title</label>
                            <textarea name="meta_title" id="meta_title" class="form-control" rows="3"><?php if(!empty($data)) echo $data['meta_title']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Meta description</label>
                            <textarea name="meta_description" id="meta_description" class="form-control" rows="3"><?php if(!empty($data)) echo $data['meta_description']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Meta keyword</label>
                            <textarea name="meta_keyword" id="meta_keyword" class="form-control" rows="3"><?php if(!empty($data)) echo $data['meta_keyword']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>SEO Text</label>
                            <textarea name="seo_text" id="seo_text" class="form-control" rows="3"><?php if(!empty($data['seo_text'])) echo $data['seo_text']; ?></textarea>
                        </div>
                    </div>        
                </div>  
                <div style="clear:both"></div>
            </div><!-- nav-tabs-custom -->
                    </div>               
                </div>
            </div><!-- nav-tabs-custom -->

        </div><!-- /.col -->
       
        <div class="col-md-6">

            <!-- Custom Tabs -->
            <div style="clear:both;margin-bottom:30px"></div>
            <div class="box-header">
                
            </div><!-- /.box-header -->
            
        </div><!-- /.col -->

        <div class="col-md-12 nav-tabs-custom">          

            <div class="button">
                <button class="btn btn-primary btnSave" type="submit" >Save</button>
                <button class="btn btn-primary" type="button" onclick="location.href='index.php?mod=seo&act=list'">Cancel</button>
            </div>

        </div>
        </form>
    </div>
</div>
<script src="static/js/form.js" type="text/javascript"></script>
<div id="div_upload" style="display:none">
    <div id="loading" style="display:none"><img src="img/loading.gif" width="470" /></div>
    <form id="upload_images" method="post" enctype="multipart/form-data" enctype="multipart/form-data" action="ajax.php">
        <div style="margin: auto;">
            <!---<img src="img/add.jpg" id="add_images" width="32" align="right" />           -->
            <div class="clear"></div>
            <div id="wrapper_input_files">
                <input type="file" name="images[]" /><br />
                <input type="file" name="images[]" /><br />
                <input type="file" name="images[]" /><br />
                <input type="file" name="images[]" /><br />
                <input type="file" name="images[]" /><br />
            </div>           
            <button style="margin-top: 10px;" class="btn btn-primary" type="submit" id="btn_upload_images">
                Upload
            </button>
        </div>

    </form>
</div>
<div style="display: none" id="box_uploadimages">
    <div class="upload_wrapper block_auto">
        <div class="note" style="text-align:center;">Nhấn <strong>Ctrl</strong> để chọn nhiều hình.</div>
        <form id="upload_files_new" method="post" enctype="multipart/form-data" enctype="multipart/form-data" action="ajax/upload.php">
            <fieldset style="width: 100%; margin-bottom: 10px; height: 47px; padding: 5px;">
                <legend><b>&nbsp;&nbsp;Chọn hình từ máy tính&nbsp;&nbsp;</b></legend>
                <input style="border-radius:2px;" type="file" id="myfile" name="myfile[]" multiple />
                <div class="clear"></div>
                <div class="progress_upload" style="text-align: center;border: 1px solid;border-radius: 3px;position: relative;display: none;">
                    <div class="bar_upload" style="background-color: grey;border-radius: 1px;height: 13px;width: 0%;"></div >
                    <div class="percent_upload" style="color: #FFFFFF;left: 140px;position: absolute;top: 1px;">0%</div >
                </div>
            </fieldset>
        </form>
    </div>
</div>
<link href="static/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="static/js/ajaxupload.js"></script>
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
<script type="text/javascript">
$(function(){
     $('#page_name').blur(function(){
        if($('#meta_title').val()==''){
            $('#meta_title').val($(this).val());
        }
        if($('#meta_keyword').val()==''){
            $('#meta_keyword').val($(this).val());
        }
        if($('#meta_description').val()==''){
            $('#meta_description').val($(this).val());
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
});
configEditor['height'] = '200px';
var editor = CKEDITOR.replace('seo_text',configEditor);     
</script>