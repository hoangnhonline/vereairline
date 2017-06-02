 <div class="contact">
    <div class="row-fluid" id="article">

        <div class="col-md-12 full-width pd-15">
            <ol class="breadcrumb">
                <li><a href="#">Trang chủ</a></li>
                <li>Liên hệ</li>
            </ol>            
        </div>
        <div class="row-fluid full-width">
            <div class="col-md-8">

                <div class="ps-page-header">
                    <div class="main-color block-title">
                         <?php echo $arrText[29]; ?>
                    </div>
                    <div class="stripe-line"></div>

                </div>
                <form name="myform" action="" method="post">
                <div class="contact-form">
                    <div class="row">
                        <div class="col-md-6"><input name="txt_ho_ten" id="txt_ho_ten" type="text" placeholder="Tên"> </div>
                        <div class="col-md-6"><input equired="" oninput="check_valid_input(this,'email');" oninvalid="check_valid_input(this,'email');" type="email" name="txt_email" id="txt_email" placeholder="Emai"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><input required="" oninput="check_valid_input(this,'tieu_de');" oninvalid="check_valid_input(this,'tieu_de');" type="text" name="txt_tieu_de" id="txt_tieu_de" placeholder="Chủ đề"> </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <textarea name="txt_noi_dung" id="txt_noi_dung" placeholder="Tin nhắn">
                            </textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" href="#" name="bt_gui" title="Gửi" onclick="return kiem_tra_email()" class="btn-send-contact">Gửi !</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="col-md-4">


                <div class="main-color block-title">
                    <?php echo $arrText[30]; ?>
                </div>    <div class="stripe-line"></div>

                <div class="block-article infomation">
                    <div id="infomation">
                        <p><i class="fa fa-phone"></i> <?php echo $arrText[20]; ?></p>
                        <p><i class="fa fa-envelope"></i> <a href="mailto:<?php echo $arrText[21]; ?>"><?php echo $arrText[31]; ?></a></p>
                        <p><i class="fa fa-globe"></i> vereairline.com</p>
                        <p><i class="fa fa-clock-o"></i> 24/24</p>
                        <p><i class="fa fa-map-marker"></i> <?php echo $arrText[21]; ?></p>
                    </div>
                </div>               

            </div>
        </div>

    </div>
</div>