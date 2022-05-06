<?php include ('header.php');?>
<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
<<<<<<< HEAD
    echo '<link rel="stylesheet" href="' . CSS . 'categorycreate.css" />';
=======
    echo '<link rel="stylesheet" href="' . CSS . 'category_create.css" />';
>>>>>>> c1a0d5a03e8cf151577d005fdd20dc2048414a82
?>
<?php
    include '../Repositories/CategoryRepository.php';
    $category = new CategoryRepository();
<<<<<<< HEAD
    
$Delete =$category-> delete_category($_GET['deleteCode']);
if($Delete){
    header('location:category_list.php');
}
else{
    echo "not Finish";
}
?>
 
=======

    $selects = $category->selectByCode_category($code);
    // var_dump($selects);
?>

>>>>>>> c1a0d5a03e8cf151577d005fdd20dc2048414a82

<?php include ('footer.php');?>