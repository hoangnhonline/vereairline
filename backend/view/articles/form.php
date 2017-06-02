<?php 
$str_tag = "";
$link = "index.php?mod=articles&act=list";
$link_form = "";
$detail = array();
require_once "model/Backend.php";

$model = new Backend;
if(isset($_GET['article_id'])){

    $article_id = (int) $_GET['article_id'];


    $detail = $model->getDetailArticle($article_id);    
    $data = $detail['data'];
    $arrTag = $model->getTagsOfProductId($article_id);   
    if(!empty($arrTag)){
        
        foreach($arrTag as $tag_id){
            $rs_tag = $model->getDetailTag($tag_id);
            $row_tag = mysql_fetch_assoc($rs_tag);
            $str_tag.=$row_tag["tag_name"]."; ";
        }   
    }

   
    $link.="&cate_id=".$data['cate_id'];
}
 $arrListCate = $model->getListCateArticles();

if (isset($_GET['cate_id']) && $_GET['cate_id'] > -1) {

    $cate_id = (int) $_GET['cate_id'];      

    $link.="&cate_id=$cate_id";
    $link_form.="&cate_id=$cate_id";
    
} else {

    $cate_id = -1;

}
if(isset($_GET['keyword'])){

    $keyword = $model->processData($_GET['keyword']);

    $link.='&keyword='.$keyword;
    $link_form.='&keyword='.$keyword;

}else{

    $keyword='';

}
if(isset($_GET['tungay'])){

    $tungay = $model->processData($_GET['tungay']);

    $link.='&tungay='.$tungay;
    $link_form.='&tungay='.$tungay;

}else{

    $tungay='';

}
if(isset($_GET['denngay'])){

    $denngay = $model->processData($_GET['denngay']);

    $link.='&denngay='.$denngay;
    $link_form.='&denngay='.$denngay;

}else{

    $denngay='';

}
if (isset($_GET['hidden']) && $_GET['hidden'] > -1) {

    $hidden = (int) $_GET['hidden'];      

    $link.="&hidden=$hidden";
    $link_form.="&hidden=$hidden";
    
} else {

    $hidden = -1;

}
?>

<div class="row">

<div class="col-md-12">
    <button class="btn btn-primary btn-sm" onclick="location.href='<?php echo $link; ?><?php echo $link_form; ?>'">Back</button>
        <form method="post" action="controller/Articles.php" enctype="multipart/form-data">            

        <!-- Custom Tabs -->
        <div style="clear:both;margin-bottom:10px"></div>
        <div class="box box-primary">    
         <div class="box-header">

                <h3 class="box-title"><?php echo (isset($article_id) && $article_id> 0) ? "Cập nhật" : "Tạo mới" ?> bài viết <?php echo (isset($article_id) && $article_id> 0) ? " : ".$data['article_title'] : ""; ?></h3>

                <?php if(isset($article_id) && $article_id> 0){ ?>

                <input type="hidden" value="<?php echo $article_id; ?>" name="article_id" />

                <?php } ?>
                <input type="hidden" name="back_url" value="<?php echo $link_form;?>"/>
            </div><!-- /.box-header -->

        <div class="box-body">   
            <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">

                        <label>Danh mục <span class="required"> ( * ) </span></label>

                        <select name="cate_id" id="cate_id" class="form-control">                        
                        <?php foreach ($arrListCate as $cate){ ?>
                        <option value="<?php echo $cate['cate_id']; ?>" <?php echo ((!empty($detail) && $data['cate_id']==$cate['cate_id']) || ($_GET['cate_id'] > 0 && empty($detail) && $_GET['cate_id'] == $cate['cate_id'])) ? "selected" : ""; ?>><?php echo $cate['cate_name']; ?></option>
                        <?php } ?>                      
                            
                        </select>

                </div>
                <input type="hidden" name="title_en" id="title_en" class="form-control required" value="<?php echo isset($data['title_en'])  ? $data['title_en'] : "" ?>">                
                <div class="form-group">

                        <label>Tiêu đề <span class="required"> ( * ) </span></label>

                        <input type="text" name="article_title" class="form-control required" id="article_title" value="<?php echo isset($data['article_title'])  ? $data['article_title'] : "" ?>">

                </div>  
                <div class="form-group">

                        <label>Slug<span class="required"> ( * ) </span></label>

                        <input type="text" name="article_alias" id="article_alias" class="form-control required" value="<?php echo isset($data['article_alias'])  ? $data['article_alias'] : "" ?>">

                </div>
                <!--<div class="form-group">

                        <label>Tiêu đề KD<span class="required"> ( * ) </span></label>

                        <input type="text" name="title_en" id="title_en" class="form-control required" value="<?php echo isset($data['title_en'])  ? $data['title_en'] : "" ?>">

                </div>
                
                <div class="form-group">

                    <label>Tags</label>                        

                    <textarea rows="3" class="form-control" name="tags" id="tags"><?php echo $str_tag; ?></textarea>

                </div>   
                -->
                <div class="form-group">

                    <label>Nguồn</label>                        

                    <input type="text" name="source" class="form-control required" value="<?php echo isset($data['source'])  ? $data['source'] : "vereairline.com" ?>">                

                </div>             
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

                    <label>Mô tả ngắn </label>                        

                    <textarea rows="5" class="form-control" name="description"><?php if(isset($data['description'])) echo $data['description']; ?></textarea>

                </div>  
                
                <div class="form-group">                                
                    <input type="checkbox" name="is_hot" id="is_hot" value="1" <?php if(!empty($data['is_hot']) && $data['is_hot']==1) echo "checked"; ?> />
                    <label style="color:red">Nổi bật (Hiện trang chủ)</label>
                </div>
                <div class="form-group">                                
                    <input type="checkbox" name="hidden" id="hidden" value="1" <?php if(!empty($data['hidden']) && $data['hidden']==1) echo "checked"; ?> />
                    <label style="color:red">Bài viết ẩn</label>
                </div>

            </div>                         
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
                        <!--
                        <div class="form-group">
                            <label>SEO TEXT</span></label>
                            <textarea name="seo_text" id="seo_text" class="form-control" rows="5"><?php if(!empty($data)) echo $data['seo_text']; ?></textarea>
                        </div>
                    -->
                    </div>        
                </div>  
                <div style="clear:both"></div>
            </div><!-- nav-tabs-custom -->
            </div><!-- /.col --> 
            </div>  

            
            <div class="clear"></div>
            <div class="form-group" style="margin-top:20px">

                <label>Nội dung <span class="required"> ( * ) </span></label>                        

                <textarea rows="5" id="content" class="form-control" name="content"><?php if(isset($data['content'])) echo $data['content']; ?></textarea>

            </div>           

            <div class="button">

                <button class="btn btn-primary btnSave" type="submit">Save</button>

                <button class="btn btn-primary" onclick="location.href='<?php echo $link; ?><?php echo $link_form; ?>'">Cancel</button>

            </div>
        </div><!-- nav-tabs-custom -->
        </div>
    </form>

    </div><!-- /.col --> 

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
$(function(){
     $('#article_title').blur(function(){
        if($('#meta_title').val()==''){
            $('#meta_title').val($(this).val());
        }
        if($('#meta_keyword').val()==''){
            $('#meta_keyword').val($(this).val());
        }
        if($('#meta_description').val()==''){
            $('#meta_description').val($(this).val());
        }        
        if($('#title_en').val()==''){
            $.ajax({
                url: "ajax/Ajax.php",
                type: "POST",       
                data: {
                    'action' : 'ten-kd',
                    'name' : $('#article_title').val()
                },
                success: function(data){                         
                    $('#title_en').val(data);
                }
            });
        }
        if($('#article_alias').val()==''){
            $.ajax({
                url: "ajax/Ajax.php",
                type: "POST",       
                data: {
                    'action' : 'ten-slug',
                    'name' : $('#article_title').val()
                },
                success: function(data){                         
                    $('#article_alias').val(data);
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
   $('span.del_img').click(function(){
        var img_id = $(this).attr('data-value');
        if($("#daidien_" + img_id).is(":checked")){
            alert("Chọn ảnh khác làm ảnh đại diện trước khi xóa ảnh này.");
            return false;
        }else{
            if(confirm("Chắc chắn xóa ảnh này?")){ 
                $.ajax({
                    url: "controller/Delete.php",
                    type: "POST",
                    async: true,
                    data: {
                        'id' : img_id,
                        'mod' : 'images'
                    },
                    success: function(data){                    
                        $('#img_' + img_id).remove();  
                    }
                });
                    

            }else{
                return false;
            }
        }
   });
   $('#upload_images').ajaxForm({
            beforeSend: function() {                
            },
            uploadProgress: function(event, position, total, percentComplete) {
                $('#loading').show();  
                $('#upload_images').hide();          
            },
            complete: function(res) { 
                var data  = JSON.parse(res.responseText);                             
                //window.location.reload();                                   
                $( "#div_upload" ).dialog('close');  
                $('#btnSaveImage').show();  
                $('#load_hinh').html(data.html);
                $('#load_hinh').append(data.str_image);
                $('#loading').hide();  
                $('#upload_images').show();          
            }
        }); 
        $("#btnUpload").click(function(){
            $("#div_upload" ).dialog({
                modal: true,
                title: 'Upload images',
                width: 500,
                draggable: true,
                resizable: false,
                position: "center middle"
            });
        });
        $("#add_images").click(function(){
            $( "#wrapper_input_files" ).append("<input type='file' name='images[]' /><br />");
        });
        $("#btnXoa").click(function(){
        if(confirm('Bạn có chắc chắn xóa ảnh bìa này ?')){
            $("#url_image_old, #url_image" ).val('');
            $('#imgHinh').attr('src','');
            }
        });
});

</script>
<script type="text/javascript">
$(function(){       
    
    $('#tags').on("keydown", function (event) {  
        if (event.keyCode === $.ui.keyCode.TAB && $(this).data("autocomplete").menu.active) {
            event.preventDefault();
        }
    }).autocomplete({
        source: function (request, response) {
            $.getJSON("ajax/tag.php", {
                term: extractLast(request.term)                
            }, response);
        },
        search: function () {
            // custom minLength
            var term = extractLast(this.value);
            if (term.length < 2) {
                return false;
            }
        },
        focus: function () {
            // prevent value inserted on focus
            return false;
        },
        select: function (event, ui) {
            var terms = split(this.value);
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push(ui.item.value);
            // add placeholder to get the comma-and-space at the end
            terms.push("");
            this.value = terms.join("; ");
            return false;
        }
    });
});
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
var editor = CKEDITOR.replace( 'content',configEditor); 
configEditor['height'] = '550px';    
configEditor['width'] = '760px';    
//var editor2 = CKEDITOR.replace( 'seo_text',configEditor); 
</script>