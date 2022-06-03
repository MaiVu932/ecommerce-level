<?php
if(!isset($_SESSION)) {
    session_start();
}

 include 'define.php';
 include '../Repositories/BaseRepository.php';
 include '../Repositories/NotificationRepository.php';
 $notification = new NotificationRepository();
 if(isset($_SESSION['role'])) {
    $notification_count = count($notification->getNotificationsByUserId());
 }


 


 echo '<link href="' . CSS . 'bootstrap.min.css" rel="stylesheet">
 <link href="' . CSS . 'font-awesome.min.css" rel="stylesheet">
 <link href="' . CSS . 'prettyPhoto.css" rel="stylesheet">
 <link href="' . CSS . 'price-range.css" rel="stylesheet">
 <link href="' . CSS . 'animate.css" rel="stylesheet">
 <link href="' . CSS . 'main.css" rel="stylesheet">
 <link href="' . CSS . 'responsive.css" rel="stylesheet">';

 echo '<link rel="shortcut icon" href="' . IMAGES . 'ico/favicon.ico">
 <link rel="apple-touch-icon-precomposed" sizes="144x144" href="' . IMAGES . 'ico/apple-touch-icon-144-precomposed.png">
 <link rel="apple-touch-icon-precomposed" sizes="114x114" href="' . IMAGES . 'ico/apple-touch-icon-114-precomposed.png">
 <link rel="apple-touch-icon-precomposed" sizes="72x72" href="' . IMAGES . 'ico/apple-touch-icon-72-precomposed.png">
 <link rel="apple-touch-icon-precomposed" href="' . IMAGES . 'ico/apple-touch-icon-57-precomposed.png">';

 echo '<script src="' . JS . 'jquery.js" defer></script>
 <script src="' . JS . 'bootstrap.min.js" defer></script>
 <script src="' . JS . 'jquery.scrollUp.min.js" defer></script>
 <script src="' . JS . 'price-range.js" defer></script>
 <script src="' . JS . 'jquery.prettyPhoto.js" defer></script>
 <script src="' . JS . 'main.js" defer></script>';
 echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>';
    
    
    ?>

<script src="https://kit.fontawesome.com/b93925de5c.js" crossorigin="anonymous"></script>
<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> 0985 944 691</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> woala932@gmail.com </a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-md-4 clearfix">
						<div class="logo pull-left">
							<a href="home.php"><img src="images/home/logo.png" alt="" /></a>
						</div>
						<div class="btn-group pull-right clearfix">
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									USA
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="">Canada</a></li>
									<li><a href="">UK</a></li>
								</ul>
							</div>
							
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									DOLLAR
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="">Canadian Dollar</a></li>
									<li><a href="">Pound</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-8 clearfix">
						<div class="shop-menu clearfix pull-right">
							<ul class="nav navbar-nav">
								<li><a href="cart_list.php"><i class="fa fa-shopping-cart"></i>Giỏ Hàng</a></li>
                                <?php if(isset($_SESSION['username'])): ?>
                                    <li><a href="notification.php"><i class="fa-solid fa-bell"></i>Thông Báo<?php echo isset($_SESSION['role']) ? "(" . $notification_count . ")" : ''; ?></a></li>
                                    <li><a href="user_update.php"><i class="fa fa-user"></i><?php echo $_SESSION['username'] ?></a></li>
								    <li><a href="user_logout.php"><i class="fa fa-crosshairs"></i>Đăng Xuất</a></li>
                                    <?php else: ?>
                                    <li><a href="user_login.php"><i class="fa fa-lock"></i>Đăng Nhập</a></li>
                                <?php endif; ?>
								
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
                            <?php if(isset($_SESSION['role']) && ($_SESSION['role'] == 2 || $_SESSION['role'] == 3 ) ):  ?>
                                <ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="home.php" class="active">Trang Chủ</a></li>
								<li class="dropdown"><a href="#">Shop<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 0): ?>
                                            <li><a href="shop_create.php">Tạo shop</a></li>
                                        <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
                                            <li><a href="shop_list.php">Shops</a></li>
                                        <?php else: ?>
                                        <?php endif; ?>
                                         
                                    </ul>
                                </li> 
                                <li class="dropdown"><a href="#">Xét duyệt<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                            <li><a href="./ProductCensorship.php">Đăng bán sản phẩm</a></li>
                                            <li><a href="./complain_list.php">Khiếu nại</a></li>
                                    </ul>
                                </li> 
                                <li class="dropdown"><a href="#">Thống kê<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                            <li><a href="./sale-revenue-exchange.php">Doanh số/doanh thu</a></li>
                                            <li><a href="./category_list.php">Danh mục sản phẩm</a></li>
                                            <li><a href="./user_list.php">Danh sách người dùng</a></li>

                                    </ul>
                                </li>
                                
								
							</ul>
                            <?php endif; ?>

                            <?php if(isset($_SESSION['role']) && ($_SESSION['role'] == 0) ):  ?>
                                <ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="home.php" class="active">Trang Chủ</a></li>
								<li class="dropdown"><a href="./shop_create.php">Tạo shop<i class="fa fa-angle-down"></i></a></li>         
								
							</ul>
                            <?php endif; ?>
                            <?php if(isset($_SESSION['role']) && ($_SESSION['role'] == 1) ):  ?>
                                <ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="home.php" class="active">Trang Chủ</a></li>
								<li class="dropdown"><a href="./shop_list.php">Danh sách cửa hàng<i class="fa fa-angle-down"></i></a></li>         
								
							</ul>
                            <?php endif; ?>


							
						</div>
					</div>
					<div class="col-sm-3">
						
							<form method="POST">

                                <input type="text" name="txt-search" placeholder="Tìm Kiếm"/>
                                <input type="submit" name="btn-search" value="Tìm kiếm" >
                            </form>
						
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
