<?php
    include('./header.php');
    include('../Repositories/ProductRepository.php');
    $get_data = new ProductRepository();
    $get_data->UpdateStatus($_GET['id']);
?>