<?php 
    include('./header.php'); 

    include('../Repositories/ProductRepository.php');
    $get_data = new ProductRepository();
    $shops = $get_data->getShops();
    $categories = $get_data->getCategories();
    $product = $get_data->getInfoProductById($_GET['updateId']);
    echo "<pre>";
    print_r($product);
    print_r($shops);
    print_r($categories);
    echo "</pre>";
    
    // if(isset($_POST['sub-add'])) {

    //     $info = $get_data->createProducts($_POST);
    // }
    // var_dump('ok - ', $info);

    echo '<link href="' . CSS . 'createP.css" rel="stylesheet">';
    echo '<script src="' . JS . 'login.js" defer></script>';
?>
	<div class="content">
		<div id="about">
            <h1>Chỉnh sửa thông tin sản phẩm</h1>
            <form method="POST" enctype="multipart/form-data" id="HDpro">
            <label>Tên Shop</label>
                <select class="form-select" class="form-control" name="shop-name" disabled>
                    <option value="">-- Chọn shop --</option>
                    <?php foreach($shops as $shop){ ?>
                    <option <?php if($shop['id'] == $product['shop_id']){ echo "selected = \"selected\""; } ?> 
                            value="<?php echo $shop['id'] ?>"><?php echo $shop['name'] ?>
                    </option>
                    <?php } ?>
                </select>

                <label>Tên danh mục</label>
                <select class="form-select" class="form-control" name="category-name" disabled>
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach($categories as $category){ ?>
                        <option <?php if($category['id'] == $product['category_id']){ echo "selected = \"selected\""; } ?> 
                                value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?>
                        </option>
                    <?php } ?>
                </select>

                <label>Mã code sản phẩm</label>
                <input type="text" class="form-control" name="product-code" disabled 
                        value="<?php echo $product['code'] ?>" />

                <label>Tên sản phẩm</label>
                <input type="text" class="form-control" name="product-name" required
                    value="<?php echo $product['name'] ?>" />

                <label>Đơn vị tính</label>
                <input type="text" class="form-control" name="product-unit" required 
                    value="<?php echo $product['unit'] ?>"/>

                <label>Số lượng</label>
                <input type="number" class="form-control" name="product-quantity" required 
                    value="<?php echo $product['quantity'] ?>" />

                <label>Giá gốc</label>
                <input type="number" class="form-control" name="product-price" required 
                    value="<?php echo $product['unit'] ?>"/>

                <label>Giá bán</label>
                <input type="number" class="form-control" name="product-priceMarket" required />

                <label>Mô tả sản phẩm</label>
                <textarea style="width: 100%; height: 150px" name = "product-describe" required ></textarea> </br>

                <label>Upload Avatar</label>
                <input type="file" class="form-control" name="image" required>

                <input style="margin-top:25px" type="submit"name="sub-add" value="Thêm sản phẩm">
            </form>
		</div>
	</div>

<?php include('./footer.php') ?>