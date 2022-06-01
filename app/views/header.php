<?php
if(!isset($_SESSION)) {
    session_start();
}

 include 'define.php';
 include '../Repositories/BaseRepository.php';
 include '../Repositories/NotificationRepository.php';

 $notification = new NotificationRepository();
 $notification_count = count($notification->getNotificationsByUserId());


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
                                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 3): ?>
								    <li><a href="category_list.php"><i class="fa fa-star"></i> Categories</a></li>
								    <li><a href="user_list.php"><i class="fa fa-user"></i> Users</a></li>
                                <?php endif; ?>

                                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 2): ?>
								    <li><a href="category_list.php"><i class="fa fa-star"></i> Categories</a></li>
								    <li><a href="user_list.php"><i class="fa fa-user"></i> Users</a></li>
                                <?php endif; ?>

								<li><a href="cart.html"><i class="fa fa-shopping-cart"></i> Cart</a></li>
                                <?php if(isset($_SESSION['username'])): ?>
                                    <li><a href="notification.php"><i class="fa-solid fa-bell"></i>Notification(<b color="red"><?php echo $notification_count; ?></b>)</a></li>
                                    <li><a href="user_update.php"><i class="fa fa-user"></i><?php echo $_SESSION['username'] ?></a></li>
								    <li><a href="user_logout.php"><i class="fa fa-crosshairs"></i> Logout</a></li>
                                    <?php else: ?>
                                    <li><a href="user_login.php"><i class="fa fa-lock"></i> Login</a></li>
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
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="home.php" class="active">Home</a></li>
								<li class="dropdown"><a href="#">Shop<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 0): ?>
                                            <li><a href="shop_create.php">Create shop</a></li>
                                        <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
                                            <li><a href="shop_list.php">Shops</a></li>
                                            <!-- <li><a href="product-details.html">Product Details</a></li>  -->
                                            <!-- <li><a href="checkout.html">Checkout</a></li>  -->
                                        <?php else: ?>
                                        <?php endif; ?>
                                         
                                    </ul>
                                </li> 
								<li class="dropdown"><a href="#">Blog<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="blog.html">Blog List</a></li>
										<li><a href="blog-single.html">Blog Single</a></li>
                                    </ul>
                                </li> 
								<li><a href="404.html">404</a></li>
								<li><a href="contact-us.html">Contact</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="search_box pull-right">
							<input type="text" placeholder="Search"/>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
