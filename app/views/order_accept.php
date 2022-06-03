<?php 
include './header.php';

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
            foreach($shops as $value): 
            ?>
                <tr>
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


<?php include './footer.php'; ?>