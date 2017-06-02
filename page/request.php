 <div class="row-fluid datvechitiet" id="article">
<div class="col-md-8 col-sm-12">    
        <ol class="breadcrumb">
            <li><a href="<?php echo $baseUrl; ?>">Trang chủ</a></li>
            <li>Yêu cầu đặt vé</li>
        </ol>
        <div class="ps-page-header">
            <div class="main-color block-title">
                Yêu cầu đặt vé
            </div>
            <div class="stripe-line"></div>
            <a class="rss" href="#"><i class="fa fa-rss"></i></a>
        </div>
        <div class="ps-page-content">            
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
                    <label for="phone">Điện thoại<span class="require">(*)</span></label>
                    <input type="text" class="form-control" id="phone" name="phone">
                  </div>
                  <div class="form-group">
                    <label for="email">Email<span class="require">(*)</span></label>
                    <input type="email" class="form-control" id="email" name="email">
                  </div>                                   
                  <input type="hidden" name="national_type" value="3"> 
                  <div class="form-group">
                    <label for="noi_di">Nơi đi<span class="require">(*)</span></label>
                    <input type="text" class="form-control" id="noi_di_ngoai" name="noi_di_ngoai">
                  </div>
                  <div class="form-group">
                    <label for="noi_den">Nơi đến<span class="require">(*)</span></label>
                    <input type="text" class="form-control" id="noi_den_ngoai" name="noi_den_ngoai">
                  </div>
                  <div class="form-group">
                    <label for="ngay_di">Ngày đi<span class="require">(*)</span></label>
                    <input type="text" class="form-control datepicker" id="depatureDate" name="depatureDate">
                  </div>
                  <div class="form-group">
                    <label for="ngay_ve">Ngày về<span class="require">(*)</span></label>
                    <input type="text" class="form-control datepicker" id="returnDate" name="returnDate">
                  </div>
                  <input type="hidden" name="request" value="1" />
                   
                  <div class="form-group">
                    <label for="others">Yêu cầu khác</label>
                    <textarea class="form-control" rows="5" id="notes" name="notes"></textarea>
                  </div>                  
                  <button type="submit" class="btn btn-primary btn-lag" id="btnRegist" name="btnRegist">GỬI YÊU CẦU</button>
                  <button type="reset" class="btn btn-default btn-lag" id="btnReset" name="btnReset">NHẬP LẠI</button>
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
            depatureDate: {
               required: true 
            },
            returnDate: {
               required: true 
            },
            noi_di_ngoai: {
               required: true 
            },
            noi_den_ngoai :{
               required: true 
            }
        }
    });
    $('#infoForm').ajaxForm({
        beforeSend: function() {
            $('#btnRegist, #btnReset').hide();
            $('#loading').show();
        },
        uploadProgress: function(event, position, total, percentComplete) {
            
        },
        complete: function(data) {              
            if($.trim(data.responseText)=='success'){               
                swal({   
                    title: "Thành công",   
                    text: "Hệ thống đã ghi nhận yêu cầu của quý khách, chúng tôi sẽ liên lạc với quý khách để xác nhận. Trân trọng cảm ơn.",   
                    type: "success",                      
                    confirmButtonText: "OK",  
                     closeOnConfirm: false }, 
                     function(){   
                        location.href="<?php echo $baseUrl; ?>";
                    });
                
            }else{    
                swal('Error','Có lỗi xảy ra!','error');
                $('#btnRegist, #btnReset').show();
                $('#btnReset').click();
            }
        }
    });
});
</script>