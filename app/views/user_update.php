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
    <h1>Update</h1>
    <p>Enter username</p>
    <input 
        type="text" 
        name="txt-name" 
        class="name"
        value="<?php echo $info['name']  ?>" 
        placeholder="Name"
        oninput="validateName(this)" />
        <div
            id="name" 
            style="color: red;"
            class="error hidden">
            Names do not contain spaces
        </div>

    <p>Enter number phone</p>
    <input 
        type="text" 
        class="num"
        name="txt-num-phone" 
        value="<?php echo $info['num_phone']  ?>" 
        placeholder="Phone number"
        oninput="validatePhone(this)" />
        <div
            id="num" 
            style="color: red;"
            class="error hidden">
            Phone number does not contain characters
        </div>

    <p>Enter address</p>
    <input 
        type="text" 
        name="txt-address" 
        value="<?php echo $info['address']  ?>" 
        placeholder="Address" />

    <p>Enter password</p>
    <input 
        type="password" 
        class="password"
        id="pwi"
        name="password" 
        value="<?php echo $info['password_current']  ?>" 
        placeholder="Password"
        oninput="validatePassword(this)" />
        <label onclick="hideShow(this)" id="pw">Show Password</label>

        <div
            id="password" 
            style="color: red;"
            class="error hidden">
            Phone number does not contain characters
        </div>

    <input type="submit" id="sb" name="sb-update" value="Update" />
</form>

<?php
    else:
        echo '<script> alert("You need to login first !"); window.location="./user_login.php";</script>';
    endif;
?>

<?php include 'footer.php' ?>
