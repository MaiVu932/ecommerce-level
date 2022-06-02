<?php
    include 'header.php';
    if (isset($_SESSION['id'])) :

    include '../Repositories/UserRepository.php';
    $user = new UserRepository();
    $info = $user->getInfoById((int)$_SESSION['id']);

    if(isset($_POST['sb-update'])) {
        $user->userUpdate(array_merge($_POST, ['id' => $info['id']]));
    }

echo '<link rel="stylesheet" href="' . CSS . 'user_update.css">';


?>9

<script src="<?php echo JS . 'user_update.js'; ?>" defer ></script>

<form action="" method="POST" >
    <h1>Cập nhật thông in người dùng</h1>
    <p>Nhập tên người ùng</p>
    <input 
        type="text" 
        name="txt-name" 
        class="name"
        value="<?php echo $info['name']  ?>" 
        placeholder="Tên người dùng"
        oninput="validateName(this)" />
        <div
            id="name" 
            style="color: red;"
            class="error hidden">
            Tên không chứa dấu cách
        </div>

    <p>Nhập số điện thoại</p>
    <input 
        type="text" 
        class="num"
        name="txt-num-phone" 
        value="<?php echo $info['num_phone']  ?>" 
        placeholder="Số điện thoại"
        oninput="validatePhone(this)" />
        <div
            id="num" 
            style="color: red;"
            class="error hidden">
            Số điện thoại không chứa dấu cách
        </div>

    <p>nhập địa chỉ</p>
    <input 
        type="text" 
        name="txt-address" 
        value="<?php echo $info['address']  ?>" 
        placeholder="Địa chỉ" />

    <p>NHập mật khẩu</p>
    <input 
        type="password" 
        class="password"
        id="pwi"
        name="password" 
        value="<?php echo $info['password_current']  ?>" 
        placeholder="Mật khẩu"
        oninput="validatePassword(this)" />
        <label onclick="hideShow(this)" id="pw">Hiển thị mật khẩu</label>

        <div
            id="password" 
            style="color: red;"
            class="error hidden">
            Mật khẩu không chứa dấu cách
        </div>

    <input type="submit" id="sb" name="sb-update" value="Lưu" />
</form>

<?php
    else:
        echo '<script> alert("Bạn cần đăng nhập trước tiên !!!"); window.location="./user_login.php";</script>';
    endif;
?>

<?php include 'footer.php' ?>
