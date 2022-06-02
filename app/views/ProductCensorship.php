<?php include('./header.php');

    include('../Repositories/ProductRepository.php');
    $get_data = new ProductRepository();
    $products = $get_data->getInfoProductByStatus();
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
    <h1>Danh sách sản phẩm cần duyệt</h1>
            <table id="post">

                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Ảnh sản phẩm</th>
                    <th>Mô tả</th>
                    <th>Tên shop</th>
                    <th>Tên danh mục</th>
                    <th>Duyệt</th>
                    <th>Không duyệt</th>
                    
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
                    <!-- <td><a onclick="UpdateStatus()">Duyệt</a></td>  -->
                    <td><a onclick="agree(<?php echo $product['id'] ?>)" >Duyệt</a></td>
                    <td><a onclick="not_agree(<?php echo $product['id'] ?>)">Không duyệt</a></td> 
                    
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
    function agree(e) {
        if (confirm("Bạn có chắc muốn duyệt không?") == true) {
            window.location = './UpdateStatus.php?id=' + e;
        } else {
            console.log('không duyệt');
        }
    }
    function not_agree(e) {
        if (confirm("Bạn có chắc muốn từ chối duyệt không?") == true) {
            window.location = './UpdateReason.php?id=' + e;
        } else {
            console.log('không duyệt');
        }
    }
</script>

<?php include('./footer.php') ?>