<?php

class NotificationRepository extends BaseRepository 
{

    public function search($txtSearch)
    {
        if(!$txtSearch) {
            $query = " SELECT P.id product_id, P.code product_code, P.name product_name, P.price_market product_price, P.image product_image, C.code ";
            $query .= " FROM products P, shops S, categories C ";
            $query .= " WHERE P.category_id = C.id AND P.shop_id = S.id ";
    
            return $this->get_data($query);
        }
        $query = " SELECT P.id product_id, P.code product_code, P.name product_name, P.price_market product_price, P.image product_image, C.code ";
        $query .= " FROM products P, shops S, categories C ";
        $query .= " WHERE P.category_id = C.id AND P.shop_id = S.id ";
        $query .= " AND (P.name LIKE '%" . $txtSearch . "%' ";
        $query .= " OR C.name LIKE '%" . $txtSearch . "%' ";
        $query .= " OR S.name LIKE '%" . $txtSearch . "%' ) ";

        return $this->get_data($query);
    }

    public function getAllByUserId() {
        $query = "SELECT * FROM notifications WHERE  user_id = " . $_SESSION['id'];
        return $this->get_data($query);
    }
    // public function getInfoNotis()
    // {
    //     $notifications = $this->getAllByUserId() ?? [];
    //     if(!$notifications) {
    //         echo '<script>alert("Bạn không có thông báo")</script>';
    //         return;
    //     }
    //     $data = [];
    //     foreach($notifications as $notification) {
    //         if($notification['notifiable_type'] == 0) {
    //             $query = " SELECT C.id, U.name user_name, P.name product_name, C.status, C.content FROM notifications N, comments C, users U, products P WHERE N.notifiable_id = C.id AND C.user_id = U.id AND C.product_id = P.id ";
    //             array_push($data, $this->get_data($query));
    //         }
    //         if($notification['notifiable_type'] == 1) {
    //             $query = " SELECT C.id, U.name user_name, P.name product_name, C.status, C.content FROM notifications N, comments C, users U, products P WHERE N.notifiable_id = C.id AND C.user_id = U.id AND C.product_id = P.id ";
    //             array_push($data, $this->get_data($query));
    //         }
    //     }
    // }

    public function getInfoNameUser($userId)
    {
        $query = " SELECT name FROM users WHERE id = $userId ";
        return $this->get_data($query)[0]['name'];
    }
    public function getInfoNameProduct($productId)
    {
        $query = " SELECT name FROM products WHERE id = $productId ";
        return $this->get_data($query)[0]['name'];
    }

    public function getNotificationsByUserId()
    {
        $query = "SELECT id FROM notifications WHERE status = 1 AND user_id = " . $_SESSION['id'];
        return $this->get_data($query);
    }

}