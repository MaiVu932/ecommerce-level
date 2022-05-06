<?php include ('header.php');?>
<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
    echo '<link rel="stylesheet" href="' . CSS . 'categorycreate.css" />';
?>
<?php
    include '../Repositories/CategoryRepository.php';
    $category = new CategoryRepository();

    $selects = $category->selectByCode_category($_GET['updateCode']);

    if(isset($_POST['update_cat']))
    {
        $update = $category->Update_category($_POST);
    }
?>

    <div class="cates">
        <h3 style="font-size: 30px; color:green">UPDATE CATEGORY</h3>

        <div class="addcate">
            <form action="<?php echo 'category_update.php?updateCode='.$_GET['updateCode'] ?>" method="POST" >
            <?php  foreach($selects as $select){ ?>
                <br><b>Code Category</b><br>
                <input class="tex" type="text" name ="tcode" value="<?php echo $select['code'] ?>" required/>
                <br><b>Name Category</b><br>
                <input class="tex" type="text" name ="tname" value="<?php echo $select['name'] ?>" required/>
                <br><b>Description</b><br>
                <textarea class="mta" name="tmota" required><?php echo $select['description'] ?></textarea><br>
                <input style="font-size: 20px;" class="sub" type="submit" name="update_cat"  value="Update"/>
            <?php  } ?>

            </form>

        </div>
    </div>

<?php include ('footer.php');?> 