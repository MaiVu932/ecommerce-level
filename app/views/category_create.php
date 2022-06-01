<?php include ('header.php');?>

<?php 

    if(!isset($_SESSION['permission']) ){
	    echo "Bạn chưa đăng nhập  <br>" ;
	    echo "<a href='user_login.php' > Dăng nhập</a>;  ";
	    die();
    }
    // else if(isset($_SESSION['permission']) !=3 ){
    if(isset($_SESSION['permission']) && ($_SESSION['permission'] !=3)){
        echo "Bạn ko có quyền đăng nhập đăng nhập  <br>";
        echo "<a href='category_list.php' > Quay lại</a>;  ";
	    die();
    }
    else{
        echo "<script>
               window.location = ('category_update.php');
            </script>";
            die();
    }
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
                <br><b>Code Category</b><br>
                <input class="tex" type="text" name ="tcode" placeholder="Code" required/>
                <br><b>Name Category</b><br>
                <input class="tex" type="text" name ="tname" placeholder="Name" required/>
                <br><b>Description</b><br>
                <textarea class="mta" name="tmota" required></textarea><br>
                <input style="font-size: 20px;" class="sub" type="submit" name="sub" value="Creat"/> 
            </form>
            
        </div>
    </div>

<?php include ('footer.php');?>