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
<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
    echo '<link rel="stylesheet" href="' . CSS . 'category_create.css" />';
?>
<?php
    include '../Repositories/CategoryRepository.php';
    $category = new CategoryRepository();
    $selects = $category->selectByID_category($_GET['updateid']);

    // if(isset($_POST['update_cat']))
    // {
    //     // $update = $category->Update_category($_POST);
    // }
    if(isset($_POST['update_cat']))
    {
        $data = [
            'id'          => $_GET['updateid'],
            // 'code'        => $_POST['tcode'],
            'name'        => $_POST['tname'],
            'description' => $_POST['tmota'],
        ];
        // var_dump($data);
        

        $update = $category->Update_category($data);
    }
?>

    <div class="cates">
        <h3 style="font-size: 30px; color:#FE980F">Chỉnh Sửa Thông Tin Danh Mục</h3>

        <div class="addcate">
            <form action="<?php echo 'category_update.php?updateid='.$_GET['updateid'] ?>" method="POST" >
            <?php  foreach($selects as $select){ ?>
                <!-- <br><b>Code Category</b><br>
                <input class="tex" type="text" name ="tcode" value="<?php //echo $select['code'] ?>" disabled/> -->
                <br><b>Tên Danh Mục</b><br>
                <input class="tex" type="text" name ="tname" value="<?php echo $select['name'] ?>" required/>
                <br><b>Mô tả Danh Mục</b><br>
                <textarea class="mta" name="tmota" required><?php echo $select['description'] ?></textarea><br>
                <input style="font-size: 20px;" class="sub" type="submit" name="update_cat"  value="Lưu"/>
            <?php  } ?>

            </form>

        </div>
    </div>

<?php include ('footer.php');?> 
