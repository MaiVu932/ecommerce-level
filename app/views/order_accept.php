<?php 
include './header.php';
include '../Repositories/OrderRepository.php';


if(!isset($_SESSION['id'])) {
    echo '<script>alert("Bạn cần đăng nhập trước"); window.location="./user_login.php";</script>';
}

$order = new OrderRepository();
$oAccept = $order->getOrderAccept();

if(isset($_GET['status'])) {
    $order->updateOrderByStatus($_GET['status'], $_GET['id']);
    $str = ($_GET['status'] == 5) ? ' bị từ chối' : ' được duyệt';
    echo '<script>alert("Đơn hàng đã '.$str.'!"); window.location="./order_accept.php";</script>';
}
?>

<div class="container">
    
    <div class="content">
           
            <div><a href="./shop_create.php">Phê duyệt đơn hàng</a></div>
            <div><a href="./sale-revenue-shop_detail.php">doanh số/ doanh thu</a></div>
            <div class="search" style="margin-top: 20px;">
                <form method="POST">
                    <select name="status" id="">
                        
                    </select>
                </form>
                
            </div>

        <h1>Danh sách đơn hàng cần phê duyệt</h1>
        <table id="post">
            <tr>
                <th>STT</th>
                <th>Tên shop</th>
                <th>Sản phẩm</th>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Người nhận</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Xét duyệt</th>
                <th>Từ chối</th>
            </tr>
            <?php 
            $i = 0;
            foreach($oAccept as $value): 
            ?>
                <tr>
                    <td><?php echo $i + 1; $i++?></td>
                    <td><?php echo $value['nameS'] ?></td>
                    <td>
                        <img src= 
                            "<?php echo IMAGES . $value['code-category'] . '/' . $value['image'] ?>"  
                            alt="ảnh" width="100px" height ="100px"/>
                    </td>
                    <td><?php echo $value['nameP'] ?></td>
                    <td><?php echo $value['quantity'] ?></td>
                    <td><?php echo $value['nameU'] ?></td>
                    <td><?php echo $value['numPhoneU'] ?></td>
                    <td><?php echo $value['address'] ?></td>
                    <td>
                        <a href="./order_accept.php?status=2&id=<?php echo $value['id'] ?>">Duyệt</a>
                    </td>
                    <td>
                        <a href="./order_accept.php?status=5&id=<?php echo $value['id'] ?>">Từ chối</a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>
           
    </div>
</div>


<?php include './footer.php'; ?>