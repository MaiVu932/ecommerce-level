<?php
    include('./header.php');
    include('../Repositories/ProductRepository.php');
    $get_data = new ProductRepository();
    // echo "Bạn không cho sản phẩm này được đăng bán tên sàn";
    // return;
    $get_data->updateReason($_GET['id']);
?>