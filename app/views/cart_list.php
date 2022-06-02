<?php include './header.php';
    include '../Repositories/OrderRepository.php';

if(!isset($_SESSION['id'])) {
    echo '<script>alert("Bạn cần đăng nhập trước"); window.location="./home.php"</script>';
}

    $get_data = new OrderRepository();
    $info = $get_data->getProductsInCart();

    global $state, $data;
    $state = false;
    
    if(isset($_POST['btn-selected-all'])) {
        $state = true;
    }

    if(isset($_POST['btn-buy'])) {
        if(!isset($_POST['select'])) echo '<script>alert("Bạn cần chọn sản phẩm trước khi đắt hàng")</script>';
        else {
            $_SESSION['selects'] = $_POST['select'];
            $get_data->orderBuyListProducts($_POST['select']);
        }
    }




    echo '<link href="' . CSS . 'listP.css" rel="stylesheet">';
?>
<div class="container col-lg-12 mx-auto">

    <div class="content">
        <form method="POST">
        <h1>Danh sách sản phẩm trong giỏ hàng</h1>
    
    <table id="post">
        <tr>
            <th>Chọn</th>
            <th>STT</th>
            <th>Ảnh sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Đơn giá</th>
            <th>Số lượng</th>
            <th>Tổng tiền</th>
            <th>Remove</th>
            
        </tr>
        <?php 
            $i =1;
            foreach($info as $value){ 
            ?>
        <tr onclick="mySelect(this)">
            <td><input <?php 
             echo $state ? 'checked' : ''; ?> style="margin:auto;" type="checkbox" value="<?php echo $value['id'] ?>" name="select[]"></td>
            <td><?php echo $i++ ?></td>
            <td>
                <img src="<?php echo IMAGES . $value['code'] . '/' . $value['image'] ?>" 
                    width="100px" height="100px"
                    alt="anh" />
            </td>
            <td><?php echo $value['name'] ?></td>
            <td><?php echo $value['price_market'] ?></td>
            <td><?php echo $value['quantity'] ?></td>
            <td><?php echo $total = ($value['price_market']) * ($value['quantity']) ?></td>
            <td><a href="">Xóa</a></td>
        </tr>
        <?php } ?>
        
    </table>
<div style="margin: 20px 0px 0 20px;">
        <a href=""><button type="submit" name="btn-selected-all">Chọn tất cả</button></a>
        <a href=""><button type="submit" name="btn-update" onclick="myFunc()">Cập nhập giỏ hàng</button></a>
        <a href=""><button type="submit" name="btn-buy">Đặt Hàng</button></a>
</div>
</div>
        </form>
    
    </div>
<div class="panel-footer"> 

<script>
    function myFunc() {
        alert("Chức năng đang phát triển");
    }

    function mySelect(e) {
        console.log(e);
    }

    function changeQuantity(e) {
        e.setAttribute('value', e.value)
    }
</script>
    
</div>
<?php include('./footer.php') ?>