<?php
include_once 'BaseRepository.php';

class ShopRepository extends BaseRepository
{
    public function getShopById($id)
    {
        $shop = $this->get_data("SELECT * FROM shops WHERE id = $id");
        return isset($shop[0]) ? $shop[0] : null;
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
}
