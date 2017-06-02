<?php 
require_once "model/Backend.php";
$model = new Backend;

$cateTypeArr = $model->getListCateType();
$manuArr = $model->getListManu();
$ageArr = $model->getListAge();
$sizeArr = $model->getListSize();
$colorArr = $model->getListColor();
$back_url = "index.php?mod=product&act=list";
$detail = array();
if(isset($_GET['id'])){

    $id = (int) $_GET['id'];

    require_once "model/Backend.php";

    $model = new Backend;

    $detail = $model->getDetailProduct($id); 
    $data = $detail['data'];      
    $link.="&product_type_id=".$data['product_type_id'];
    $arrProductFor = array();
    $arrColorSelected = $model->getListColorProduct($id);
    $arrSizeSelected = $model->getListSizeProduct($id);
    if($data['product_for']!=''){
        $arrProductFor = explode(',',$data['product_for']);
    }
}
if (isset($_GET['product_code']) && $_GET['product_code'] != '') {
    $product_code = $_GET['product_code'];      
    $back_url .="&product_code=$product_code";
} else {
    $product_code = '';
}
if (isset($_GET['product_name']) && $_GET['product_name'] != '') {
    $product_name = $_GET['product_name'];
    $back_url.="&product_name=$product_name";
} else {
    $product_name = '';
}
if (isset($_GET['is_hot']) && $_GET['is_hot'] > -1) {
    $is_hot = (int) $_GET['is_hot']; 
    $link.="&is_hot=$is_hot";
} else {
    $is_hot = -1;
}
if (isset($_GET['is_saleoff']) && $_GET['is_saleoff'] > -1) {
    $is_saleoff = (int) $_GET['is_saleoff']; 
    $back_url.="&is_saleoff=$is_saleoff";
} else {
    $is_saleoff = -1;
}

if (isset($_GET['is_new']) && $_GET['is_new'] > -1) {
    $is_new = (int) $_GET['is_new'];
    $back_url.="&is_new=$is_new";
} else {
    $is_new = -1;
}
if (isset($_GET['trangthai']) && $_GET['trangthai'] > -1) {
    $trangthai = (int) $_GET['trangthai'];  
    $back_url.="&trangthai=$trangthai";
} else {
    $trangthai = -1;
}
if (isset($_GET['cate_type_id']) && $_GET['cate_type_id'] > 0) {
    $cate_type_id = (int) $_GET['cate_type_id'];
    $back_url.="&cate_type_id=$cate_type_id";
} else {
    $cate_type_id = -1;
}

if (isset($_GET['cate_id']) && $_GET['cate_id'] > 0) {
    $cate_id = (int) $_GET['cate_id'];
    $back_url.="&cate_id=$cate_id";
} else {
    $cate_id = -1;
}
if (isset($_GET['parent_id']) && $_GET['parent_id'] > 0) {
    $parent_id = (int) $_GET['parent_id'];      
    $back_url.="&parent_id=$parent_id";
    if($cate_id == $parent_id) $cate_id = -1;
} else {
    $parent_id = -1;
}
?>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-primary btn-sm" onclick="location.href='<?php echo $back_url; ?>'">Back</button>
        <form method="post"  action="controller/Product.php">

        <div class="col-md-6">

            <!-- Custom Tabs -->

            <div style="clear:both;margin-bottom:10px"></div>

            <div class="box-header">

                <h3 class="box-title"><?php echo (isset($id) && $id> 0) ? "Cập nhật" : "Tạo mới" ?> sản phẩm <?php echo (isset($id) && $id> 0) ? " : ".$data['product_name'] : ""; ?></h3>

                <?php if(isset($id) && $id> 0){ ?>

                <input type="hidden" value="<?php echo $id; ?>" name="product_id" />

                <?php } ?>

            </div><!-- /.box-header -->

            <div class="nav-tabs-custom">

                <div class="button">

                    <div class="row">

                        <div class="col-md-12" >
                            <div class="form-group">
                                <label>Mã sản phẩm <span class="required"> ( * ) </span></label>
                                <input type="text" name="product_code" id="product_code" class="form-control" value="<?php if(!empty($data)) echo $data['product_code']; ?>" />
                            </div>
                            <div class="form-group">
                                <label>Tên sản phẩm <span class="required"> ( * ) </span></label>
                                <input type="text" name="product_name" id="product_name" class="form-control" value="<?php if(!empty($data)) echo $data['product_name']; ?>" />
                            </div>
                            <div class="form-group">
                                <label>Tên sản phẩm KD <span class="required"> ( * ) </span></label>
                                <input type="text" name="name_en" id="name_en" class="form-control" value="<?php if(!empty($data)) echo $data['name_en']; ?>" />
                            </div>
                            <div class="form-group">
                                <label>Thuộc menu danh mục<span class="required"> ( * ) </span></label>
                                <select name="cate_type_id" id="cate_type_id" class="form-control">   
                                    <option value='0' selected >--Chọn--</option>                                                                                            
                                    <?php if(!empty($cateTypeArr)){
                                        foreach($cateTypeArr as $cateType){ ?>
                                        <option value="<?php echo $cateType['id']; ?>"
                                        <?php if(!empty($data) && $data['cate_type_id'] == $cateType['id']) echo "selected"; ?>
                                        ><?php echo $cateType['cate_type_name'] ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group" >
                                <label>Danh mục<span class="required"> ( * ) </span></label>
                                <select name="cate_id" id="cate_id" class="form-control"> 
                                    <option value='0' selected >--Chọn--</option>  
                                    <?php 
                                    $arrCate = $model->getListCate(1);  
                                    if(!empty($arrCate)){                                    
                                        foreach ($arrCate as $cate1) {
                                            echo "<option value='".$cate1['id'].">".$cate1['cate_name']."</option>";                                        
                                        }
                                    }
                                    ?>                                                        
                                </select>                                
                            </div>
                            <div class="form-group">
                                <label>Áo dành cho<span class="required"> ( * ) </span></label>
                                <div id="for_family" style="display:none">
                                    <div class="col-md-2">
                                        <input 
                                        <?php if($data['cate_type_id']==2 && in_array(1, $arrProductFor)) echo "checked"; ?>
                                        type="checkbox" name="product_for[]" value="1" id="product_for_1"/>
                                        <label for="product_for_1">Ông </label>                                       
                                    </div>
                                    <div class="col-md-2">
                                        <input type="checkbox" name="product_for[]" value="2" id="product_for_2"
                                        <?php if($data['cate_type_id']==2 && in_array(2, $arrProductFor)) echo "checked"; ?>
                                        />
                                        <label for="product_for_2">Bà </label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="checkbox" name="product_for[]" value="3" id="product_for_3" 
                                        <?php if($data['cate_type_id']==2 && in_array(3, $arrProductFor)) echo "checked"; ?>
                                        /> 
                                        <label for="product_for_3">Cha </label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="checkbox" name="product_for[]" value="4" id="product_for_4" 
                                        <?php if($data['cate_type_id']==2 && in_array(4, $arrProductFor)) echo "checked"; ?>
                                        />
                                        <label for="product_for_4">Mẹ </label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="checkbox" name="product_for[]" value="5" id="product_for_5" 
                                        <?php if($data['cate_type_id']==2 && in_array(5, $arrProductFor)) echo "checked"; ?>
                                        />
                                        <label for="product_for_5">B.trai </label>                                         
                                    </div>
                                    <div class="col-md-2">
                                        <input type="checkbox" name="product_for[]" value="6" id="product_for_6" 
                                        <?php if($data['cate_type_id']==2 && in_array(6, $arrProductFor)) echo "checked"; ?>
                                        />
                                        <label for="product_for_6">B.gái </label>
                                    </div>
                                </div>
                                <div id="for_other" style="display:none">
                                    <div class="col-md-3">
                                        <input type="checkbox" name="product_for[]" value="5" id="product_for_7"
                                        <?php if($data['cate_type_id']!=2 && in_array(5, $arrProductFor)) echo "checked"; ?>
                                        />
                                        <label for="product_for_7">Nam </label>                                        
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" name="product_for[]" value="6" id="product_for_8" 
                                        <?php if($data['cate_type_id']!=6 && in_array(5, $arrProductFor)) echo "checked"; ?>
                                        />
                                        <label for="product_for_8">Nữ </label>                                        
                                    </div>  
                                    <div class="col-md-6"></div>                                 
                                </div>
                                <div class="clearfix"></div>  
                            </div>                          
                            <div class="form-group">
                                <label>Color<span class="required"> ( * ) </span></label>
                                <div>
                                    <?php 
                                    $c_color = 0;
                                    foreach ($colorArr as $key => $value) {            
                                    $c_color++;                         
                                    ?>
                                    <div class="col-md-2">
                                        <input type="checkbox" name="color[]" value="<?php echo $value['id']; ?>" id="color_<?php echo $c_color; ?>" 
                                        <?php if(in_array($value['id'], $arrColorSelected)) echo "checked"; ?>
                                        />
                                        <label for="color_<?php echo $c_color; ?>">
                                            <div style="width:20px;height:20px;background-color:<?php echo $value['color_code']; ?>"></div>
                                        </label>                                       
                                    </div>
                                    <?php } ?>
                                </div>    
                                <div class="clearfix"></div>                             
                            </div>  
                            <div class="form-group">
                                <label>Size<span class="required"> ( * ) </span></label>
                                <div>
                                    <?php 
                                    $c_size = 0;
                                    foreach ($sizeArr as $key => $value) {            
                                    $c_size++;                         
                                    ?>
                                    <div class="col-md-2">
                                        <input type="checkbox" name="size[]" value="<?php echo $value['id']; ?>" id="size_<?php echo $c_size; ?>"
                                        <?php if(in_array($value['id'], $arrSizeSelected)) echo "checked"; ?>
                                        />
                                        <label for="size_<?php echo $c_size; ?>">
                                            <?php echo $value['size_name']; ?>                                            
                                        </label>                                       
                                    </div>
                                    <?php } ?>
                                </div>        
                                <div class="clearfix"></div>                       
                            </div>      
                           
                            <div class="form-group"  style="margin-top:20px">
                                <label>Mô tả ngắn</span></label>
                                <textarea name="description" id="description" class="form-control" rows="5"><?php if(!empty($data)) echo $data['description']; ?></textarea>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group">                                
                                    <input type="checkbox" name="is_new" id="is_new" value="1" <?php if(!empty($data['is_new']) && $data['is_new']==1) echo "checked"; ?> />
                                    <label style="color:blue">SP MỚI</label>
                                </div>
                            </div>  
                          
                            <div class="col-md-4">
                                <div class="form-group">                                
                                    <input type="checkbox" name="is_hot" id="is_hot" value="1" <?php if(!empty($data['is_hot']) && $data['is_hot']==1) echo "checked"; ?> />
                                    <label style="color:blue">SP Nổi bật</label>
                                </div>
                            </div>   
                            <div class="col-md-4">
                                <div class="form-group">                                
                                    <input type="checkbox" name="is_end" id="is_end" value="1" <?php if(!empty($data['is_end']) && $data['is_end']==1) echo "checked"; ?> />
                                    <label style="color:red">Hết hàng</label>
                                </div>
                            </div>                          
                            <div class="col-md-8">
                                <div class="form-group">                                
                                    <input type="checkbox" name="hidden" id="hidden" value="1" <?php if(!empty($data['hidden']) && $data['hidden']==1) echo "checked"; ?> />
                                    <label style="color:blue">Ẩn</label>
                                </div>
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
                        <h4 class="box-title">Thông tin giá</h4>
                        <div class="form-group">
                            <label>Giá sản phẩm <span class="required"> ( * ) </span></label>
                            <input type="text" name="price" id="price" class="form-control required" value="<?php if($data['price'] > 0) echo $data['price']; ?>" />
                        </div>
                        <div class="form-group">                                
                            <input type="checkbox" name="is_saleoff" id="is_saleoff" value="1" <?php if($data['is_saleoff']==1) echo "checked"; ?> />
                            <label style="color:green">SALE OFF</label>
                        </div> 
                        <div class="form-group input-saleoff">
                            <label>Giá đã giảm </label>
                            <input type="text" name="price_saleoff" id="price_saleoff" class="form-control" value="<?php if($data['price_saleoff'] > 0) echo $data['price_saleoff']; ?>" />
                        </div>
                         <div class="form-group input-saleoff">
                            <label>% giảm</label>
                            <input type="text" name="percent_deal" id="percent_deal" class="form-control" value="<?php if($data['percent_deal'] > 0) echo $data['percent_deal']; ?>" />
                        </div>
                                       
                    </div>        
                </div>  
                <div style="clear:both"></div>
            </div><!-- nav-tabs-custom -->
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
                <div class="form-group col-md-12" style="padding-top:5px">
                    <label>Hình ảnh <span style="color:red">( Size : Hình vuông kích thước  >= 300 x 300px)</span></label>
                    <br /><button class="btn btn-primary" type="button" id="btnUpload" style="margin-bottom:10px">Upload</button>                       
                    <div id="load_hinh">
                        
                    </div>
                    <?php if(isset($detail['images']) && $detail['images']){ ?>
                    <div id="images_post">
                        <?php foreach ($detail['images'] as $v) { 
                            $checked = $v['url'] == $data['image_url'] ? "checked='checked'" :  "";
                            ?>
                        <div class="col-md-2 image_upload" id="img_<?php echo $v['image_id']; ?>">
                            <img src="../<?php echo $v['url']; ?>" width="150"><br />
                            <p style="width:70%;float:left;margin-top:10px">
                                <input type="radio" <?php echo $checked; ?> name="image_url" value="<?php echo $v['url']; ?>" id="daidien_<?php echo $v['image_id']; ?>" /> Ảnh đại diện
                            </p>
                            <p style="width:30%;float:left;text-align:right;margin-top:10px">
                                <span class="del_img" style="cursor:pointer" data-value="<?php echo $v['image_id']; ?>">Xóa</span>
                            </p>
                        </div>
                        <?php } ?>
                    </div>                
                    <?php } ?>                    
                </div>               
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Chi tiết</span></label>
                        <textarea name="content" id="content" class="form-control" rows="7"><?php if(!empty($data)) echo $data['content']; ?></textarea>
                    </div>
                </div>              
                
            </div>

            <div class="button">
                <button class="btn btn-primary btnSaves" type="submit" onclick="return validateData();">Save</button>
                <button class="btn btn-primary" type="button"  onclick="location.href='<?php echo $back_url; ?>'">Cancel</button>
            </div>

        </div>
        </form>
    </div>
</div>
<script src="js/form.js" type="text/javascript"></script>
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
                <input type="file" name="images[]" /><br />
            </div>    
            <?php if($detail){ ?>        
                <input type="hidden" name="is_update" value="1" />
            <?php } ?>
            <button style="margin-top: 10px;" class="btn btn-primary" type="submit" id="btn_upload_images">Upload</button>            
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
<style type="text/css">
#percent_deal{color:red;}
fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}

legend.scheduler-border {
    font-size: 1.2em !important;
    font-weight: bold !important;
    text-align: left !important;
    border-bottom: none;
}
</style>
<link href="static/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="static/js/ajaxupload.js"></script>
<script type="text/javascript" src="js/number.js"></script>
<script type="text/javascript">
function checkcode(product_code){   
    var flag = true;     
    if(product_code==''){
        alert('Vui lòng nhập mã sản phẩm!');
        $('#product_code').focus();
        flag = false;       
    }else{
        $.ajax({
            url: "ajax/Ajax.php",
            type: "POST",
            async: true,
            data: {
                'action' : 'check-product-code',
                'product_code' : product_code
            },
            success: function(data){                    
                if($.trim(data)==1){
                    alert("Mã sản phẩm đã tồn tại, vui lòng nhập mã khác.");
                    $('#product_code').focus();
                    flag = false;
                   
                }
            }
        });
    }
    return flag ; 
}
function validateData(){
    var flag = true;
    var product_code = $('#product_code').val();
    <?php if(!isset($id)){?>
    flag = checkcode(product_code);
    <?php } ?>
    if(flag == true){
        var product_code = $('#product_code').val();
        var product_name = $('#product_name').val();
        var name_en = $('#name_en').val();
        var cate_type_id = $('#cate_type_id').val();
        var cate_id = $('#cate_id').val();
        var price = $('#price').val();
        var manu_id = $('#manu_id').val();
        var age_range = $('#age_range').val(); 
        if(product_code == '' ){
            alert('Vui lòng nhập mã sản phẩm!');
            return false;           
                
        }       
        if(product_name == '' ){
            alert('Vui lòng nhập tên sản phẩm!');
            return false;           
                
        }
        if(name_en == '' ){
            alert('Vui lòng nhập tên sản phẩm KD!');
            return false;           
                
        }
        if(price == '' || price == 0){
            alert('Vui lòng nhập giá sản phẩm > 0 !');
            return false;           
                
        }
         if(cate_type_id == 0){
            alert('Vui lòng chọn menu danh mục!');
            return false;           
                
        }
         if( cate_id == 0 || cate_id == null){
            alert('Vui lòng chọn danh mục!');
            return false;           
                
        }
         if(manu_id == 0){
            alert('Vui lòng chọn thương hiệu!');
            return false;           
                
        }      
    }
    if($('#price_saleoff').val() > 0 || $('#percent_deal').val() > 0 ){
        $('#is_saleoff').prop('checked',true);
    }   
    if($('#is_saleoff').is(':checked')){
        var price_saleoff = $('#price_saleoff').val();
        var percent_deal = $('#percent_deal').val();
        console.log(price_saleoff, percent_deal);
        if(price_saleoff == 0 || percent_deal == 0 || price_saleoff == '' || percent_deal == '' ){
            alert('Vui lòng nhập giá đã giảm và % giảm!');
            return false;
        }

    }       
    return flag;
}
$(function(){   
    <?php 
    if($data['cate_type_id']==2 && !empty($data)){ ?>
        $('#for_family').show();
    <?php } ?>
    <?php 
    if($data['cate_type_id']!=2 && !empty($data)){ ?>
        $('#for_other').show();
    <?php
    }
    ?>     
    $('.datetime').datetimepicker({
         step:5,
         format:'d-m-Y H:i'
    });
  
    $('#product_name').blur(function(){
        if($('#meta_title').val()==''){
            $('#meta_title').val($(this).val());
        }
        if($('#meta_keyword').val()==''){
            $('#meta_keyword').val($(this).val());
        }
        if($('#meta_description').val()==''){
            $('#meta_description').val($(this).val());
        }        
        if($('#name_en').val()==''){
            $.ajax({
                url: "ajax/Ajax.php",
                type: "POST",       
                data: {
                    'action' : 'ten-kd',
                    'name' : $('#product_name').val()
                },
                success: function(data){                         
                    $('#name_en').val(data);
                }
            });
        }
    });
    $('#price,#price_saleoff').number(true,0);
    $('#price_old').blur(function(){
        var price_old = parseInt($(this).val());
        var price = parseInt($('#price').val());   
        if(price_old > price){
            var sotiengiam = price_old - price;
            var percent = (sotiengiam*100/price_old).toFixed(0);
            $('#percent_deal').val(percent);
        }
    });
    $('#price_saleoff').blur(function(){
        var price_saleoff = parseInt($(this).val());
        var price = parseInt($('#price').val());   
        if(price_saleoff > 0){
            if(price > price_saleoff){
                var sotiengiam = price - price_saleoff;
                var percent = (sotiengiam*100/price).toFixed(0);
                $('#percent_deal').val(percent);
            }
            if(price_saleoff >= price){
                alert('Giá giảm phải nhỏ hơn giá sản phẩm!');
                $('#price_saleoff').val('');
                $('#price_saleoff').focus();
                return false;
            }
        }else{
            alert('Vui lòng nhập giá giảm > 0');
            $('#price_saleoff').val('');
            $('#price_saleoff').focus();
            return false;
        }
    });
    $('#percent_deal').blur(function(){
        var percent = parseInt($(this).val());
        var price = parseInt($('#price').val());                        

        if(percent > 0 && price > 0){
            var a = 100-percent;
            var price_saleoff = a*price/100 ;
            $('#price_saleoff').val(price_saleoff);   
        }
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
            $('#cate_id').html(data);

            <?php if($data['cate_id'] > 0){ ?>
                 $('#cate_id').val(<?php echo $data['cate_id']; ?>);
            <?php } ?>
        }
    }); 
}

$(function(){
    $('#cate_type_id').change(function(){
        getCateByCateType($(this).val(),"get-cate-by-type-product"); 
        if($(this).val()==2){
            $('#for_family').show();
            $('#for_other').hide();
        }else{
            $('#for_family').hide();
            $('#for_other').show();
        }
    });
    <?php if($data['cate_type_id'] > 0){ ?>
        getCateByCateType(<?php echo $data['cate_type_id']; ?>,"get-cate-by-type-product");        
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
    $('#img_thumnails').attr('src','../' + fileUrl).show();
}
</script>
<script type="text/javascript">
configEditor['height'] = 300;
var editor = CKEDITOR.replace( 'content',configEditor);   
var editor1 = CKEDITOR.replace( 'guide_use',configEditor);     
</script>
