<?php include ('header.php');?>
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
            background-color: #FE980F; 
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
            background-color: #FE980F;
        }
    </style>
</head>


<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
    echo '<link rel="stylesheet" href="' . CSS . 'categorycreate.css" />';
?>
<?php
    include '../Repositories/CategoryRepository.php';
    $category = new CategoryRepository();
    $selects = $category->select_category();

    // $user = $category->select_userById($_SESSION['user_id']);
?>
<div class="cates">

    <b style="font-size: 30px; color: #FE980F"> LIST CATEGORY </b><br>
    <a href="category_create.php"><input class="subC" type="submit" value="Create"></a>
    <table class="Vicate">
        <tr class="lows1">
            <th>STT</th>
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
            <th><?php echo $select['code'] ?></th>
            <th><?php echo $select['name'] ?></th>
            <?php if (strlen($select['description']) >= 150): ?>
                <th><?php echo substr( $select['description'], 0, 150) . '...'; ?></th>
            <?php else: ?>
                <th><?php echo $select['description'] ?></th>
            <?php endif; ?>
            <th><a href="category_update.php?updateid=<?php echo $select['id'] ?>"><input class="but" type="submit" value="Update"></a></th>
            <th><a href="category_delete.php?deleteid=<?php echo $select['id'] ?>" onclick="return confirm ('Bạn có chắc chắn muốn xóa không??')"><input class="but" type="submit" name="sub_Del" value="Delete"></a></th>
        </tr>
        <?php  } ?>
    </table>

</div>


<?php include ('footer.php');?>
</html> 
