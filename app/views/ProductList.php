<?php include('./header.php');
    if(!(isset($_SESSION['role']) && $_SESSION['role'] == 1)) {
        echo '<script>alert("Bạn cần đăng nhập trước");
         window.location = "./ProductList.php";  </script>';
    }

    if(isset($_GET['id'])) {
        $_SESSION['shop_id'] = $_GET['id'];
    }
    

    include('../Repositories/ProductRepository.php');
    include '../Repositories/CategoryRepository.php';
    
    $category = new CategoryRepository();
    $categories = $category->select_category();


    $get_data = new ProductRepository();
    
    $products = $get_data->getInfoProductByShopId();

    if(isset($_POST['btn-search'])) {
        $products = $get_data->getInfoProductByShopId($_POST['txt-search-name'], $_POST['category'], $_POST['status']);
    }

    // var_dump($products);

    echo '<link href="' . CSS . 'listP.css" rel="stylesheet">';
?>
<div class="container col-lg-12 mx-auto">
    <div class="content">
    <h1>Danh sách sản phẩm</h1>
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
            <a href="ProductCreate.php?id=<?php echo isset($_GET['id']) ? $_GET['id'] : $_SESSION['shop_id'] ?>"><button type="button" class="btn btn-primary">Thêm mới sản phẩm</button></a>
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
                    <?php if(isset($_POST['status']) && $_POST['status'] == 3): ?>
                        <th>Đăng bán</th>
                    <?php endif; ?>
                    
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
                    
                    <?php if(isset($_POST['status']) && $_POST['status'] == 3): ?>
                        <th onclick="postProduct(<?php echo $product['id'] ?>)" >Đăng bán</th>
                    <?php endif; ?>
                    
                    <th><a href="ProductUpdate.php?updateId=<?php echo $product['id'] ?>">Sửa</a></th>
                    
        

                    <?php if($product['status'] == 3 || strlen($product['reason_refusal']) > 0): ?>
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
                <a href="./shop_list.php"><button>Quay lại shop</button></a>
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

    function postProduct(id){
        window.location = "./ProductPost.php?idP=" + id;
    }

</script>

<?php include('./footer.php') ?>