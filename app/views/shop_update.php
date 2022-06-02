<?php include 'header.php';
    include '../Repositories/ShopRepository.php';
    $shop = new ShopRepository();
    if(!isset($_GET['id'])) {
        echo '<script>window.location = "./shop_list.php?update=false"</script>';
        return;
    }

    if(!$shop->checkExist($_GET['id']) || empty($_GET['id'])) {
        echo '<script>window.location = "./shop_list.php?update=false"</script>';
    }
    
    if (isset($_POST['btn-shop-update'])) {
       $shop->updateByIdShop($_POST, $_GET['id']);
    }
    $shopInfo = $shop->getInfoShopById($_GET['id']);
?>

<link rel="stylesheet" href="<?php echo CSS . 'shop_create.css' ?>">

<?php if (isset($_SESSION['id'])):  ?>

<form action="" method="POST" >
    <h1>CẬP NHẬP THÔNG TIN SHOP</h1>
    <p>Nhập tên shop</p>
    <input 
        type="text" 
        name="txt-name" 
        value="<?php echo $shopInfo['name'] ?>"
        class="name"
        placeholder="Tên shop"
        required />
    
    <p>Nhập số điện thoại shop</p>
    <input 
        type="text" 
        name="txt-num-phone" 
        value="<?php echo $shopInfo['num_phone'] ?>"
        class="name"
        placeholder="Số điện thoại"
        required />

    <p>Nhập địa chỉ shop</p>
    <input 
        type="text" 
        name="txt-address" 
        value="<?php echo $shopInfo['address'] ?>"
        class="name"
        placeholder="Địa chỉ shop"
        required />

    <p>Nhập mô tả shop</p>
    <textarea 
        name="txt-description"
        placeholder="Mô tả shop" 
        rows="6" 
        required >
        <?php echo $shopInfo['description'] ?>
    </textarea>

    <input type="submit" id="sb" name="btn-shop-update" value="Cập nhập" />
    <a href="./shop_list.php"><<< Quay lại</a>
</form>



<?php
    else:
        echo '<script> alert("You need to login first !"); window.location="./user_login.php";</script>';
    endif;
?>


<?php include 'footer.php' ?>
