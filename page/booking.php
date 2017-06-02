<?php 
$bookingArr = $_SESSION['booking'];
$cityArr = $model->getListCity();
?>
<div class="row-fluid datvechitiet" id="article">
<div class="col-md-8 col-sm-12">    
        <ol class="breadcrumb">
            <li><a href="<?php echo $baseUrl; ?>">Trang chủ</a></li>
            <li>Đặt vé</li>
        </ol>
        <div class="ps-page-header">
            <div class="main-color block-title">
                Đặt vé
            </div>
            <div class="stripe-line"></div>
            <a class="rss" href="#"><i class="fa fa-rss"></i></a>
        </div>
        <div class="ps-page-content">
            <div class="r0">
                <div class="row-fluid full-width pull-left">
                    <div class="col-md-12">
                        <div class="main-color block-title">
                            Thông tin vé
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="row-fluid">
                        <div class="col-md-3">Loại vé:</div>
                        <div class="col-md-9">                            
                            <?php echo $bookingArr['type'] == 1 ? "Một chiều" : "Khứ hồi" ; ?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-md-3">Điểm khởi hành:</div>
                        <div class="col-md-9">
                            <?php if($bookingArr['national_type'] == 1) echo $cityArr[$bookingArr['noi_di']]['city_name']; ?> (<?php echo $cityArr[$bookingArr['noi_di']]['city_code']; ?>)
                            <?php if($bookingArr['national_type'] == 2) echo $bookingArr['noi_di_ngoai']; ?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-md-3">Điểm đến:</div>
                        <div class="col-md-9">
                            <?php if($bookingArr['national_type'] == 1) echo $cityArr[$bookingArr['noi_den']]['city_name']; ?> (<?php echo $cityArr[$bookingArr['noi_den']]['city_code']; ?>)
                            <?php if($bookingArr['national_type'] == 2) echo $bookingArr['noi_den_ngoai']; ?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-md-3">Ngày khởi hành:</div>
                        <div class="col-md-9">
                            <?php echo date('d-m-Y', strtotime($bookingArr['depatureDate'])); ?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-md-3">Ngày về:</div>
                        <div class="col-md-9">
                            <?php if($bookingArr['returnDate'] != '') echo date('d-m-Y', strtotime($bookingArr['returnDate'])); ?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-md-3">Lượng hành khách:</div>
                        <div class="col-md-9">                            
                            <span>Người lớn: <?php echo $bookingArr['adultNo']; ?></span>
                            <span>, Trẻ em: <?php echo $bookingArr['childNo']; ?></span>
                            <span>, Em bé: <?php echo $bookingArr['infantNo']; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="r1">
                <div class="row-fluid full-width pull-left">
                    <div class="col-md-12">
                        <p><p>
                        <div class="main-color block-title">
                            Thông tin khách hàng
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-10 col-xs-12">
                <form action="ajax/save.php" method="POST" id="infoForm" name="infoForm">
                    <div class="form-group">
                        <label for="fullname">Họ và tên<span class="require">(*)</span></label>
                        <input type="text" class="form-control" id="fullname" name="fullname">
                    </div>
                    <div class="form-group">
                        <label for="email">Email<span class="require">(*)</span></label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="phone">Điện thoại<span class="require">(*)</span></label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ<span class="require">(*)</span></label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                    <div class="form-group">
                        <label for="notes">Ghi chú khác</label>
                        <textarea class="form-control" rows="5" id="notes" name="notes"></textarea>
                    </div>                  
                    <button type="submit" class="btn btn-primary btn-lag" id="btnRegist" name="btnRegist">
                    ĐẶT VÉ
                    </button>
                    <div id="loading" style="display:none"><img src="libs/images/loading.gif" alt="loading" /></div>
                </form>
                </div>
               
            </div><!--// r1 -->
            <div class="clearfix"></div>
        </div>        
    </div>
    <?php include "blocks/cate/right.php"; ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $("#infoForm").validate({
        rules: {                
            fullname: {
               required: true 
            },
            email: {
               required: true,
               email : true
            },
            phone: {
               required: true 
            },
            address: {
               required: true 
            }    
        }
    });
    $('#infoForm').ajaxForm({
        beforeSend: function() {
            $('#btnRegist').hide();
            $('#loading').show();
        },
        uploadProgress: function(event, position, total, percentComplete) {
            
        },
        complete: function(data) {              
            if($.trim(data.responseText)=='success'){               
                swal({   
                    title: "Thành công",   
                    text: "Hệ thống đã ghi nhận thông tin đặt vé, chúng tôi sẽ liên lạc với quý khách để xác nhận. Trân trọng cảm ơn.",   
                    type: "success",                      
                    confirmButtonText: "OK",  
                     closeOnConfirm: false }, 
                     function(){   
                        location.href="<?php echo $baseUrl; ?>";
                    });
                
            }else{    
                swal('Error','Có lỗi xảy ra!','error');                
                $('#btnRegist').show();
            }
        }
    });
});
</script>
