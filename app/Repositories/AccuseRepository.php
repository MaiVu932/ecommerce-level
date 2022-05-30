<?php

include_once 'BaseRepository.php';
    class AccuseRepository extends BaseRepository
    {
        public function selectData()
        {
            $accuse = "SELECT products.name, products.quantity, products.image
            FROM products, orders 
            WHERE orders.product_id = products.id"; //AND orders.id = $_GET['order-id'];

        }
        public function accuse(array $data)
        {
            $isNote = trim($data['message']);
            if($isNote!=null) {
                $accuse = [
                    'content' => $isNote,
                    'create_at' == date('d-m-Y'),
                    ];

                $this->insert('accuse', $accuse);
                echo '<script>alert("Đăng tải đơn khếu nại thành công, vui lòng chờ duyệt !")</script>';
                return $accuse;
            }
        }
    }
?>