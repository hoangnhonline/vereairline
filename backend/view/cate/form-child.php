<?php 
require_once "model/Backend.php";
$model = new Backend;

$cateTypeArr = $model->getListCateType();

$link = "index.php?mod=cate&act=list";
$detail = array();
if(isset($_GET['cate_type_id'])){
    $cate_type_id = $_GET['cate_type_id']; 
    $detailCateType = $model->getDetailCateType($cate_type_id);   
}
if(isset($_GET['parent_id'])){
    $parent_id = $_GET['parent_id'];     
}
if(isset($_GET['id'])){

    $id = (int) $_GET['id'];

    require_once "model/Backend.php";

    $model = new Backend;

    $data = $model->getDetailCate($id);       
   $parent_id = $data['parent_id'];
   $cate_type_id = $data['cate_type_id'];
    $detailCateType = $model->getDetailCateType($cate_type_id);   
     $detailParent = $model->getDetailCate($parent_id);   
    $link.="&parent_id=".$data['parent_id'];
}
?>
<div class="row">
    <div class="col-md-12">
        <div id="breadcrumb">
            <ul>
                <li>Dashboard</li>
                <li class="arrow"><img src="img/arrow.png"></li>
                <li>
                    <a href="index.php?mod=cate&act=list&cate_type_id=<?php echo $cate_type_id ; ?>"><?php echo $detailCateType['cate_type_name']; ?></a>
                </li>
                <li class="arrow"><img src="img/arrow.png"></li>
                <li>
                    <a href="index.php?mod=cate&act=list-child&parent_id=<?php echo $parent_id ; ?>"><?php echo $detailParent['cate_name']; ?></a>
                </li>
            </ul>
        </div>
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=cate&act=list-child&parent_id=<?php echo $parent_id; ?>'">
            Back
        </button>
        <form method="post"  action="controller/Cate.php" enctype="multipart/form-data">

        <div class="col-md-6">

            <!-- Custom Tabs -->

            <div style="clear:both;margin-bottom:10px"></div>

            <div class="box-header">

                <h3 class="box-title"><?php echo (isset($id) && $id> 0) ? "Cập nhật" : "Tạo mới" ?> danh mục <?php echo (isset($id) && $id> 0) ? " : ".$data['cate_name'] : ""; ?></h3>

                <?php if(isset($id) && $id> 0){ ?>
                <input type='hidden' name='display_order' value="<?php echo $data['display_order']; ?>">
                <input type="hidden" value="<?php echo $id; ?>" name="cate_id" />

                <?php } ?>

            </div><!-- /.box-header -->

            <div class="nav-tabs-custom">

                <div class="button">                    

                    <div class="row">
                            
                        <div class="col-md-12" >
                            <div class="form-group">
                                <label>Tên danh mục cấp 3 <span class="required"> ( * ) </span></label>
                                <input type="text" name="cate_name" id="cate_name" class="form-control required" value="<?php if(!empty($data)) echo $data['cate_name']; ?>" />
                            </div>
                           
                            <div class="form-group">
                                <label>Thuộc menu danh mục <span class="required"> ( * ) </span></label>
                                <select name="cate_type_id" id="cate_type_id" class="form-control">                                    
                   
                                    <?php if(!empty($cateTypeArr)){
                                        foreach($cateTypeArr as $cateType){ ?>
                                        <option value="<?php echo $cateType['id']; ?>"
                                        <?php if(!empty($data) && $data['cate_type_id'] == $cateType['id']) echo "selected"; ?>
                                        ><?php echo $cateType['cate_type_name'] ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Danh mục cha<span class="required"> ( * ) </span></label>
                                <select name="parent_id" id="parent_id" class="form-control">                                    
                                                        
                                </select>
                            </div>
                           <input type="hidden" name="image_url" id="image_url" class="form-control" value="<?php if(!empty($data['image_url'])) echo "../".$data['image_url']; ?>" /><br />
                           <input type="hidden" name="icon_url" id="icon_url" class="form-control" value="<?php if(!empty($data['icon_url'])) echo "../".$data['icon_url']; ?>" /><br />
                           <!--
                            <div class="form-group">
                                <label>Ảnh banner</label>
                                <input type="radio" id="choose_img_sv" name="choose_img" value="1" checked="checked"/> Chọn ảnh từ server
                                &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="choose_img_cp" name="choose_img" value="2" /> Chọn ảnh từ máy tính
                                <div id="from_sv">
                                    <input type="hidden" name="image_url" id="image_url" class="form-control" value="<?php if(!empty($data['image_url'])) echo "../".$data['image_url']; ?>" /><br />
                                    <?php if(!empty($data['image_url'])){ ?>
                                    <img id="img_thumnails" src="../<?php echo $data['image_url']; ?>" height="200" />
                                    <?php }else{ ?>
                                    <img id="img_thumnails" src="static/img/no_image.jpg" width="200" />
                                    <?php } ?>
                                    <button class="btn btn-default " type="button" onclick="BrowseServer('Images:/','image_url')" >Upload</button>
                                </div>
                                <div id="from_cp" style="display:none;padding:15px;margin-bottom:10px">
                                    <input type="file" name="image_url_upload" />
                                </div>

                            </div>
                            <div class="form-group">
                                <label>Ảnh icon</label>
                                 <input type="radio" id="choose_icon_sv" name="choose_icon" value="1" checked="checked"/> Chọn ảnh từ server
                                &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="choose_icon_cp" name="choose_icon" value="2" /> Chọn ảnh từ máy tính
                                <div id="from_sv_icon">
                                    <input type="hidden" name="icon_url" id="icon_url" class="form-control" value="<?php if(!empty($data['icon_url'])) echo "../".$data['icon_url']; ?>" /><br />
                                    <?php if(!empty($data['icon_url'])){ ?>
                                    <img src="../<?php echo $data['icon_url']; ?>" height="80" />
                                    <?php }else{ ?>
                                    <img id="img_icon" src="static/img/no_image.jpg" width="80" />
                                    <?php } ?>
                                    <button class="btn btn-default " type="button" onclick="BrowseServerIcon('Images:/','icon_url')" >Upload</button>
                                </div>
                                <div id="from_cp_icon" style="display:none;padding:15px;margin-bottom:10px">
                                    <input type="file" name="icon_url_upload" />
                                </div>
                            </div> 
                        -->
                            <div class="form-group">                                
                                <input type="checkbox" name="is_hot" id="is_hot" value="1" <?php if(!empty($data['is_hot']) && $data['is_hot']==1) echo "checked"; ?> />
                                <label style="color:red">Danh mục nổi bật</label>
                            </div>
                             <div class="form-group">                                
                                <input type="checkbox" name="hidden" id="hidden" value="1" <?php if(!empty($data['hidden']) && $data['hidden']==1) echo "checked"; ?> />
                                <label style="color:red">Ẩn</label>
                            </div>
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
            <div class="row">               
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Mô tả ngắn</span></label>
                        <textarea name="content" id="content" class="form-control" rows="10"><?php if(!empty($data)) echo $data['content']; ?></textarea>
                    </div>
                </div>
            </div>       

            <div class="button">
                <button class="btn btn-primary btnSave" type="submit" >Save</button>
                <button class="btn btn-primary" type="button"  onclick="location.href='index.php?mod=cate&act=list-child&parent_id=<?php echo $parent_id; ?>'"> Cancel</button>
            </div>

        </div>
        </form>
    </div>
</div>
<link href="static/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="ckfinder/ckfinder.js"></script>
<script type="text/javascript">
function getCateByCateType(cate_type_id,action){
    $.ajax({
        url: "ajax/Ajax.php",
        type: "POST",
        async: true,
        data: {                             
            'action' : action,
            'cate_type_id' : cate_type_id
        },
        success: function(data){                                                    
            $('#parent_id').html(data);
            <?php if(isset($data) && $data['parent_id'] > 0){ ?>
            setTimeout(function(){ $('#parent_id').val(<?php echo $data['parent_id']; ?>)},1000);
            <?php } ?>
        }
    }); 
}
$(function(){   
    $('#cate_type_id').change(function(){
        getCateByCateType($(this).val(),"get-cate-by-type");
    });
    <?php if(isset($data) && $data['cate_type_id'] > 0){ ?>
        getCateByCateType(<?php echo $data['cate_type_id']; ?>,"get-cate-by-type");        
    <?php } ?>
    <?php if(isset($_GET['cate_type_id'])){ ?>
        $('#cate_type_id').val(<?php echo $_GET['cate_type_id'];?>);
        getCateByCateType(<?php echo $_GET['cate_type_id'];?>,"get-cate-by-type");
        <?php if(isset($_GET['parent_id'])){ ?>
            setTimeout(function(){ $('#parent_id').val(<?php echo $_GET['parent_id']; ?>)},1000);
        <?php } ?>
    <?php } ?>
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
    $('#img_thumnails').attr('src', fileUrl).show();
}
function BrowseServerIcon( startupPath, functionData ){    
    var finder = new CKFinder();
    finder.basePath = 'ckfinder/'; //Đường path nơi đặt ckfinder
    finder.startupPath = startupPath; //Đường path hiện sẵn cho user chọn file
    finder.selectActionFunction = SetFileFieldIcon; // hàm sẽ được gọi khi 1 file được chọn
    finder.selectActionData = functionData; //id của text field cần hiện địa chỉ hình
    //finder.selectThumbnailActionFunction = ShowThumbnails; //hàm sẽ được gọi khi 1 file thumnail được chọn    
    finder.popup(); // Bật cửa sổ CKFinder
} //BrowseServer

function SetFileFieldIcon( fileUrl, data ){
    document.getElementById( data["selectActionData"] ).value = fileUrl;
    $('#img_icon').attr('src', fileUrl).show();
}
</script>
<script type="text/javascript">
configEditor['height'] = '100px';
var editor = CKEDITOR.replace( 'content',configEditor);     
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
    });
    $('#choose_img_sv').click(function(){
        $('#from_sv').show();
        $('#from_cp').hide();
    });
    $('#choose_img_cp').click(function(){
        $('#from_cp').show();
        $('#from_sv').hide();
    });
    $('#choose_icon_sv').click(function(){
        $('#from_sv_icon').show();
        $('#from_cp_icon').hide();
    });
    $('#choose_icon_cp').click(function(){
        $('#from_cp_icon').show();
        $('#from_sv_icon').hide();
    });
});
</script>
