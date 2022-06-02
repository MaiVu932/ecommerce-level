<?php 
    include('header.php');
    if(!(isset($_SESSION['role']) && $_SESSION['role'] == 1)) {
        echo '<script>alert("Bạn không có quyền xóa sản phẩm");
         window.location = "./home.php";  </script>';
    }
    include '../Repositories/ProductRepository.php';
     $get_data = new ProductRepository();
     $Delete =$get_data-> deleteProduct($_GET['id']);
    
?>