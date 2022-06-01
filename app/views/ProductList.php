<?php include('./header.php');
    if(!(isset($_SESSION['role']) && $_SESSION['role'] == 1)) {
        echo '<script>alert("Bạn cần đăng nhập trước");
         window.location = "./user_login.php";  </script>';
    }

    include('../Repositories/ProductRepository.php');
    $get_data = new ProductRepository();
    $products = $get_data->getInfoProductByShopId();
    // var_dump($products);

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
    <h1>Danh sách sản phẩm</h1>
    <div class="search" style="margin-top: 20px;">
                <form method="POST">
                <select class="custom-select" id="inputGroupSelect01">
                    <option selected>Choose...</option>
                    <a href=""><option value="1">One</option></a>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
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
                        style="margin-top: 5px;"
                        type="submit" 
                        name="btn-search"
                        value="Tìm kiếm" />
                </form>
                
            </div>
            <table id="post">
            <a href="ProductCreate.php?id=<?php echo $_GET['id'] ?>"><button type="button" class="btn btn-primary">Thêm mới sản phẩm</button></a>
                <tr>
                    <th>STT</th>
                    <th>Ảnh sản phẩm</th>
                    <th>Tên shop</th>
                    <th>Tên danh mục</th>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Đơn vị tính</th>
                    <th>Số lượng</th>
                    <th>Đơn giá(Giá gốc)</th>
                    <th>Đơn giá(Giá bán)</th>
                    <th>Mô tả chi tiết sản phẩm</th>
                    <th>Lý do từ chối đăng bán</th>
                    <th>Đăng bán</th>
                    <th>Sửa</th>
                    <th>Xóa</abbr></th>
                </tr>
                <?php 
                    $i=1;
                    foreach($products as $product) { ?>
                <tr>
                    <th><?php echo $i++ ?></th>
                    <td>
                        <img src= 
                            "<?php echo IMAGES . $product['code-category'] . '/' . $product['image'] ?>"  
                            alt="ảnh" width="100px" height ="100px" />
                    </td>
                    <td><?php echo $product['name-shop'] ?></td>
                    <td><?php echo $product['name-category'] ?></td>
                    <td><?php echo $product['code'] ?></td>
                    <td><?php echo $product['name'] ?></td>
                    <td><?php echo $product['unit'] ?></td>
                    <td><?php echo $product['quantity'] ?></td>
                    <td><?php echo $product['price_historical'] ?></td>
                    <td><?php echo $product['price_market'] ?></td>
                    <td><?php echo $product['description'] ?></td>
                    <td><?php echo $product['reason_refusal'] ?></td>
                    <?php if($product['status'] == 1): ?>
                        <td><a onclick = "postProduct()">Đăng bán</a></td>
                    <?php else: ?>
                        <td><a href="ProductPost.php">Đăng bán</a></td>
                    <?php endif; ?>
                    
                    <th><a href="ProductUpdate.php?updateId=<?php echo $product['id'] ?>">Sửa</a></th>
                    
        

                    <?php if($product['status'] == 3): ?>
                        <th>
                            <a onclick="delete_confirm(<?php echo $product['id'] ?>)" >Xóa</a>
                        </th>
                    <?php else: ?>
                        <th>
                            <a>Xóa</a>
                        </th>
                    <?php endif; ?>


                </tr>
                <?php } ?>
            </table>
        <div style="margin: 20px 0px 0 20px;">
                <a href=""><button>Back to Manager</button></a>
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

<script>
    function delete_confirm(e) {
        if (confirm("Bạn có đồng ý xóa không") == true) {
            window.location = './ProductDelete.php?id=' + e;
        } else {
            console.log('k xoa');
        }
    }

    function postProduct(e){
        alert('Sản phẩm này đã đăng bán!!!');
    }

</script>

<?php include('./footer.php') ?>