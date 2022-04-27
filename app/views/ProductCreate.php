<?php 
    include('./header.php'); 

    include('../Repositories/ProductRepository.php');
    $get_data = new ProductRepository();
    $shops = $get_data->getShops();
    $categories = $get_data->getCategories();
    $info = null;
    if(isset($_POST['sub-add'])) {

        $info = $get_data->createProducts($_POST);
    }
    var_dump('ok - ', $info);

    echo '<link href="' . CSS . 'createP.css" rel="stylesheet">';
?>
	<div class="content">
		<div id="about">
            <h1>Thêm mới sản phẩm</h1>
            <form method="POST" enctype="multipart/form-data" id="HDpro">
            <label>Tên Shop</label>
                <select class="form-select" class="form-control" name="shop-name" required>
                    <option value="">-- Chọn shop --</option>
                    <?php foreach($shops as $shop){ ?>
                    <option value="<?php echo $shop['id'] ?>"><?php echo $shop['name'] ?></option>
                    <?php } ?>
                </select>

                <label>Tên danh mục</label>
                <select class="form-select" class="form-control" name="category-name" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach($categories as $category){ ?>
                    <option value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                    <?php } ?>
                </select>

                <label>Mã code sản phẩm</label>
                <input type="text" class="form-control" name="product-code" required />

                <label>Tên sản phẩm</label>
                <input type="text" class="form-control" name="product-name" required />

                <label>Đơn vị tính</label>
                <input type="text" class="form-control" name="product-unit" required />

                <label>Số lượng</label>
                <input type="number" class="form-control" name="product-quantity" required />

                <label>Giá gốc</label>
                <input type="number" class="form-control" name="product-price" required />

                <label>Giá bán</label>
                <input type="number" class="form-control" name="product-priceMarket" required />

                <label>Mô tả sản phẩm</label>
                <textarea style="width: 100%; height: 150px" name = "product-describe"></textarea> </br>

                <label>Upload Avatar</label>
                <input type="file" class="form-control" name="image" required>

                <input style="margin-top:25px" type="submit"name="sub-add" value="Thêm sản phẩm">
            </form>
		</div>
	</div>

<?php include('./footer.php') ?>