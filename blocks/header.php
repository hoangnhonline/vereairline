 <header>
    <div class="row-fluid" id="box-top">
        <div class="col-md-6" style="display: block">
            <h1 style="font-size: 12px; margin: 0;margin-top: 5px"><?php echo $arrText[1]; ?></h1>
        </div>
        <div class="col-md-6">
            <a href="#" class="search"><i class="fa fa-search"></i></a>
            <input type="text" placeholder="Tìm kiếm"/>
        </div>
    </div>
    <div id="box-header">                
        <div class="row-fluid">
            <?php $arr = $model->getListBannerByPosition(1,1); ?>
            <?php
              if(!empty($arr)){           
                  foreach($arr as $img){                    
                    
              ?>
            <a href="<?php echo $baseUrl; ?>"><img src="<?php echo $img['image_url']; ?>" alt="Phòng vé máy bay online" title="Phòng vé máy bay online"/></a>
            <?php } } ?>

        </div>            
    </div>
    <nav id="navbar" class="navbar navbar-default navbar-static" role="navigation">
        <div id="main-menu" class="container-fluid">
            <div class="navbar-header">
                <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-example-js-navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse bs-example-js-navbar-collapse">
                <ul class="nav navbar-nav">
                    <li  class="first"><a></a></li>
                    <li  class="active">
                        <a id="icon-home" href="/" class="dropdown-toggle"  aria-haspopup="true" aria-expanded="false">
                        </a>
                    </li>
                    <li >
                        <a href="<?php echo $baseUrl; ?>" id="liMenu_2" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">
                            Trang chủ
                        </a>
                            <!--<ul id="menu_2"></ul>-->
                    </li>
					<li >
                        <a href="gioi-thieu.html" id="liMenu_2" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">
                            Giới thiệu
                        </a>
                            <!--<ul id="menu_2"></ul>-->
                    </li>
                    <li >
                        <a href="ve-may-bay-noi-dia.html" id="liMenu_3" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">
                            Nội địa
                        </a>
                            <!--<ul id="menu_2"></ul>-->
                    </li>
                    <li >
                        <a href="ve-may-bay-quoc-te.html" id="liMenu_4" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">
                            Quốc tế
                        </a>
                            <!--<ul id="menu_2"></ul>-->
                    </li>
                    <li >
                        <a href="ve-may-bay-khuyen-mai.html" id="liMenu_5" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">
                            Tin khuyến mãi
                        </a>
                            <!--<ul id="menu_2"></ul>-->
                    </li>
                    <li >
                        <a href="yeu-cau-dat-ve.html" id="liMenu_5" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">
                            Đặt vé Tết
                        </a>
                            <!--<ul id="menu_2"></ul>-->
                    </li>
                    <li >
                        <a href="tuyen-dung.html" id="liMenu_7" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">
                            Tuyển dụng
                        </a>
                            <!--<ul id="menu_2"></ul>-->
                    </li> 
                    <li >
                        <a href="lien-he.html" id="liMenu_6" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">
                            Liên hệ
                        </a>
                            <!--<ul id="menu_2"></ul>-->
                    </li>
                               
                </ul>

                <div class="nav navbar-nav navbar-right">
                    <div class="box-follow">
                        <div><a href="#"><i class="fa fa-facebook"></i></a></div>
                        <div><a href="#"><i class="fa fa-twitter"></i></a></div>
                        <div><a href="#"><i class="fa fa-google-plus"></i></a></div>
                        <div><a href="#"><i class="fa fa-rss"></i></a></div>
                    </div>
                </div>
            </div><!-- /.nav-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header> 