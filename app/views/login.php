
<?php 
    include 'header.php';
    include '../Repositories/UserRepository.php';

    $user = new UserRepository();
    $info = null;
    $login = null;
    if(isset($_POST['sb-sign-up'])) {
        $info = $user->signUp($_POST);
    }

    if(isset($_POST['sbm-login'])) {
        $login = $user->signIn($_POST);
    }
    
    echo '<link rel="stylesheet" href="' . CSS . 'login.css" />';
    echo '<script src="' . JS . 'login.js" defer></script>'
?>



<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Login to your account</h2>
						<form method="POST">
							<input type="text" name="txt-num-phone" value="<?php
                                if(isset($info['num_phone'])) {
                                    echo $info['num_phone'];
                                }
                            ?>" placeholder="Phone number" oninput="validatePhone(this)" />
                            <div id="phone_error" class="error hidden">Phone number does not contain characters</div>
                            <div id="phone_error_len" class="error hidden">Phone number must not exceed 13 digits</div>



							<input type="password" name="password" value="<?php
                                if(isset($info['password_current'])) {
                                    echo $info['password_current'];
                                }
                            ?>" placeholder="Password" id="my_pw_login" />
                            <label onclick="hideShowPW(this)" id="pwSignIn" >Show Password</label>
                                <br>
							<span>
							<input type="checkbox" name="cbx-keep" class="checkbox"> 
								Keep me signed in
							</span>
							<button type="submit" class="btn btn-default" name="sbm-login">Login</button>
                            <?php if($login): ?>
                                <span style="color: red"><?php echo $login ?></span>
                            <?php else: ?>
                                <!-- <span style="color: green;">Login success !!</span> -->
                            <?php endif; ?>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>New User Signup!</h2>
						<form action="" method="POST" >
							<input type="text" name="txt-name" placeholder="Name" oninput="check(this)" required/>
                            <div id="name_error" class="error hidden">Name do not contain spaces</div>

							<input type="text" name="txt-num-phone" placeholder="Phone number" id="myform_phone" oninput="validatePhoneSignUp(this)" required/>
                            <div id="phone_error_signup" class="error hidden">Phone number does not contain characters</div>
                            <div id="phone_error_signup_len" class="error hidden">Phone number must not exceed 13 digits</div>


							<input type="text" name="txt-address" placeholder="Address" required/>
							
                            <input type="password" name="password" placeholder="Password" id="my_password" oninput="check(this)" required/>
                            <label onclick="hideShow(this)" id="pwSignUp">Show Password</label>
                            <div id="password_error" class="error hidden">Password do not contain spaces</div>
							
                            <button type="submit" name="sb-sign-up" class="btn btn-default">Signup</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->


<?php include 'footer.php' ?>