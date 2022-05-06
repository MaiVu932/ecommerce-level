<?php include ('header.php');
?>
<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
    echo '<link rel="stylesheet" href="' . CSS . 'category_create.css" />';
?>

<?php
   include '../Repositories/CategoryRepository.php';
   $category = new CategoryRepository();
   if(isset($_POST['sub']))
   {
       $category ->Insert_category($_POST);
   }
?>

    <div class="cates">
        <h3 style="font-size: 30px; color:green">CREAT CATEGORY</h3>
        
        <div class="addcate">
            <form method="POST" >
                <br><b>Code Category</b><br>
                <input class="tex" type="text" name ="tcode" placeholder="Code Category" required/>
                <br><b>Name Category</b><br>
                <input class="tex" type="text" name ="tname" placeholder="Name Category" required/>
                <br><b>Description</b><br>
                <textarea class="mta" name="tmota" required></textarea><br>
                <input style="font-size: 20px;" class="sub" type="submit" name="sub" value="Creat"/> 
            </form>
            
        </div>
    </div>

<?php include ('footer.php');?>