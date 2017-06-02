<?php 

if(isset($_GET['promotion_id'])){

    $promotion_id = (int) $_GET['promotion_id'];

    require_once "model/Promotion.php";

    $model = new Promotion;

    $detail = $model->getDetailPromotion($promotion_id);

}

?>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>

<script type="text/javascript" src="ckfinder/ckfinder.js"></script>

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

    $('#hinh_dai_dien').attr('src',fileUrl).show();

}

</script>
<div class="row">

    <div class="col-md-8">

        <form method="post" action="controller/Promotion.php">            

        <!-- Custom Tabs -->

        <button class="btn btn-primary btn-sm">Danh sách</button>

        <div style="clear:both;margin-bottom:10px"></div>

         <div class="box-header">

                <h3 class="box-title"><?php echo ($promotion_id > 0) ? "Cập nhật" : "Tạo mới" ?> khuyến mãi</h3>

                <?php if($promotion_id> 0){ ?>

                <input type="hidden" value="<?php echo $promotion_id; ?>" name="promotion_id" />

                <?php } ?>

            </div><!-- /.box-header -->

            

        <div class="nav-tabs-custom">            

            <ul class="nav nav-tabs">

                <li class="active"><a data-toggle="tab" href="#tab_1">

                    <img src="<?php echo STATIC_URL?>img/vi.png"/>

                </a></li>

                <li class=""><a data-toggle="tab" href="#tab_2">

                    <img src="<?php echo STATIC_URL?>img/uk_.png"/>

                </a></li>              

                <li class="pull-right"><a class="text-muted" href="#"><i class="fa fa-gear"></i></a></li>

            </ul>

            <div class="tab-content">

                <div id="tab_1" class="tab-pane active">

                    <div class="form-group">

                        <label>Tiêu đề <span class="required"> ( * ) </span></label>

                        <input type="text" name="title_vi" class="form-control required" value="<?php echo isset($detail['title_vi'])  ? $detail['title_vi'] : "" ?>"/>

                    </div>

                    <div class="form-group">

                        <label>Mô tả ngắn</label>

                        <textarea rows="3" class="form-control required" name="description_vi"><?php if(isset($detail['description_vi'])) echo $detail['description_vi']; ?></textarea>

                    </div>
                    <div class="form-group">

                        <label>Nội dung</label>

                        <textarea rows="3" class="form-control" name="content_vi" id="content_vi"><?php if(isset($detail['content_vi'])) echo $detail['content_vi']; ?></textarea>

                    </div>

                   

                </div><!-- /.tab-pane -->

                <div id="tab_2" class="tab-pane">

                    <div class="form-group">

                        <label>Title <span class="required"> ( * ) </span></label>

                        <input type="text" name="title_en" class="form-control required" value="<?php echo isset($detail['title_en'])  ? $detail['title_en'] : "" ?>">

                    </div>

                    <div class="form-group">

                        <label>Description</label>

                        <textarea rows="3" class="form-control " name="description_en"><?php if(isset($detail['description_en'])) echo $detail['description_en']; ?></textarea>

                    </div>
                    <div class="form-group">

                        <label>Content</label>

                        <textarea rows="3" class="form-control" name="content_en" id="content_en"><?php if(isset($detail['content_en'])) echo $detail['content_en']; ?></textarea>

                    </div>
                </div><!-- /.tab-pane -->

            </div><!-- /.tab-content -->

            

            <div class="button">
                <div class="checkbox" style="margin-bottom:20px">

                <label class="">

                    <input type="checkbox" name="hot" value="1" <?php echo ($detail['hot']==1) ? "checked" : ""; ?> />               

                    <strong>KHUYẾN MÃI HOT (SLIDE)</strong>

                </label>                                                

                </div>                

                <div class="form-group">

                    <label>Hình đại diện &nbsp;&nbsp;&nbsp;</label>

                    <input type="hidden" name="image_url" id="image_url" class="form-control" value="<?php echo isset($detail['image_url'])  ? $detail['image_url'] : "" ?>">

                    <img src="<?php echo isset($detail['image_url'])  ? "../".$detail['image_url'] : "" ?>" id="hinh_dai_dien" width="400" style="<?php echo ($detail['image_url']!="")  ? "" : "display:none;" ?>margin-top:5px"/>

                    <button class="btn btn-primary" type="button" onclick="BrowseServer('Images:/','image_url')" >Chọn ảnh</button>

                </div>
                <button class="btn btn-primary btnSave" type="submit">Save</button>

                <button class="btn btn-primary" type="reset">Cancel</button>

            </div>

           

        </div><!-- nav-tabs-custom -->

    </form>

    </div><!-- /.col --> 

</div>
<script type="text/javascript">
var editor = CKEDITOR.replace( 'content_vi',{
    uiColor : '#9AB8F3',
    language:'vi',
    height:400,
    skin:'office2003',
    filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?Type=Images',
    filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?Type=Flash',
    filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
                
    toolbar:[
    ['Source','-','Save','NewPage','Preview','-','Templates'],
    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print'],
    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
    ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Link','Unlink','Anchor'],
    ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
    ['Styles','Format','Font','FontSize'],
    ['TextColor','BGColor'],
    ['Maximize', 'ShowBlocks','-','About']
    ]
});     
</script>
<script type="text/javascript">
var editor = CKEDITOR.replace( 'content_en',{
    uiColor : '#9AB8F3',
    language:'vi',
    height:400,
    skin:'office2003',
    filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?Type=Images',
    filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?Type=Flash',
    filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
                
    toolbar:[
    ['Source','-','Save','NewPage','Preview','-','Templates'],
    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print'],
    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
    ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Link','Unlink','Anchor'],
    ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
    ['Styles','Format','Font','FontSize'],
    ['TextColor','BGColor'],
    ['Maximize', 'ShowBlocks','-','About']
    ]
});     
</script>