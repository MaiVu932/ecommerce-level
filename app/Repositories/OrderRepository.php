<?php
include_once 'BaseRepository.php';

class OrderRepository extends BaseRepository
{
  public function getHistoryByUserId($user_id)
  {
    return $this->get_data("SELECT products.id, products.name, orders.quantity, orders.status, orders.address, orders.num_phone, products.image
          FROM products, orders 
          WHERE orders.product_id = products.id AND user_id = $user_id");
  }

  public function getProductByOrderId($order_id)
  {
    $order = $this->get_data("SELECT orders.id, products.name, orders.quantity, products.image
          FROM products, orders 
          WHERE orders.product_id = products.id AND orders.id = $order_id");
    return isset($order[0]) ? $order[0] : null;
  }

  public function getQuantityByProduct(array $product, $date = '', $month = '', $year = '')
  {
    if (!empty($date) && !empty($month) && !empty($year)) {
      $sql = "SELECT SUM(quantity) as quantity FROM orders WHERE status = 0 AND product_id = $product[id] AND create_at = '$year-$month-$date'";
    } else if (!empty($month) && !empty($year)) {
      $sql = "SELECT SUM(quantity) as quantity FROM orders WHERE status = 0 AND product_id = $product[id] AND create_at LIKE '%$year-$month%'";
    } else if (!empty($year)) {
      $sql = "SELECT SUM(quantity) as quantity FROM orders WHERE status = 0 AND product_id = $product[id] AND create_at LIKE '%$year%'";
    } else {
      $sql = "SELECT SUM(quantity) as quantity FROM orders WHERE status = 0 AND product_id = $product[id]";
    }
    $order = $this->get_data($sql);
    return isset($order[0]['quantity']) ? $order[0]['quantity'] : null;
  }
}