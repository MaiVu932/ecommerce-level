<?php 
    include('header.php');
    if(!(isset($_SESSION['role']) && $_SESSION['role'] == 1)) {
        echo '<script>alert("Bạn không có quyền đến trang này");
         window.location = "./home.php";  </script>';
    }
    include '../Repositories/ProductRepository.php';
     $get_data = new ProductRepository();
    //  echo "Bạn muốn xóa sản phẩm";
    //  return;
    
     $Delete =$get_data-> deleteProduct($_GET['id']);
     echo "<script>Swindow.location=('shop_list.php?id=" . $_GET['id'] ."';)</script>";
    // echo "<script>Swindow.location=('ProductList.php?id=" . $_GET['id'] ."';)</script>";

    
     if($Delete){
        echo "
             <script>
                 alert('Xoa sản phẩm thành công');
                 window.location = ('shop_list.php?id= " . $_GET['id'] ."');
           </script>";
 

    }
?>