<?php
    include 'header.php';
    include '../Repositories/AccuseRepository.php';
    $accuse = new AccuseRepository();
    if(isset($_POST['cr-accuse'])) {
        $accuse->accuse($_POST);
    }
    $selects = $accuse->selectData();
    echo '<link rel="stylesheet" href="' . CSS . 'accuse_cr.css">';
?>
<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<h2 style="color:#FE980F; text-align:center">TẠO ĐƠN KHIẾU NẠI</h2>
<div class="body">
        
    <form action="" method="POST" class="nd" enctype="multipart/form-data">
        <!-- <?php
            $i=1;
            foreach($selects as $select){
        ?> -->
        <p>Tên sản phẩm: <?php echo 'products.name' ?> </p>  
        <p>Số lượng sản phẩm: </p>
        <p>Hình ảnh sản phẩm:</p>
        <!-- <?php } ?> -->
        <p><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Lí do khiếu nại:<br>
        <textarea cols="30" rows="7" name="message" class="ipt" required></textarea></p>
        <p>Ngày tạo đơn: <?php echo date("d-m-Y")?></p>
        <div class="nut">
          <button type="submit" name="cr-accuse" style="color:white; background-color:#FE980F">Đăng</button>
        </div>
 
    </form>
</div>

<?php include 'footer.php'?>