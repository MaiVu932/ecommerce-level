<?php include './header.php';
    include '../Repositories/OrderRepository.php';

    $get_data = new OrderRepository();
    $info = $get_data->getProductsInCart();
    




    echo '<link href="' . CSS . 'listP.css" rel="stylesheet">';
?>
<div class="container col-lg-12 mx-auto">

    <div class="content">
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
                <tr>
                    <td><input style="margin:auto;" type="checkbox"></td>
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
                <a href=""><button>Chọn tất cả</button></a>
                <a href=""><button>Đặt Hàng</button></a>
        </div>
    </div>
</div>
<div class="panel-footer"> 
    <div class="row"> 
        <div class="col col-xs-4">Trang 1 của 5 </div> 
            <div class="col col-xs-8"> 
                <ul class="pagination hidden-xs pull-right"> 
                    <li><a href="ProductList.php">1</a></li>

                    <li><a href="ProductList.php">2</a></li> 

                    <li><a href="ProductList.php">3</a></li>

                    <li><a href="ProductList.php">4</a></li>

                    <li><a href="ProductList.php">5</a></li> 
                </ul> 
                <ul class="pagination visible-xs pull-right"> 
                    <li><a href="ProductList.php">«</a></li>

                    <li><a href="ProductList.php">»</a></li> 
                </ul> 
            </div> 
        </div> 
    </div> 
</div>
<?php include('./footer.php') ?>