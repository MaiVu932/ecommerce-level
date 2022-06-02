<?php
// include_once 'BaseRepository.php';

class ComplainRepository extends BaseRepository
{

    /**
     * createComplain: tạo đơn khiếu nại
     *
     * @param array $data
     * @param [type] $user_id
     * @param [type] $product_id
     * @return void
     */
    public function createComplain(array $data, $user_id, $product_id)
    {
      if (empty($data['content'])) {
        echo '<script>
                alert("Lý do khiếu nại không được bỏ trống !");
              </script>';
        return;
      }
      $complain = [
        'user_id' => $user_id,
        'product_id' => $product_id,
        'content' => $data['content'],
        'create_at' => date('Y-m-d', time()),
        'commentable_type' => 1
      ];
      $insert_id = $this->insert('comments', $complain, true);

      $notification = [
        'user_id' => $user_id,
        'notifiable_id' => $insert_id,
        'notifiable_type' => 0,
        'status' => 1 // chưa xem
      ];
      $this->insert('notifications', $notification);

      echo '<script>
              alert("Đăng tải đơn khiếu nại thành công, vui lòng chờ duyệt !");
            </script>';

      return $complain;
    }

    /**
     * getListComplain: lấy ra danh sách khiếu nại
     *
     * @return void
     */
    public function getListComplain()
    {
      return $this->get_data("SELECT * FROM comments WHERE commentable_type = 1");
    }

    /**
     * getComplainById: lấy thông tin đơn khiếu nại theo mã thông báo
     *
     * @param [type] $id
     * @return void
     */
    public function getComplainById($id)
    {
      $complain = $this->get_data("SELECT * FROM comments WHERE commentable_type = 1 AND id = $id");
      return isset($complain[0]) ? $complain[0] : null;
    }

    /**
     * getComplainByNotifiableId: lấy thông tin khiếu nại theo mã thông báo khiếu nại
     *
     * @param [type] $id
     * @return void
     */
    public function getComplainByNotifiableId($id)
    {
      $complain = $this->get_data("SELECT * FROM comments WHERE id = $id");
      return isset($complain[0]) ? $complain[0] : null;
    }

    /**
     * updateStatusComment: Cập nhật trạng thái của bình luận
     *
     * @param array $data
     * @return void
     */
    public function updateStatusComment(array $data)
    {
      $complain = [
        'status' => $data['status']
      ];
      $this->update('comments', $data, "id = $data[id]");
    }

    /**
     * notApprove: xét duyệt đơn khiếu nại(không đồng ý)
     *
     * @param array $data
     * @return void
     */
    public function notApprove(array $data)
    {
      $notification = [
        'user_id' => $data['user_id'],
        'notifiable_id' => $data['notifiable_id'],
        'notifiable_type' => 0,
        'status' => 1 // chưa xem
      ];
      $this->insert('notifications', $notification);

      $status = [
        'id' => $data['notifiable_id'],
        'status' => 1 // không duyệt
      ];
      $this->updateStatusComment($status);

      echo '<script>
              alert("Không duyệt đơn khiếu nại này thành công !");
              window.location = "complain_list.php";
            </script>';
      // return $notification;
    }

    /**
     * approve: xét duyệt đơn khiếu nại(đồng ý)
     *
     * @param array $data
     * @return void
     */
    public function approve(array $data)
    {
      // Gửi thông báo cho chủ shop
      $notification = [
        'user_id' => $data['user_id_shop'],
        'notifiable_id' => $data['notifiable_id'],
        'notifiable_type' => 0,
        'status' => 1 // chưa xem
      ];
      $this->insert('notifications', $notification);

      // Gửi thông báo cho người Tạo
      $notification = [
        'user_id' => $data['user_id'],
        'notifiable_id' => $data['notifiable_id'],
        'notifiable_type' => 0,
        'status' => 1 // chưa xem
      ];
      $this->insert('notifications', $notification);

      $status = [
        'id' => $data['notifiable_id'],
        'status' => 0 // duyệt
      ];
      $this->updateStatusComment($status);

      echo '<script>
              alert("Phê duyệt đơn khiếu nại này thành công !");
              window.location = "complain_list.php";
            </script>';
      // return $notification;
    }

    /**
     * getNumberOfViolations: lấy ra số lần vi phạm
     *
     * @param [type] $shop_id
     * @return void
     */
    public function getNumberOfViolations($shop_id)
    {
      $product = $this->get_data("SELECT id FROM products WHERE shop_id = (SELECT id FROM shops WHERE id = $shop_id)");

      $where = '';
      foreach ($product as $prod) {
        $where .= "product_id = $prod[id] OR ";
      }
      $where = trim($where, ' OR ');

      if(count($product)) {
          $complain = $this->get_data("SELECT * FROM comments WHERE $where AND status = 0");
      }

      $complain = $this->get_data("SELECT * FROM comments WHERE status = 0");

      return count($complain);
    }

    /**
     * getHistoryByUserId: lấy ra thông tin lịch sử giao dịch của người dùng
     *
     * @param [type] $user_id
     * @return void
     */
    public function getHistoryByUserId($user_id)
    {
      return $this->get_data("SELECT categories.code, orders.id, products.name, orders.id as order_id, orders.quantity, orders.status, orders.address, orders.num_phone, products.image
            FROM products, orders, categories
            WHERE orders.product_id = products.id AND categories.id = products.category_id AND user_id = $user_id AND orders.status = 1");
    }

    /**
     * getProductById: Lấy thông tin của sản phẩm qua mã sản phẩm
     *
     * @param [type] $id
     * @return void
     */
    public function getProductById($id)
    {
      $product = $this->get_data("SELECT products.id, products.name, products.quantity, products.image, products.shop_id, categories.code FROM products, categories WHERE products.id = $id AND products.category_id = categories.id ");
      return isset($product[0]) ? $product[0] : null;
    }

    /**
     * getProductByOrderId: lấy thông tin sản phẩm trong đơn hàng
     *
     * @param [type] $order_id
     * @return void
     */
    public function getProductByOrderId($order_id)
    {
      $order = $this->get_data("SELECT products.id, products.name, orders.quantity, products.image
            FROM products, orders 
            WHERE orders.product_id = products.id AND orders.id = $order_id");
      return isset($order[0]) ? $order[0] : null;
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

    /**
     * countNotificaltion: lây ra số lần thông báo khiếu nại
     *
     * @param [type] $user_id
     * @return void
     */
    public function countNotification($user_id)
    {
      $notifications = $this->get_data("SELECT * FROM notifications WHERE user_id = $user_id AND status = 1");
      return count($notifications);
    }

    /**
     * getNotificationByUserId: lấy ra thông tin người của thông báo 
     *
     * @param [type] $user_id
     * @return void
     */
    public function getNotificationByUserId($user_id)
    {
      return $this->get_data("SELECT * FROM notifications WHERE user_id = $user_id ORDER BY id DESC");
    }

    /**
     * updateStatusNotification: cập nhật thông báo
     *
     * @param array $data
     * @return void
     */
    public function updateStatusNotification(array $data)
    {
      $complain = [
        'status' => $data['status']
      ];
      $this->update('notifications', $data, "id = $data[id]");
    }

    /**
     * getUserbyId: lấy thông tin người dùng qua mã người dùng
     *
     * @param [type] $id
     * @return void
     */
    public function getUserbyId($id)
    {
      $user = $this->get_data("SELECT * FROM users WHERE id = $id");
      return isset($user[0]) ? $user[0] : null;
    }

    /**
     * deleteUserById: xóa tài khoản người dùng
     *
     * @param [type] $id
     * @return void
     */
    public function deleteUserById($id)
    {
      $notifications = $this->delete('notifications', "user_id = $id");
      $shops = $this->delete('shops', "user_id = $id");
      $users = $this->delete('users', "id = $id");
      echo '<script>
                alert("Xoá tài khoản thành công !");
              </script>';
      return;
    }

    /**
     * getShopById: lấy thông tin của shop qua mã shop
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
     * getAllShopByUserId: lấy thông tin shop của người dùng
     *
     * @param [type] $user_id
     * @return void
     */
    public function getAllShopByUserId($user_id)
    {
        return $this->get_data("SELECT * FROM shops WHERE user_id = $user_id");
    }
  }
