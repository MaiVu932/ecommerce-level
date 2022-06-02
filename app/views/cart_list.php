<?php include './header.php';
    include '../Repositories/OrderRepository.php';

    $get_data = new OrderRepository();
    $info = $get_data->getProductsInCart();
    echo "<pre>";
    print_r($info);
    echo "</pre>";




    echo '<link href="' . CSS . 'listP.css" rel="stylesheet">';
?>
<div class="container col-lg-12 mx-auto">
    <div class="d-flex justify-content-start py-3">
        <ul class="nav nav-pills">
          <li class="nav-item"><a href="#" class="nav-link active" aria-current="page">Quản lý</a></li>
          <li class="nav-item"><a href="#" class="ProductList.php">Sản phẩm</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Bài viết</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Hóa đơn</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Doanh số/thu</a></li>

        </ul>
      </div>
    <div class="content">
    <h1>Danh sách sản phẩm trong giỏ hàng</h1>
    <div class="search" style="margin-top: 20px;">
                <form method="POST">
                
                    <input 
                        type="text" 
                        style="width: 20%; "
                        placeholder="  Tìm kiếm theo tên"
                        value="<?php echo isset($_POST['txt-search-name']) ? $_POST['txt-search-name'] : ''  ?>"
                        name="txt-search-name" />
                    
                    <select name="category" style="width: 20%; background-color: #fff; border: 1px solid black">
                        <option value="">Danh mục</option>
                        <?php foreach($categories as $value): ?>
                            <option <?php echo isset($_POST['category']) && $_POST['category'] == $value['id']  ? 'selected' : '' ?> value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                        <?php endforeach; ?>
                        
                    </select>

                    <select name="status" style="width: 20%; background-color: #fff; border: 1px solid black">
                        <option value="">Trạng thái</option>
                        <option <?php echo isset($_POST['status']) && $_POST['status'] == 6  ? 'selected' : '' ?> value="6">Đợi xét duyệt</option>
                        <option <?php echo isset($_POST['status']) && $_POST['status'] == 1  ? 'selected' : '' ?> value="1">Xét duyệt thành công</option>
                        <option <?php echo isset($_POST['status']) && $_POST['status'] == 2  ? 'selected' : '' ?> value="2">Xét duyệt thất bại</option>
                        <option <?php echo isset($_POST['status']) && $_POST['status'] == 3  ? 'selected' : '' ?> value="3">Trong kho</option>
                    </select>

                    <input
                        style="margin-top: 5px;"
                        type="submit" 
                        name="btn-search"
                        value="Tìm kiếm" />
                </form>
                
            </div>
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
                    <td><img src="<?php echo "ảnh" ?>" alt="anh"></td>
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