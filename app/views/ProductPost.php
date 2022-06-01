<?php
include './header.php';
include '../Repositories/ProductRepository.php';

$product = new ProductRepository();
$product->postProduct();


