<?php
include_once 'BaseRepository.php';

class ProductRepository extends BaseRepository
{
    public function getProductById($id)
    {
        $product = $this->get_data("SELECT * FROM products WHERE id = $id");
        return isset($product[0]) ? $product[0] : null;
    }

    public function getProductByShopId($shop_id)
    {
        return $this->get_data("SELECT * FROM products WHERE shop_id = $shop_id");
    }
}
