
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
        if ($login) {
            echo '<script> alert("Đăng nhập thành công !"); window.location="./home.php?login=true";</script>';
        }
    }
    
    echo '<link rel="stylesheet" href="' . CSS . 'login.css" />';
    echo '<script src="' . JS . 'login.js" defer></script>';
?>


<!-- login -->
<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Đăng nhập tài khoản của bạn</h2>
						<form method="POST">
							<input 
                                type="text" 
                                name="txt-num-phone" 
                                value="<?php
                                    if(isset($info['num_phone'])) {
                                        echo $info['num_phone'];
                                    }
                                ?>" 
                                placeholder="Số điện thoại/Địa chỉ email"
                                class="sign-in"
                                 />

                            <div
                                id="sign-in" 
                                 class="error hidden">
                                 Số điện thoại không chứa dấu cách
                            </div>



							<input type="password" name="password" value="<?php
                                if(isset($info['password_current'])) {
                                    echo $info['password_current'];
                                }
                            ?>" placeholder="Mật khẩu" id="my_pw_login" />
                            <label onclick="hideShowPW(this)" id="pwSignIn" >Hiển thị mật khẩu</label>
                                <br>
							<span>
							<button 
                                type="submit" 
                                id="sb-login"
                                name="sbm-login">
                                Đăng nhập
                            </button>
                            
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">HOẶC</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>Đăng ký tài khoản mới!</h2>
						<form action="" method="POST" >
							<input 
                                type="text" 
                                name="txt-name" 
                                placeholder="Tên tài khoản" 
                                required
                                oninput="check(this)" />
                            <div id="name_error" class="error hidden">Tên tài khoản không chứa dấu cách</div>

							<input 
                                type="text" 
                                name="txt-num-phone" 
                                placeholder="Số điện thoại" 
                                id="myform_phone"
                                class="sign-up" 
                                required
                                oninput="validatePhone(this)" />
                                
                            <div 
                                id="sign-up" 
                                class="error hidden">
                                Số điên thoại không chứa dấu cách
                            </div>
                            <div id="phone_error_signup_len" class="error hidden">Số điện thoại chỉ chứa 10 số</div>


							<input type="text" name="txt-address" placeholder="Địa Chỉ" required/>
							
                            <input 
                                type="password" 
                                name="password" 
                                placeholder="Mật khẩu" 
                                id="my_password" 
                                oninput="check(this)" required/>
                            <label onclick="hideShow(this)" id="pwSignUp">Hiển thị mật khẩu</label>
                            <div id="password_error" class="error hidden">Mật khẩu không chứa dấu cách</div>
							
                            <button 
                                type="submit" 
                                id="sb-sign-up"
                                c
                                name="sb-sign-up" >
                                Đăng Ký
                            </button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->


<?php include 'footer.php' ?>