<?php
// include_once 'BaseRepository.php';

class SaleRevenue extends BaseRepository
{

    /**
     * getUser: lấy thông tin người dùng
     *
     * @return void
     */
    public function getUser()
    {
      if (isset($_SESSION['num_phone']) && isset($_SESSION['password'])) {
        return $this->get_data("SELECT * FROM users WHERE num_phone = '$_SESSION[num_phone]' AND password_current = '$_SESSION[password]'")[0];
      }
    }

    /**
     * getSaleRevenueByQuantityAndProductIdTemp
     *
     * @param [type] $quantity
     * @param [type] $id
     * @return void
     */
    public function getSaleRevenueByQuantityAndProductIdTemp($quantity, $id)
    {
      $order = $this->get_data("SELECT *, ($quantity) as sold, (quantity - $quantity) as inventory, (price_market * $quantity) as sale, ((price_market * $quantity) - (price_historical * $quantity)) as revenue FROM products WHERE id = $id");
      $sql = "SELECT *, ($quantity) as sold, (quantity - $quantity) as inventory, (price_market * $quantity) as sale, ((price_market * $quantity) - (price_historical * $quantity)) as revenue FROM products WHERE id = $id";
      echo $sql;
      return isset($order[0]) ? $order[0] : null;
    }

    /**
     * getSaleRevenueByQuantityAndProductId: lấy doanh số doanh thu của sản phẩm theo shop
     *
     * @param [type] $quantity
     * @param [type] $id
     * @param [type] $date
     * @return void
     */
    public function getSaleRevenueByQuantityAndProductId($quantity, $id, $date = null)
    {
      $order = $this->get_data("SELECT *, ($quantity) as sold, (quantity - $quantity) as inventory, (price_market * $quantity) as sale, ((price_market * $quantity) - (price_historical * $quantity)) as revenue FROM products WHERE id = $id");
      if (isset($date))
        $order = $this->get_data("SELECT *, ($quantity) as sold, (quantity - $quantity) as inventory, (price_market * $quantity) as sale, ((price_market * $quantity) - (price_historical * $quantity)) as revenue FROM products WHERE id = $id");
      return isset($order[0]) ? $order[0] : null;
    }

    /**
     * getSaleRevenueByQuantityAndProductId2: lấy doanh số doanh thu cuuar sản phẩm theo sàn
     *
     * @param [type] $quantity
     * @param [type] $id
     * @return void
     */
    public function getSaleRevenueByQuantityAndProductId2($quantity, $id)
    {
      $order = $this->get_data("SELECT *, ($quantity) as sold, (quantity - $quantity) as inventory, (price_market * $quantity) as sale, ((price_market * $quantity) - (price_historical * $quantity)) as revenue FROM products WHERE id = $id");
      return isset($order[0]) ? $order[0] : null;
    }

    /**
     * getAllShop: lấy thông tin của shop
     *
     * @return void
     */
    public function getAllShop()
    {
      return $this->get_data("SELECT * FROM shops");
    }

    /**
     * getAllShopByUserId:  lấy thông tin của shop qua mã người dùng
     *
     * @param [type] $user_id
     * @return void
     */
    public function getAllShopByUserId($user_id)
    {
        return $this->get_data("SELECT * FROM shops WHERE user_id = $user_id");
    }

    /**
     * getShopByIdAndUserId
     *
     * @param [type] $id
     * @param [type] $user_id
     * @return void
     */
    public function getShopByIdAndUserId($id, $user_id)
    {
        $shop = $this->get_data("SELECT * FROM shops WHERE id = $id AND user_id = $user_id");
        return isset($shop[0]) ? $shop[0] : null;
    }

    /**
     * getShopId: lấy thông tin của shop qua mã shop
     *
     * @param [type] $id
     * @return void
     */
    public function getShopById($id)
    {
      $shop = $this->get_data("SELECT * FROM shops WHERE id = $id");
      return isset($shop[0]) ? $shop[0] : null;
    }

    /**
     * getProductByShopId: lất thông tin sản phẩm của shop
     *
     * @param [type] $shop_id
     * @return void
     */
    public function getProductByShopId($shop_id)
    {
      return $this->get_data("SELECT * FROM products WHERE shop_id = $shop_id");
    }

    /**
     * getQuantityByProduct: lấy tổng số lượng sản phẩm đã bán được theo ngày tháng năm nhập vào
     *
     * @param array $product
     * @param string $date
     * @param string $month
     * @param string $year
     * @return void
     */
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
