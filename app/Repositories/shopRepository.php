<?php

include 'BaseRepository.php';

class ShopRepository extends BaseRepository
{

    public function getShops(
        $page = null,
        $nameS = null,
        $dateS = null,
    )
    {
        if($nameS == null && $dateS == null) {
            $query = "SELECT S.name nameS, S.num_phone numPhoneS, S.address addressS, S.create_at createS, S.description descriptionS, "; 
            $query .= " U.name nameU, U.num_phone numPhoneU, U.address addressU ";
            $query .= " FROM shops S, users U ";
            $query .= " WHERE S.user_id = U.id";

            return $this->get_data($query);
        }
    }

    public function getShopsByUserId()
    {
        $query = "SELECT S.name nameS, S.num_phone numPhoneS, S.address addressS, S.create_at createS, S.description descriptionS, "; 
            $query .= " U.name nameU, U.num_phone numPhoneU, U.address addressU ";
            $query .= " FROM shops S, users U ";
            $query .= " WHERE S.user_id = U.id AND U.id = " . $_SESSION['id'] ;

            return $this->get_data($query);
    }


    public function createShop($data)
    {
        $shop = [
            'user_id' => $_SESSION['id'],
            'name' => $data['txt-name'],
            'num_phone' => $data['txt-num-phone'],
            'address' => $data['txt-address'],
            'description' => $data['txt-description'],
            'create_at' => date("Ymd")
        ];

        $isCreate = $this->insert('shops', $shop);
        if(!$isCreate) {
            echo '<script>window.location="?create=fail"</script>';
            return $shop;
        }
        echo '<script>window.location="./shop_list.php?create=success"</script>';
        return [];
    }

    public function validate()
    {
        if(isset($_GET['create']) && $_GET['create'] == 'fail') {
            echo '<script>alert("Create new shop fail !!!")</script>';
            return;
        }
        if(isset($_GET['create']) && $_GET['create'] == 'success') {
            echo '<script>alert("Create new shop success !!!")</script>';
            return;
        }
    }
    
}