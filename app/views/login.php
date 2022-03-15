<?php
include 'define.php';

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
    ?>

<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Login to your account</h2>
						<form action="#">
							<input type="text" placeholder="Name" />
							<input type="email" placeholder="Email Address" />
							<span>
								<input type="checkbox" class="checkbox"> 
								Keep me signed in
							</span>
							<button type="submit" class="btn btn-default">Login</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>New User Signup!</h2>
						<form action="#">
							<input type="text" placeholder="Name"/>
							<input type="email" placeholder="Email Address"/>
							<input type="password" placeholder="Password"/>
							<button type="submit" class="btn btn-default">Signup</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->