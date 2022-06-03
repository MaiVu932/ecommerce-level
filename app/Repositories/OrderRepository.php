<?php
// include_once 'BaseRepository.php';

class OrderRepository extends BaseRepository
{

    /**
     * orderBuyListProducts: kiểm tra lỗi
     *
     * @param [type] $data
     * @return void
     */
    public function orderBuyListProducts($orders)
    {
        $data = [];
        foreach($orders as $order) {
            // $o = $this->buyProductByCart($order);
            $o = $this->getUserIdOfShoWhenOrderId($order)[0];
            if($o) array_push($data, $o);
        }
        $_SESSION['orders'] = $data;
        // var_dump($_SESSION['orders']);
        echo '<script>window.location="order_products.php"</script>';
        return;
    }

    public function orderBuyListProducts1($orders, $address, $numPhone)
    {
        $data = [];
        foreach($orders as $order) {
            $o = $this->buyProductByCart($order, $address, $numPhone);
            // $o = $this->getUserIdOfShoWhenOrderId($order)[0];
            if($o) array_push($data, $o);
        }
        // $_SESSION['orders'] = $data;
        echo '<script>alert("Đặt hàng thành công !!");window.location="home.php"</script>';
        return;
    }

    public function buyProductByCart($order_id, $address, $numPhone)
    {
        $isUpdateOrder = $this->update('orders', [
            'status' => 4, 
            'address' => $address,
            'num_phone' => $numPhone,
            'create_at' => date("Ymd")], 'id = ' . $order_id);
        if(!$isUpdateOrder) {
            echo '<script>alert("Đặt hàng thất bại")</script>';
            return;
        }
        $data = $this->getUserIdOfShoWhenOrderId($order_id)[0];
        $notification = [
            'user_id' => $data['user_id'],
            'notifiable_type' => 1,
            'notifiable_id' => $order_id,
            'status' => 1
        ];
        $isInsertNotification = $this->insert('notifications', $notification);
        if(!$isInsertNotification) {
            echo '<script>alert("Đặt hàng thất bại")</script>';
            return;
        }
        echo '<script>alert("Đặt hàng thanh cong")</script>';
        return;

    }

    public function getUserIdOfShoWhenOrderId($order_id)
    {
        $query = " SELECT U.id user_id, P.id product_id, P.price_market price, P.name, O.quantity FROM users U, shops S, products P, orders O WHERE U.id = S.user_id AND S.id = P.shop_id AND O.product_id = P.id AND O.id = " . $order_id;
        return $this->get_data($query);
    }
    
   /**
    * infoOrderBy: lấy giá và tên sản phẩm qua mã sản phẩm
    *
    * @return void
    */
    public function infoOrderBy()
    {
        $info = [];
        if(isset($_SESSION['product_id'])) {
            $query = " SELECT name, price_market FROM products WHERE id = " . $_SESSION['product_id'];
            $info = $this->get_data($query)[0];
        }
       
        return [array_merge($info, ['quantity_order' => $_SESSION['quantity_order']])];
    }

    /**
     * createOrder: tạo đơn đặt hàng
     *
     * @param [type] $quantity
     * @param [type] $address
     * @param [type] $num_phone
     * @return void
     */
    public function createOrder($quantity, $address, $num_phone)
    {
        if(!isset($_SESSION['id'])) {
            echo '<script>alert("Bạn cần đăng nhâp trước khi đặt hàng")</script>';
            return;
        }
        // $user = $this->getInfoUserById();
        $order = [
            'user_id' => $_SESSION['id'],
            'product_id' => $_SESSION['product_id'],
            'quantity' => $_SESSION['quantity_order'],
            'status' => 4,
            'address' => $address,
            'num_phone' => $num_phone,
            'create_at' => date('Ymd')
        ];
        $isInsertOrder = $this->insert('orders', $order);
        if(!$isInsertOrder) {
            echo '<script>alert("Đặt hàng thất bại !! ")</script>';
            return;
        }
        $userIdShop = $this->getUserIdByProductId($_SESSION['product_id'])['id'];

        $orderID = $this->getIdOrderByUserId();
        $notification = [
            'user_id' => $userIdShop,
            'notifiable_type' => 1,
            'notifiable_id' => $orderID,
            'status' => 1
        ];
        $isInsertNotification = $this->insert('notifications', $notification);
        if(!$isInsertNotification) {
            echo '<script>alert("Đặt hàng thất bại !! ")</script>';
            return;
        }

        echo '<script>alert("Đặt hàng thành công thành công")</script>';
        echo '<script>window.location="./cart_list.php"</script>';
        return;
    }

    /**
     * getIdOrderByUserId: lấy mã đặt hàng qua mã sản phẩm và mã người dùng trong đơn đặt hàng.
     *
     * @return void
     */
    public function getIdOrderByUserId()
    {
        $query = " SELECT O.id FROM orders O WHERE O.product_id = " . $_SESSION['product_id'] .  " AND O.user_id = " . $_SESSION['id'] . " ORDER BY create_at DESC LIMIT 1";
        return $this->get_data($query)[0]['id'];
    }

    /**
     * getUserIdByProductId: mã người dùng 
     *
     * @param [type] $id
     * @return void
     */
    public function getUserIdByProductId($id)
    {
        $query = " SELECT U.id FROM users U, shops S, products P WHERE U.id = S.user_id AND S.id = P.shop_id AND P.id = " . $id;
        return $this->get_data($query)[0];
    }

    /**
     * getProductsInCart: lấy ra thông tin để đặt hàng
     *
     * @return void
     */
    public function getProductsInCart()
    {
        $query = " SELECT O.id, P.name, P.price_market, O.quantity, P.image, C.code  ";
        $query .= " FROM orders O, products P, categories C "; 
        $query .= " WHERE P.category_id = C.id AND O.product_id = P.id AND O.user_id = " . $_SESSION['id'] . " AND O.status = 3 ";
        return $this->get_data($query);
    }

    /**
     * getInfoUserById: lấy ra thông tin người dùng
     *
     * @return void
     */
    public function getInfoUserById()
    {
        return $this->get_data("SELECT name, address, num_phone FROM users WHERE id = " . $_SESSION['id'])[0];
    }

    /**
     * addToCart: Thêm sản phẩm vào giỏ hàng
     *
     * @param [type] $quantity
     * @return void
     */
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

    /**
     * getHistoryByUserId: lấy thông tin lịch sử giao dịch
     *
     * @param [type] $user_id
     * @return void
     */
    public function getHistoryByUserId($user_id)
    {
        return $this->get_data("SELECT products.id, products.name, orders.quantity, orders.status, orders.address, orders.num_phone, products.image
            FROM products, orders 
            WHERE orders.product_id = products.id AND user_id = $user_id");
    }

    /**
     * getProductByOrderId: lấy thông tin sản phẩm qua mã đặt hàng
     *
     * @param [type] $order_id
     * @return void
     */
    public function getProductByOrderId($order_id)
    {
        $order = $this->get_data("SELECT orders.id, products.name, orders.quantity, products.image
            FROM products, orders 
            WHERE orders.product_id = products.id AND orders.id = $order_id");
        return isset($order[0]) ? $order[0] : null;
    }

    /**
     * getQuantityByProduct: lất ra số lượng của sản phẩm
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

    public function getOrderAccept()
    {
        $sql = "SELECT P.id, S.name 'nameS', P.name 'nameP', P.image, 
                C.code 'code-category', O.quantity, U.name 'nameU', 
                U.num_phone 'numPhoneU', U.address
                FROM orders O, products P, shops S, users U, categories C
                WHERE P.id = O.product_id AND C.id = P.category_id
                AND P.shop_id = S.id AND O.user_id = U.id AND O.status = 4";

        return $this->get_data($sql);
    }

    public function updateOrderByStatus($status, $product_id)
    {
        return $this->update('orders', ['status' => $status], 'product_id = ' .$product_id);
    }
}