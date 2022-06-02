<?php
// include_once 'BaseRepository.php';

class OrderRepository extends BaseRepository
{

    public function getProductsInCart()
    {
        $query = " SELECT P.name, P.price_market, O.quantity, P.image  FROM orders O, products P WHERE O.product_id = P.id AND O.user_id = " . $_SESSION['id'];
        return $this->get_data($query);
    }

    public function getInfoUserById()
    {
        return $this->get_data("SELECT address, num_phone FROM users WHERE id = " . $_SESSION['id'])[0];
    }

    public function addToCart($quantity)
    {
        if(!isset($_SESSION['id'])) {
            echo '<script>alert("Bạn cần đăng nhâp trước khi thêm vào giỏ hàng")</script>';
            return;
        }
        $user = $this->getInfoUserById();
        $order = [
            'user_id' => $_SESSION['id'],
            'product_id' => $_SESSION['product_id'],
            'quantity' => $quantity,
            'status' => 3,
            'address' => $user['address'],
            'num_phone' => $user['num_phone'],
            'create_at' => date('Ymd')
        ];
        $isInsertOrder = $this->insert('orders', $order);
        if(!$isInsertOrder) {
            echo '<script>alert("Thêm sản phẩm thất bại !! ")</script>';
            return;
        }
        echo '<script>alert("Thêm sản phẩm vào giỏ hàng thành công")</script>';
        echo '<script>window.location="./cart_list.php"</script>';
        return;
    }

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