<?php
// include_once 'BaseRepository.php';

class ComplainRepository extends BaseRepository
{
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

  public function getListComplain()
  {
    return $this->get_data("SELECT * FROM comments WHERE commentable_type = 1");
  }

  public function getComplainById($id)
  {
    $complain = $this->get_data("SELECT * FROM comments WHERE commentable_type = 1 AND id = $id");
    return isset($complain[0]) ? $complain[0] : null;
  }

  public function getComplainByNotifiableId($id)
  {
    $complain = $this->get_data("SELECT * FROM comments WHERE id = $id");
    return isset($complain[0]) ? $complain[0] : null;
  }

  public function updateStatusComment(array $data)
  {
    $complain = [
      'status' => $data['status']
    ];
    $this->update('comments', $data, "id = $data[id]");
  }

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

  // get số lần vi phạm
  public function getNumberOfViolations($shop_id)
  {
    $product = $this->get_data("SELECT id FROM products WHERE shop_id = (SELECT id FROM shops WHERE id = $shop_id)");

    $where = '';
    foreach ($product as $prod) {
      $where .= "product_id = $prod[id] OR ";
    }
    $where = trim($where, ' OR ');

    $complain = $this->get_data("SELECT * FROM comments WHERE ($where) AND status = 0");
    return count($complain);
  }

  public function getHistoryByUserId($user_id)
  {
    return $this->get_data("SELECT orders.id, products.name, orders.id as order_id, orders.quantity, orders.status, orders.address, orders.num_phone, products.image
          FROM products, orders 
          WHERE orders.product_id = products.id AND user_id = $user_id");
  }

  public function getProductById($id)
  {
    $product = $this->get_data("SELECT * FROM products WHERE id = $id");
    return isset($product[0]) ? $product[0] : null;
  }

  public function getProductByOrderId($order_id)
  {
    $order = $this->get_data("SELECT products.id, products.name, orders.quantity, products.image
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

  public function countNotification($user_id)
  {
    $notifications = $this->get_data("SELECT * FROM notifications WHERE user_id = $user_id AND status = 1");
    return count($notifications);
  }

  public function getNotificationByUserId($user_id)
  {
    return $this->get_data("SELECT * FROM notifications WHERE user_id = $user_id ORDER BY id DESC");
  }

  public function updateStatusNotification(array $data)
  {
    $complain = [
      'status' => $data['status']
    ];
    $this->update('notifications', $data, "id = $data[id]");
  }

  public function getUserbyId($id)
  {
    $user = $this->get_data("SELECT * FROM users WHERE id = $id");
    return isset($user[0]) ? $user[0] : null;
  }

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

  public function getShopById($id)
  {
    $shop = $this->get_data("SELECT * FROM shops WHERE id = $id");
    return isset($shop[0]) ? $shop[0] : null;
  }

  public function getAllShopByUserId($user_id)
  {
      return $this->get_data("SELECT * FROM shops WHERE user_id = $user_id");
  }
}
