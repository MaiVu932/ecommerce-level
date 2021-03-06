<?php

// include 'BaseRepository.php';

class ShopRepository extends BaseRepository
{

    /**
     * checkExist: kiểm tra shop đã tồn tại hay chưa
     *
     * @param [type] $id
     * @return void
     */
    public function checkExist($id)
    {
        $query = "SELECT id FROM shops WHERE id = $id ";
        $query .= " AND user_id = " . $_SESSION['id'];
        
        return count($this->get_data($query)) ? true : false;
    }

    /**
     * getInfoShopById: lấy thông tin của shop qua mã shop
     *
     * @param [type] $id
     * @return void
     */
    public function getInfoShopById($id)
    {
        if(!$this->checkExist($id)) {
            echo '<script>alert("Bạn không có quyền truy cập !!!")</script>';
            return;
        }

        $query = "SELECT * FROM shops WHERE id = $id ";
        $query .= " AND user_id = " . $_SESSION['id'];
        
        return $this->get_data($query)[0];
    }

    /**
     * updateByIdShop: cập nhật thông tin shop qua mã shop
     *
     * @param [type] $data
     * @param [type] $id
     * @return void
     */
    public function updateByIdShop($data, $id)
    {
        if(!$this->checkExist($id)) {
            echo '<script>alert("Bạn không có quyền truy cập !!!")</script>';
            return;
        }

        $shop = [
            'name' => $data['txt-name'],
            'num_phone' => $data['txt-num-phone'],
            'description' => $data['txt-description'],
            'address' => $data['txt-address']
        ];

        
        if(!$this->update('shops', $shop, 'id = ' . $id)) {
            echo '<script>alert("Cập nhập thất bại !!!")</script>';
            return;
        }

        echo '<script>alert("Cập nhập thành công !!!")</script>';
        return;
    }

    /**
     * getShops: lấy thông tin của shop
     *
     * @param [type] $page
     * @param [type] $nameS
     * @param [type] $dateS
     * @return void
     */
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

    /**
     * getShopsByUserId: lấy thông tin của shop qua mã người dùng
     *
     * @param [type] $page
     * @param [type] $nameS
     * @param [type] $dateS
     * @return void
     */
    public function getShopsByUserId(
        $page = null,
        $nameS = null,
        $dateS = null,
    )
    {
        if(!$nameS && !$dateS) {
            $query = "SELECT S.id id, S.name nameS, S.num_phone numPhoneS, S.address addressS, S.create_at createS, S.description descriptionS, "; 
            $query .= " U.name nameU, U.num_phone numPhoneU, U.address addressU ";
            $query .= " FROM shops S, users U ";
            $query .= " WHERE S.user_id = U.id AND U.id = " . $_SESSION['id'] ;

            return $this->get_data($query);
        }

        if($nameS && $dateS) {
            $query = "SELECT S.id id, S.name nameS, S.num_phone numPhoneS, S.address addressS, S.create_at createS, S.description descriptionS, "; 
            $query .= " U.name nameU, U.num_phone numPhoneU, U.address addressU ";
            $query .= " FROM shops S, users U ";
            $query .= " WHERE S.user_id = U.id AND U.id = " . $_SESSION['id'] ;
            $query .= " AND S.create_at = '" . $dateS . "'";
            $query .= " AND (S.name LIKE '%" . $nameS . "%' OR S.num_phone LIKE '%" . $nameS;
            $query .= "%' OR U.num_phone LIKE '%" . $nameS . "%' OR U.name LIKE '%". $nameS . "%' )";

            return $this->get_data($query);
        }


        if($nameS) {
            $query = "SELECT S.id id, S.name nameS, S.num_phone numPhoneS, S.address addressS, S.create_at createS, S.description descriptionS, "; 
            $query .= " U.name nameU, U.num_phone numPhoneU, U.address addressU ";
            $query .= " FROM shops S, users U ";
            $query .= " WHERE S.user_id = U.id AND U.id = " . $_SESSION['id'] ;
            $query .= " AND (S.name LIKE '%" . $nameS . "%' OR S.num_phone LIKE '%" . $nameS;
            $query .= "%' OR U.num_phone LIKE '%" . $nameS . "%' OR U.name LIKE '%". $nameS . "%' )";

            return $this->get_data($query);
        }

        if($dateS) {
            $query = "SELECT S.id id, S.name nameS, S.num_phone numPhoneS, S.address addressS, S.create_at createS, S.description descriptionS, "; 
            $query .= " U.name nameU, U.num_phone numPhoneU, U.address addressU ";
            $query .= " FROM shops S, users U ";
            $query .= " WHERE S.user_id = U.id AND U.id = " . $_SESSION['id'] ;
            $query .= " AND S.create_at = '" . $dateS . "' ;";

            return $this->get_data($query);
        }

       
       
    }

    /**
     * createShop: tạo shop mới
     *
     * @param [type] $data
     * @return void
     */
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
        $isUpdateUser = $this->update('users', ['permission' => 1], 'id = ' . $_SESSION['id']);

        if(!$isCreate || !$isUpdateUser) {
            echo '<script>window.location="?create=fail"</script>';
            return $shop;
        }

        $_SESSION['role'] = 1;
        echo '<script>alert("Tạo shop thành công !!"); window.location="./shop_list.php"</script>';
        return [];
    }

    /**
     * validate: xác thực dữ liệu
     *
     * @return void
     */
    public function validate()
    {
        if(isset($_GET['create']) && $_GET['create'] == 'fail') {
            echo '<script>alert("Tạo shop thất bại !!!")</script>';
            return;
        }
        if(isset($_GET['create']) && $_GET['create'] == 'success') {
            echo '<script>alert("Tạo shop thành công !!!")</script>';
            return;
        }
        if(isset($_GET['update']) && $_GET['update'] == 'false') {
            echo '<script>alert("Shop bạn muốn cập nhập không tồn tại !!!")</script>';
            return;
        }
    }
    
}