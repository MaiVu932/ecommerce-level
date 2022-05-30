<?php
include_once 'BaseRepository.php';

class SaleRevenue extends BaseRepository
{
  public function getSaleRevenueByQuantityAndProductIdTemp($quantity, $id)
  {
    $order = $this->get_data("SELECT *, ($quantity) as sold, (quantity - $quantity) as inventory, (price_market * $quantity) as sale, ((price_market * $quantity) - (price_historical * $quantity)) as revenue FROM products WHERE id = $id");
    $sql = "SELECT *, ($quantity) as sold, (quantity - $quantity) as inventory, (price_market * $quantity) as sale, ((price_market * $quantity) - (price_historical * $quantity)) as revenue FROM products WHERE id = $id";
    echo $sql;
    return isset($order[0]) ? $order[0] : null;
  }

  public function getSaleRevenueByQuantityAndProductId($quantity, $id, $date = null)
  {
    $order = $this->get_data("SELECT *, ($quantity) as sold, (quantity - $quantity) as inventory, (price_market * $quantity) as sale, ((price_market * $quantity) - (price_historical * $quantity)) as revenue FROM products WHERE id = $id");
    if (isset($date))
      $order = $this->get_data("SELECT *, ($quantity) as sold, (quantity - $quantity) as inventory, (price_market * $quantity) as sale, ((price_market * $quantity) - (price_historical * $quantity)) as revenue FROM products WHERE id = $id");
    return isset($order[0]) ? $order[0] : null;
  }

  public function getSaleRevenueByQuantityAndProductId2($quantity, $id)
  {
    $order = $this->get_data("SELECT *, ($quantity) as sold, (quantity - $quantity) as inventory, (price_market * $quantity) as sale, ((price_market * $quantity) - (price_historical * $quantity)) as revenue FROM products WHERE id = $id");
    return isset($order[0]) ? $order[0] : null;
  }
}
