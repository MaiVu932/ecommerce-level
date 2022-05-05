<?php
    include '../Repositories/UserRepository.php';
    include 'header.php';
    $user = new UserRepository();
    $info = $user->getInfoById((int)$_SESSION['id']);

    if(isset($_POST['sb-update'])) {
        $user->userUpdate(array_merge($_POST, ['id' => $info['id']]));
    }

echo '<link rel="stylesheet" href="' . CSS . 'user_update.css">';


?>

<form action="" method="POST" >
    <input type="text" name="txt-name" value="<?php echo $info['name']  ?>" placeholder="Name"/>
    <br>
    <input type="text" name="txt-num-phone" value="<?php echo $info['num_phone']  ?>" placeholder="Phone number" />
    <br>
    <input type="text" name="txt-address" value="<?php echo $info['address']  ?>" placeholder="Address" />
    <br>
    <input type="password" name="password" value="<?php echo $info['password_current']  ?>" placeholder="Password" />
    <br>
    <input type="submit" name="sb-update" value="Update" />
</form>



<?php include 'footer.php' ?>
