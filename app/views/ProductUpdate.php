<?php 
    include('./header.php'); 

    include('../Repositories/ProductRepository.php');
    $get_data = new ProductRepository();
    $shops = $get_data->getShops();
    $categories = $get_data->getCategories();
    $product = $get_data->getInfoProductById($_GET['updateId']);
    
    if(isset($_POST['sub-update'])) {
    var_dump($_POST);

        $get_data->updateProduct($_POST, $_GET['updateId']);
    }

    echo '<link href="' . CSS . 'createP.css" rel="stylesheet">';
    echo '<link href="' . CSS . 'updateP.css" rel="stylesheet">';
    echo '<script src="' . JS . 'login.js" defer></script>';
?>
	<div class="content">
		<div id="about">
            <h1>Cập nhật thông tin sản phẩm</h1>
            <form method="POST" enctype="multipart/form-data" id="HDpro">
            <label>Tên shop</label>
                <input type="text" name="shop-name" class="form-control" style ="display:none"
                    value="<?php echo $product['shop-id'] ?>" />

                <input type="text" class="form-control" disabled
                    value="<?php echo $product['shop-name'] ?>" />

            <label>Tên danh mục</label>
                <input type="text" name="category-name" class="form-control" style ="display:none"
                    value="<?php echo $product['category-id'] ?>" />

                <input type="text" class="form-control" disabled
                    value="<?php echo $product['category-name'] ?>" />
                
            <label>Mã sản phẩm</label>
                <input type="text" name="product-code" class="form-control" style ="display:none"
                    value="<?php echo $product['category-id'] ?>" />

                <input type="text" class="form-control" disabled 
                        value="<?php echo $product['code'] ?>" />

                <label>Tên sản phẩm</label>
                <input type="text" class="form-control" name="product-name" 
                    value="<?php echo $product['name'] ?>" />

                <label>Đơn vị tính </label>
                <input type="text" class="form-control" name="product-unit" required 
                    value="<?php echo $product['unit'] ?>"/>

                <label>Số lượng</label>
                <input type="number" class="form-control" name="product-quantity" required 
                    value="<?php echo $product['quantity'] ?>" />

                <label>Giá gốc</label>
                <input type="number" class="form-control" name="product-price" required 
                    value="<?php echo $product['price_historical'] ?>"/>

                <label>Giá bán</label>
                <input type="number" class="form-control" name="product-priceMarket" required 
                    value="<?php echo $product['price_market'] ?>"/>

                <label>Mô tả sản phẩm</label>
                <textarea style="width: 100%; height: 150px" name = "product-describe" required >
                     <?php echo $product['description'] ?>   
                </textarea> </br>

                <label>Hình ảnh sản phẩm</label>
                <img src="<?php echo IMAGES . $product['category-code'] . '/' . $product['image'] ?>"alt="avatar" width="200px" height="200px"> 
                <input 
                    type="file" 
                    class="form-control"  
                    accept="image/*" 
                    name="image" 
                    id="file"  
                    onchange="loadFile(event)"
                    style="display: none;">
                <label for="file" style="cursor: pointer;">Chọn ảnh mới</label>
                <img style="margin-top: 10px" id="output" width="200" height="200px" />

                <input style=" width: 15rem; height: 5rem;" type="submit"name="sub-update" value="Save">
                <input style=" width: 15rem; height: 5rem;" type="submit"name="sub-exit" value="Exit">

            </form>
		</div>
	</div>

    <script>
        var loadFile = function(event) {
	    var image = document.getElementById('output');
	    image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>

<?php include('./footer.php') ?>