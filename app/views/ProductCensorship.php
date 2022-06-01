<?php include('header.php');

    include('../Repositories/ProductRepository.php');
    $get_data = new ProductRepository();
    $products = $get_data->getInfoProduct();
    // var_dump($products);

    echo '<link href="' . CSS . 'listP.css" rel="stylesheet">';
?>
<div class="container col-lg-12 mx-auto">
    <div class="d-flex justify-content-start py-3">
        <ul class="nav nav-pills">
          <li class="nav-item"><a href="#" class="nav-link active" aria-current="page">Quản lý</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Người dùng</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Danh mục</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Sản phẩm</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Bài viết</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Hóa đơn</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Doanh số/ thu</a></li>

        </ul>
      </div>
    <div class="content">
    <h1>Danh sách kiểm duyệt</h1>
            <table id="post">

                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Ảnh sản phẩm</th>
                    <th>Mô tả chi tiết sản phẩm</th>
                    <th>Tên shop</th>
                    <th>Tên danh mục</th>
                    <th>Đồng ý</th>
                    <th>Từ chối</th>
                </tr>

                <?php 
                    $i=1;
                    foreach($products as $product) { ?>
                <tr>
                    <th><?php echo $i++ ?></th>
                    <td><?php echo $product['name'] ?></td>
                    <td>
                        <img src= 
                            "<?php echo IMAGES . $product['code-category'] . '/' . $product['image'] ?>"  
                            alt="ảnh" width="100px" height ="100px" />
                    </td>
                    <td><?php echo $product['description'] ?></td>
                    <td><?php echo $product['name-shop'] ?></td>
                    <td><?php echo $product['name-category'] ?></td>
                    <td>Đồng ý</td> 
                    <td>Từ chối</td> 
                    
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



<?php include('footer.php')?>