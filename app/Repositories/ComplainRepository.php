<?php
include_once 'BaseRepository.php';

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
    $this->insert('comments', $complain);

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

  public function updateStatus(array $data)
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
      'notifiable_type' => 3, // loại phê duyệt
      'status' => 1 // chưa xem
    ];
    $this->insert('notifications', $notification);

    $status = [
      'id' => $data['notifiable_id'],
      'status' => 1 // không duyệt
    ];
    $this->updateStatus($status);

    echo '<script>
            alert("Không duyệt đơn khiếu nại này thành công !");
            window.location = "complain_list.php";
          </script>';
    // return $notification;
  }

  public function approve(array $data)
  {
    $notification = [
      'user_id' => $data['user_id'],
      'notifiable_id' => $data['notifiable_id'],
      'notifiable_type' => 3, // loại phê duyệt
      'status' => 1 // chưa xem
    ];
    $this->insert('notifications', $notification);

    $status = [
      'id' => $data['notifiable_id'],
      'status' => 0 // duyệt
    ];
    $this->updateStatus($status);

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
}
