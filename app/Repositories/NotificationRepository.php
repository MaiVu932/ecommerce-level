<?php
include_once 'BaseRepository.php';

class NotificationRepository extends BaseRepository
{
  public function createNotification(array $data)
  {
    $notification = [
      'user_id' => $data['user_id'],
      'notifiable_id' => $data['notifiable_id'],
      'notifiable_type' => $data['notifiable_type'],
      'status' => $data['status']
    ];
    $this->insert('notifications', $notification);

    // Nếu notifiable_type = 3 là loại thông báo: Phê duyệt 
    if ($data['notifiable_type'] == 3) {
    }

    echo '<script>
            alert("Không duyệt !");
          </script>';
    // return $notification;
  }
}
