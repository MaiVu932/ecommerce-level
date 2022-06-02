
<?php

    include 'header.php';
    include '../Repositories/ShopRepository.php';

    if(! isset($_SESSION['role'])) {
        echo '<script>alert("Bạn cần đăng nhập trước !!!"); window.location = "./user_login.php"; </script>';
    }

    
    $shop = new ShopRepository();
    
    $shops = $shop->getShopsByUserId();

    if(isset($_POST['btn-search'])) {
        // echo '<script>window.location = "./shop_list.php"</script>';
        $shops = $shop->getShopsByUserId(null,$_POST['txt-search-name'], $_POST['date-search'] );

    }
    $shop->validate();

    echo '<link href="' . CSS . 'shop_list.css" rel="stylesheet">';
    echo '<script src="' . JS . 'processDate.js" defer></script>';
    // echo '<script src="' . JS . 'process_table.js" defer></script>';

?>




<div class="container">
    
    <div class="content">
           
            <div><a href="./shop_create.php">Thêm mới shop</a></div>
            <div><a href="./sale-revenue-shop_detail.php">doanh số/ doanh thu</a></div>
            <div class="search" style="margin-top: 20px;">
                <form method="POST">
                    <input 
                        type="text" 
                        style="width: 20%; "
                        placeholder="  Tìm kiếm"
                        value="<?php echo isset($_POST['txt-search-name']) ? $_POST['txt-search-name'] : ''  ?>"
                        name="txt-search-name" />
                    <input 
                        type="text" 
                        name="date-search"
                        id="dateSearch"
                        value="<?php echo isset($_POST['date-search']) ? $_POST['date-search'] : ''  ?>"
                        style="width: 20%; outline: none;" 
                        placeholder="Thời gian tạo shop" >

                    <input 
                        type="submit" 
                        name="btn-search"
                        value="Tìm kiếm" />
                </form>
                
            </div>

        <h1>Danh sách shops</h1>
        <table id="post">
            <tr>
                <th>STT</th>
                <th>Tên shop</th>
                <th>Địa chỉ shop</th>
                <th>Số điện thoại shop</th>
                <th>Chủ shop</th>
                <th>Số điện thoại chủ shop</th>
                <th>Ngày tạo shop</th>
                <th>Sửa</th>
            </tr>
            <?php 
            $i = 0;
            foreach($shops as $value): 
            ?>
                <tr onclick="myFunction(<?php echo $value['id'] ?>)">
                    <td><?php echo $i + 1; $i++?></td>
                    <td><?php echo $value['nameS'] ?></td>
                    <td><?php echo $value['addressS'] ?></td>
                    <td><?php echo $value['numPhoneS'] ?></td>
                    <td><?php echo $value['nameU'] ?></td>
                    <td><?php echo $value['numPhoneU'] ?></td>
                    <td><?php echo $value['createS'] ?></td>
                    <td>
                        <a href="./shop_update.php?id=<?php echo $value['id'] ?>">Sửa</a>
                    </td>
                   
                </tr>
            <?php endforeach; ?>

        </table>
           
    </div>
</div>

<script>
    function myFunction(id) {
    // console.log(id);
    window.location = "./ProductList.php?id=" + id;
    

}
</script>



<?php include 'footer.php'?>