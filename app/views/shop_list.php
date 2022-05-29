<?php
    include 'header.php';
    include '../Repositories/ShopRepository.php';
    $shop = new ShopRepository();
    $shop->validate();
    $shops = $shop->getShops();

    echo '<link href="' . CSS . 'shop_list.css" rel="stylesheet">';
    echo '<script src="' . JS . 'processDate.js" defer></script>';
?>




<div class="container">
    
    <div class="content">
        <div class="option">
            <div class="search">
                <form>
                    <input 
                        type="text" 
                        name="txt-search-name" />
                    <input 
                        type="text" 
                        name="date-search"
                        id="dateSearch"
                        style="width: 20%; outline: none;" 
                        placeholder="Thời gian tạo shop" >
                    <input type="submit" name="btn-search" />
                </form>
                
            </div>
        </div>

        <h1>Danh sách shops</h1>
        <table id="post">
            <tr>
                <th>STT</th>
                <th>Tên shop</th>
                <th>Địa chỉ shop</th>
                <th>Số điện thoại shop</th>
                <th>Chủ shop</th>
                <th>Số điện thoại chủ shop</th>
                <th>Ngày tạo shop</th>
                <th>Sửa</th>
                <th>Xóa</abbr></th>
            </tr>
            <?php 
            $i = 0;
            foreach($shops as $value): 
            ?>
                <tr>
                    <td><?php echo $i + 1; $i++?></td>
                    <td><?php echo $value['nameS'] ?></td>
                    <td><?php echo $value['addressS'] ?></td>
                    <td><?php echo $value['numPhoneS'] ?></td>
                    <td><?php echo $value['nameU'] ?></td>
                    <td><?php echo $value['numPhoneU'] ?></td>
                    <td><?php echo $value['createS'] ?></td>
                    <td>Sửa</td>
                    <td>Xóa</td>
                </tr>
            <?php endforeach; ?>

        </table>
            <div style="margin: 20px 0px 0 20px;">
                    <a href="userList.php"><button>Back to Manager</button></a>
            </div>
    </div>
</div>
<div class="panel-footer"> 
    <div class="row"> 
        <div class="col col-xs-4">Trang 1 của 5 </div> 
            <div class="col col-xs-8"> 
                <ul class="pagination hidden-xs pull-right"> 
                    <li><a href="shop_list.php">1</a></li>

                    <li><a href="shop_list.php">2</a></li> 

                    <li><a href="shop_list.php">3</a></li>

                    <li><a href="shop_list.php">4</a></li>

                    <li><a href="shop_list.php">5</a></li> 
                </ul> 
                <ul class="pagination visible-xs pull-right"> 
                    <li><a href="ProductList.php">«</a></li>

                    <li><a href="ProductList.php">»</a></li> 
                </ul> 
            </div> 
        </div> 
    </div> 
</div>

<?php include 'footer.php'?>