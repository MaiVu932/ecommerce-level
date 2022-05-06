<?php include ('header.php');?>
<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
    echo '<link rel="stylesheet" href="' . CSS . 'categorycreate.css" />';
?>
<?php
    include '../Repositories/CategoryRepository.php';
    $category = new CategoryRepository();
    
$Delete =$category-> delete_category($_GET['deleteCode']);
if($Delete){
    header('location:category_list.php');
}
else{
    echo "not Finish";
}
?>
 

<?php include ('footer.php');?>