<?php

class NotificationRepository extends BaseRepository 
{
    /**
     * getNotificationsByUserId: lấy ra thông tin của thông báo
     *
     * @return void
     */
    public function getNotificationsByUserId()
    {
        $query = "SELECT id FROM notifications WHERE status = 1 AND user_id = " . $_SESSION['id'];
        return $this->get_data($query);
    }

}