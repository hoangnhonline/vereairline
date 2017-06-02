<style>
div#users-contain { width: 350px; margin: 20px 0; }
div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
.ui-dialog .ui-state-error { padding: .3em; }
.validateTips { border: 1px solid transparent; padding: 0.3em; }
label.error{ color:red;}
</style>
<?php 
$cityArr = $model->getListCity();
?>
<div class="col-md-6">
    <div class="contentbox">
        <div class="contentbox">
            <div class="form-search block-hoadao">
                <form method="POST" id="searchForm" action="ajax/booking.php">
                    <div class="form-title">
                        <span class="formtitle1"><?php echo $arrText[2]; ?></span>
                        <span class="formtitle2"><?php echo $arrText[3]; ?></span>
                    </div>
                    <div class="form-content">
                        <div class="form-checkbox" style="font-size:14px">
                            <label>
                                <input name="type" id="type1" type="radio" checked value="1"> 
                                Một chiều
                            </label>&nbsp;&nbsp;&nbsp;
                            <label>
                                <input name="type" id="type2" type="radio" value="2"> 
                                Khứ hồi
                            </label>
                        </div>
                        <div class="filter-title main-color">Bạn sẽ đi đâu?</div>
                        <div class="form-checkbox" style="font-size:14px">
                            <label>
                                <input name="national_type" id="national_type1" type="radio" checked value="1"> 
                                Trong nước
                            </label>&nbsp;&nbsp;&nbsp;
                            <label>
                                <input name="national_type" id="national_type2" type="radio" value="2"> 
                                Quốc tế
                            </label>
                        </div>
                        <div class="form-filter">
                            <div>
                                <div class="col-md-6 formfilter" id="noidia" >                
                                    <div class="col">
                                        <label>ĐIỂM KHỞI HÀNH</label>
                                        <select class="form-control" name="noi_di" id="noi_di">
                                            <option value="0">[-Chọn-]</option>
                                            <?php foreach ($cityArr as $value) {
                                            ?>
                                            <option value="<?php echo $value['city_id']; ?>"><?php echo $value['city_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label>ĐIỂM ĐẾN</label>
                                        <select class="form-control" name="noi_den" id="noi_den">
                                            <option value="0">[-Chọn-]</option>
                                            <?php foreach ($cityArr as $value) {
                                            ?>
                                            <option value="<?php echo $value['city_id']; ?>"><?php echo $value['city_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 formfilter" id="nuocngoai" style="display:none;">                
                                    <div class="col">
                                        <label>ĐIỂM KHỞI HÀNH</label>
                                        <input class="form-control" name="noi_di_ngoai" id="noi_di_ngoai" placeholder="Nhập tên TP hoặc sân bay">
                                    </div>
                                    <div class="col">
                                        <label>ĐIỂM ĐẾN</label>
                                        <input class="form-control" name="noi_den_ngoai" id="noi_den_ngoai" placeholder="Nhập tên TP hoặc sân bay">
                                    </div>
                                </div>
                                <div class="col-md-6 formfilter">
                                    <div class="">
                                        <label>THỜI GIAN ĐI</label>
                                        <div class="input-group">
                                            <input name="depatureDate" id="depatureDate" class="datepicker form-control" value="">                                            
                                        </div>
                                    </div>
                                    <div class="">
                                        <label>THỜI GIAN VỀ</label>
                                        <div class="input-group">
                                            <input name="returnDate" id="returnDate" class="datepicker form-control" value="">                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ps-with formfilter" style="margin-top:5px">
                                <div>
                                    <label>NGƯỜI LỚN</label>
                                    <select class="form-control" name="adultNo" id="adultNo">                    
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>               
                                </div>

                                <div>
                                    <label>TRẺ EM (2-12 Tuổi)</label>
                                    <select class="form-control" name="childNo" id="childNo">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>                
                                </div>
                                <div>
                                    <label>TRẺ EM (0-2 Tuổi)</label>
                                    <select class="form-control" name="infantNo" id="infantNo">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                                <div><button type="submit" class="btn-search"><?php echo $arrText[4]; ?></button></div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
        </div> 
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $("#searchForm").validate({
        rules: {                
            noi_di: {
                min: 1
            },
            depatureDate: {
                required: true                   
            },
            noi_den: {
                min: 1
            }      
        }
    });
    $('#searchForm').ajaxForm({
        beforeSend: function() {                
        },
        uploadProgress: function(event, position, total, percentComplete) {
            $("#dialog" ).dialog();         
        },
        complete: function(data) {  
            setTimeout( 
                function(){   
                    location.href='nhap-thong-tin.html';     
                });
        }
    });
});
</script>