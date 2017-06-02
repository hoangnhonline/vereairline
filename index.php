<?php 
session_start();
date_default_timezone_set ('Asia/Saigon');
require_once 'routes.php';
require_once "models/Home.php";
$model = new Home;
$baseUrl = 'http://'.$_SERVER['SERVER_NAME'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">  
    <title><?php echo $seo['meta_title']; ?></title>    
    <base href="<?php echo $baseUrl; ?>">
    <meta name="description" content="<?php echo $seo['meta_description']; ?>">
    <meta name="keywords" content="<?php echo $seo['meta_keyword']; ?>">    
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">   
    <meta name="author" content="hoangnhonline@gmail.com">
    <meta name="geo.region" content="VN" />
    <meta name="geo.placename" content="Hồ Chí Minh" />
    <meta name="geo.position" content="10.765737;106.64713" />
    <meta name="ICBM" content="10.765737, 106.64713" />
    <meta name="DC.Title" content="Phòng vé máy bay online">
    <meta name="DC.Creator" content="hoangnhonline">
    <meta name="DC.Subject" content="Phòng vé máy bay online">
    <meta name="DC.Description" content="Phòng vé máy bay online. Xử lý vé chuyên nghiệp, phục vụ 24/24">   
<meta property="og:title" content="<?php echo $seo['meta_title']; ?>" />
	<meta property="og:description" content="<?php echo $seo['meta_description']; ?>">
<meta property="og:type" content="website" />
    <?php if($mod=='home'){ ?>	
	<meta property="og:url" content="http://boxlunch.vn/" />
	<meta property="og:image" content="http://boxlunch.vn/images/logoa.png">
	<?php } ?>
	<?php if($mod=='detail'){ ?>
	
	
	<meta property="og:url" content="<?php echo $baseUrl; ?><?php echo $_SERVER['REQUEST_URI']; ?>" />
	<meta property="og:image" content="<?php echo $baseUrl; ?>/<?php echo $data['image_url']; ?>">
	<?php } ?>
        <!--jquery-->
    <script src="libs/js/jquery.min.js"></script>
    <!--font Awesome-->    
    <!-- Latest compiled and minified CSS Bootstrap-->
    <link rel="stylesheet" href="libs/css/bootstrap.min.css">
    <link rel="stylesheet" href="libs/css/bootstrap-theme.min.css">
    <link href="libs/css/font-awesome.min.css" rel="stylesheet">
    <link href="libs/css/sweetalert.css" rel="stylesheet">   
    
    <script src="libs/js/bootstrap.min.js"></script>
    <script src="libs/js/ajaxForm.js"></script>
    <script src="libs/js/jquery.validate.js"></script>
    <script src="libs/js/sweetalert.min.js"></script>
    <script src="libs/js/jquery.lazyload.js"></script>
    

    <!--datetime-picker-->
    <script src="libs/css/datepicker/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="libs/css/datepicker/css/datepicker.css" type="text/css">

    <!--slider-->
    <link rel="stylesheet" href="libs/js/flexslider/flexslider.css" type="text/css">
    <script src="libs/js/flexslider/jquery.flexslider.js"></script>
    <script src="libs/js/dropdown.js"></script>    
    <link rel="stylesheet" type="text/css" href="libs/css/style.css?v=1">
    <link rel="stylesheet" type="text/css" href="libs/css/responsive.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>

    <!--
    <link rel="stylesheet" href="libs/css/jquery-ui-1.7.2.custom.css" type="text/css">
    <script rel="stylesheet" href="libs/js/jquery-ui-1.7.2.custom.min.js"></script>
    -->
    <script rel="stylesheet" href="libs/js/search_dialog.js"></script>
    <script rel="stylesheet" href="libs/js/booking.js"></script>
    <script rel="stylesheet" href="libs/js/scroll.js"></script>

	<link rel="stylesheet" href="libs/css/jquery-ui.css">
    <script src="libs/js/jquery-ui.js"></script>

    <script type="text/javascript" href="libs/js/snowfall.js"></script>

    <script src="libs/js/js.js" type="text/javascript"></script>    
</head>
<body class="<?php if($mod != "") echo "page"; ?>">
    <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=567408173358902";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <div class="container">
        <?php include "blocks/header.php"; ?>
        <?php if($mod == "") { ?>       
        <section id="content">
            <div class="row-fluid">
                <?php include "blocks/slider.php"; ?>
                <?php include "blocks/booking.php"; ?>                  
            </div>
        </section>

        <?php include "blocks/sticker.php"; ?>

        <section id="article">
            <div class="row-fluid">
                <div class="col-md-8">
                    <?php include "blocks/article-list.php"; ?> 
                    <?php include "blocks/support.php"; ?>
                                
          
                    <?php include "blocks/can-biet.php"; ?>                  
                    
                    <div class="row-fluid">
        		
                    </div>
                </div>
                <div class="col-md-4" id="article-bl3">
                    <div class="sidebar">       		
                         <?php include "blocks/service.php"; ?>
                        <?php include "blocks/info.php"; ?>  
                        <?php //include "blocks/news.php"; ?>                      
                                        
                        <?php include "blocks/fanpage.php"; ?>     

                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="banner-left col-md-12 visible-lg">
                    <img  src="libs/images/banner/img-partner.jpg"/>
                </div>
            </div>
        </section>
        <?php }else{ ?>
        <?php include "page/".$mod.".php"; ?>                  
        <?php } ?>        
	</div>
<?php include "blocks/footer.php"; ?>
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-53928005-8', 'auto');
  ga('send', 'pageview');

</script>
<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="//v2.zopim.com/?3JPGwOnOJAlvnJMkbKnXU1ltvWkCy7Ax";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zopim Live Chat Script-->
</body>
</html>
