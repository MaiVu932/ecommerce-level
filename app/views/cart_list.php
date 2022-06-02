<?php 
include './header.php';
include '../Repositories/OrderRepository.php';

$order = new OrderRepository();
$products = $order->getProductsInCart();

var_dump($products);


?>