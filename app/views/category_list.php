<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>Zerotype Website Template</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
    <style>
        .Vicate {
            border-collapse : collapse;
            width: 90%;
            margin: 0 auto;
            margin-top: 25px;
            margin-bottom: 25px;
        }
        .Vicate td, .Vicate th {
            padding: 8px;
        }
        .Vicate tr:ntn-child(event){
            background-color: #fff;
        }
        .lows2:hover{
            background-color: #ffffe0;
        }
        .lows1{
            background-color: grey;
            text-align: left;
            color: white;
        }
        .lows2{
            background-color: whitesmoke;
            text-align: left;
        }
        .but:hover{
            background-color: #32cd32;
        }
        b{
            margin-left: 40%;
        }
        .subC{
            margin-left: 48%;
            width: 5%;
            height: 25%;
            margin-top: 1%;
        }
        .subC:hover{
            background-color: #32cd32;
        }
    </style>
</head>

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

    $selects = $category->select_category();
?>

<div class="cates">
<<<<<<< HEAD

    <b style="font-size: 30px; color:green"> LIST CATEGORY </b><br>
    <a href="categorycreate.php"><input class="subC" type="submit" value="Create"></a>
=======
            
    <b style="font-size: 30px; color:green"> LIST CATEGORY </b><br>
    <a href="category_create.php"><input class="subC" type="submit" value="Create"></a>
>>>>>>> c1a0d5a03e8cf151577d005fdd20dc2048414a82
    <table class="Vicate">
        <tr class="lows1">
            <th>STT</th>
            <th>id</th>
            <th>code</th>
            <th>name</th>
            <th>description</th>
            <!-- <th>create</th> -->
            <th>update</th>
            <th>delete</th>
        </tr>
        <?php
            $i=1;
            foreach($selects as $select){
        ?>
        <tr class="lows2">
            <th><?php echo $i++ ?></th>
            <th><?php echo $select['id'] ?></th>
            <th><?php echo $select['code'] ?></th>
            <th><?php echo $select['name'] ?></th>
            <th><?php echo $select['description'] ?></th>
            <th><a href="category_update.php?updateCode=<?php echo $select['code'] ?>"><input class="but" type="submit" value="Update"></a></th>
<<<<<<< HEAD
            <th><a href="category_delete.php?deleteCode=<?php echo $select['code'] ?>" onclick="return confirm ('Bạn có chắc chắn muốn xóa không??')"><input class="but" type="submit" name="sub_Del" value="Delete"></a></th>
=======
            <th><a href="category_delete.php?deleteCode=<?php echo $select['code'] ?>" onclick="return confirm ('Bạn có chắc chắn muốn xóa không??')"><input class="but" type="submit" value="Delete"></a></th>
>>>>>>> c1a0d5a03e8cf151577d005fdd20dc2048414a82
        </tr>
        <?php  } ?>
    </table>

</div>


<?php include ('footer.php');?>
<<<<<<< HEAD
</html> 
=======
</html>
>>>>>>> c1a0d5a03e8cf151577d005fdd20dc2048414a82
