<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="<?php echo STATIC_URL; ?>img/avatar3.png" class="img-circle" alt="User Image" />
        </div>
        <div class="pull-left info">
            <p>Hello, <?php echo $_SESSION['full_name']; ?></p>  
        </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search..."/>
            <span class="input-group-btn">
                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        
        <li class="active">            
            <a href="<?php echo BASE_URL; ?>cate_articles&act=list">
                <i class="fa fa-th"></i> <span>Danh mục</span>
            </a>
        </li>         
        <li class="active">
            <a href="<?php echo BASE_URL; ?>articles&act=list">
                <i class="fa fa-th"></i> <span>Bài viết</span>
            </a>
        </li>          
        <li>
            <a href="<?php echo BASE_URL; ?>book&act=list">
                <i class="fa fa-th"></i> <span>Đặt vé</span> <!--<small class="badge pull-right bg-green">new</small>-->            </a>
        </li>                
         <li>
            <a href="<?php echo BASE_URL; ?>page&act=list">
                <i class="fa fa-th"></i> <span>Trang nội dung</span> <!--<small class="badge pull-right bg-green">new</small>-->
            </a>
        </li> 
         <li>
            <a href="<?php echo BASE_URL; ?>contact&act=list">
                <i class="fa fa-th"></i> <span>Khách hàng liên hệ</span> <!--<small class="badge pull-right bg-green">new</small>-->
            </a>
        </li>   
        <li>
            <a href="<?php echo BASE_URL; ?>banner&act=index">
                <i class="fa fa-th"></i> <span>Banner</span> <!--<small class="badge pull-right bg-green">new</small>-->
            </a>
        </li>               
        <li>
            <a href="<?php echo BASE_URL; ?>text&act=list">
                <i class="fa fa-th"></i> <span>Text</span> <!--<small class="badge pull-right bg-green">new</small>-->
            </a>
        </li>
        <li>
            <a href="<?php echo BASE_URL; ?>seo&act=list">
                <i class="fa fa-th"></i> <span>SEO</span> <!--<small class="badge pull-right bg-green">new</small>-->
            </a>
        </li>
    </ul>
</section>
<!-- /.sidebar -->