<?php
// include_once 'BaseRepository.php';

class SaleRevenue extends BaseRepository
{
  public function getUser()
  {
    if (isset($_SESSION['num_phone']) && isset($_SESSION['password'])) {
      return $this->get_data("SELECT * FROM users WHERE num_phone = '$_SESSION[num_phone]' AND password_current = '$_SESSION[password]'")[0];
    }
  }

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

  public function getAllShop()
  {
    return $this->get_data("SELECT * FROM shops");
  }

  public function getAllShopByUserId($user_id)
  {
      return $this->get_data("SELECT * FROM shops WHERE user_id = $user_id");
  }
    
  public function getShopByIdAndUserId($id, $user_id)
  {
      $shop = $this->get_data("SELECT * FROM shops WHERE id = $id AND user_id = $user_id");
      return isset($shop[0]) ? $shop[0] : null;
  }

  public function getShopById($id)
  {
    $shop = $this->get_data("SELECT * FROM shops WHERE id = $id");
    return isset($shop[0]) ? $shop[0] : null;
  }

  public function getProductByShopId($shop_id)
  {
    return $this->get_data("SELECT * FROM products WHERE shop_id = $shop_id");
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
