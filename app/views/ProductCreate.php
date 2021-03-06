<?php 
    include('./header.php'); 
    if(!(isset($_SESSION['role']) && $_SESSION['role'] == 1)) {
        echo '<script>alert("Bạn cần đăng nhập trước");
         window.location = "./user_login.php";  </script>';
    }
    include('../Repositories/ProductRepository.php');
    $get_data = new ProductRepository();
    $shop = $get_data->getShopByUserId($_GET['id']);
    // echo "<pre>";
    // print_r($shop);
    // echo "</pre>";
    $categories = $get_data->getCategories();
    $info = null;
    if(isset($_POST['sub-add'])) {

        $info = $get_data->createProducts($_POST);
    }
    // var_dump('ok - ', $info);

    echo '<link href="' . CSS . 'createP.css" rel="stylesheet">';
    echo '<script src="' . JS . 'login.js" defer></script>';

?>

	<div class="content">
		<div id="about">
            <h1>Thêm mới sản phẩm</h1>
            <form method="POST" enctype="multipart/form-data" id="HDpro">
            <label>Tên shop</label>
                <input type="text" name="shop-name" class="form-control" style ="display:none"
                    value="<?php echo $shop['id'] ?>" required />
                <input type="text" class="form-control" value="<?php echo $shop['name'] ?>" disabled /> 

                <label>Tên danh mục</label>
                <select class="form-select" class="form-control" name="category-name" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach($categories as $category){ ?>
                    <option value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                    <?php } ?>
                </select>

                <label>Mã sản phẩm</label>
                <input type="text" class="form-control" name="product-code" required />

                <label>Tên sản phẩm</label>
                <input type="text" class="form-control" name="product-name" required />

                <label>Đơn vị tính</label>
                <select class="form-select" class="form-control" name="product-unit" required>
                    <option value="">-- Chọn đơn vị tính --</option>
                    <option value="Chiếc">Chiếc</option>
                    <option value="Quyển">Quyển</option>
                    <option value="Hộp">Hộp</option>
                    <option value="Bộ">Bộ</option>
                    <option value="Cái">Cái</option>
                    <option value="Túi">Túi</option>
                    <option value="lọ">lọ</option>
                    <option value="Chai">Chai</option>
                </select>

                <label>Số lượng</label>
                <input type="number" class="form-control" name="product-quantity" required />

                <label>Giá gốc</label>
                <input type="number" class="form-control" name="product-price" required />

                <label>Giá bán</label>
                <input type="number" class="form-control" name="product-priceMarket" required />

                <label>Mô tả sản phẩm</label>
                <textarea style="width: 100%; height: 150px" name = "product-describe" required ></textarea> </br>

                <input 
                    type="file" 
                    class="form-control"  
                    accept="image/*" 
                    name="image" 
                    id="file"  
                    onchange="loadFile(event)" 
                    style="display: none;">
                <label for="file" style="cursor: pointer;">Hình ảnh sản phẩm</label>
                <img style="margin-top: 10px" id="output" width="250" height="250px" />

                
                <input style="margin:2rem 30rem 1rem 30rem ; width: 15rem; height: 5rem; background:#FE980F; border-radius:5px;" type="submit"name="sub-add" value="Thêm mới sản phẩm">
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