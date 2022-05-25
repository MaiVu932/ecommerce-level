<?php include 'header.php';
    if (isset($_POST['btn-shop-create'])) {
        var_dump($_POST);
    }
?>

<link rel="stylesheet" href="<?php echo CSS . 'shop_create.css' ?>">

<?php if (isset($_SESSION['id'])):  ?>

<form action="" method="POST" >
    <h1>CREATE SHOP</h1>
    <p>Enter name shop</p>
    <input 
        type="text" 
        name="txt-name" 
        class="name"
        placeholder="Name shop"
        required />
    
    <p>Enter number phone</p>
    <input 
        type="text" 
        name="txt-num-phone" 
        class="name"
        placeholder="Number phone shop"
        required />

    <p>Enter address shop</p>
    <input 
        type="text" 
        name="txt-address" 
        class="name"
        placeholder="Address shop"
        required />

    <p>Enter description</p>
    <textarea 
        placeholder="Description shop" 
        rows="6" 
        required >
    </textarea>

    <input type="submit" id="sb" name="btn-shop-create" value="Create" />
</form>

<?php
    else:
        echo '<script> alert("You need to login first !"); window.location="./user_login.php";</script>';
    endif;
?>


<?php include 'footer.php' ?>
