<?php include ('header.php');?>

<?php 

    if(!isset($_SESSION['role']) ){
        echo "<script>
                alert('Bạn chưa đăng nhập');
                window.location = ('user_login.php');
            </script>";
            die();
    }
    else if(isset($_SESSION['role']) && ($_SESSION['role'] !=3) && ($_SESSION['role'] !=2)){
        echo "<script>
                alert('Bạn không có quyền truy cập trang này');
                window.location = ('home.php');
            </script>";
            die();
    }
    // else{
    //     echo "<script>
    //            window.location = ('category_create.php');
    //         </script>";
    //         die();
    // }
?>
<?php
    echo '<link rel="stylesheet" href="' . CSS . 'category_create.css" />';
?>
<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
   include '../Repositories/CategoryRepository.php';
   $category = new CategoryRepository();
   if(isset($_POST['sub']))
   {
       $category ->Insert_category($_POST);
   }
?>

    <div class="cates">
        <h3 style="font-size: 30px; color:#FE980F">CREAT CATEGORY</h3>
        
        <div class="addcate">
            <form method="POST" >
                <br><b>Tên Danh Mục</b><br>
                <input class="tex" type="text" name ="tcode" placeholder="Mã code" required/>
                <br><b>Tên Danh Mục</b><br>
                <input class="tex" type="text" name ="tname" placeholder="Tên danh mục" required/>
                <br><b>Mô tả Danh Mục</b><br>
                <textarea class="mta" name="tmota" required></textarea><br>
                <input style="font-size: 20px;" class="sub" type="submit" name="sub" value="Thêm mới"/> 
            </form>
            
        </div>
    </div>

<?php include ('footer.php');?>