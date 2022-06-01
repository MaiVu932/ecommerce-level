<?php include('./header.php');
    if(!(isset($_SESSION['role']) && $_SESSION['role'] == 1)) {
        echo '<script>alert("Bạn cần đăng nhập trước");
         window.location = "./user_login.php";  </script>';
    }
?>
<?php include('./footer.php') ?>