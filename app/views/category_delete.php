<?php include ('header.php');?>
<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
    echo '<link rel="stylesheet" href="' . CSS . 'categorycreate.css" />';
?>
<?php
    include '../Repositories/CategoryRepository.php';
    $category = new CategoryRepository();
    
    $Delete =$category-> delete_category($_GET['deleteid']);
    echo "<script>Swindow.location=('category_list.php')</script>";
    
    if($Delete){
        echo '
            <script>
                alert("Xoa danh muc thanh cong");
                window.location = ("category_list.php");
            </script>';
// if($Delete){
//    echo "<script>Swindow.location=('category_list.php')</script>";
    }
    else{
        echo "not Delete";
    }
?>
 

<?php include ('footer.php');?>