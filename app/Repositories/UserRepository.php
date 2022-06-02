<?php

// include 'BaseRepository.php';

class UserRepository extends BaseRepository
{
    
    /**
     * validate: xác thực
     * 
     *
     * @return void
     */
    public function validate()
    {
        if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
            echo '<script>alert("Đăng xuất thành công !")</script>';
        }
    }

    /**
     * isDigits : xác thực độ dài số điện thoại
     *
     * @param string $s
     * @param integer $minDigits
     * @param integer $maxDigits
     * @return boolean
     */
    function isDigits(string $s, int $minDigits = 9, int $maxDigits = 14): bool 
    {
        return preg_match('/^[0-9]{'.$minDigits.','.$maxDigits.'}\z/', $s);
    }

    /**
     * isvalidTelephoneNumber: xác thực thành phần số điện thoại
     *
     * @param string $telephone
     * @param integer $minDigits
     * @param integer $maxDigits
     * @return boolean
     */
    function isValidTelephoneNumber(string $telephone, int $minDigits = 9, int $maxDigits = 14): bool 
    {
        $telephone = str_replace([' ', '.', '-', '(', ')'], '', $telephone); 
    
        return $this->isDigits($telephone, $minDigits, $maxDigits); 
    }

    /**
     * getInfoByNumberPhone: lấy thông tin người dùng từ số điện thoại
     *
     * @param string $numPhone
     * @return void
     */
    public function getInfoByNumPhone(string $numPhone)
    {
        return $this->get_data("SELECT * FROM users WHERE num_phone = '$numPhone'");
    }

    /**
     * checkLogin: kiểm tra người dùng đăng nhập thành công hay không 
     *
     * @param string $numPhone
     * @return void
     */
    public function checkLogin(string $numPhone)
    {
        return $this->get_data("SELECT * FROM users WHERE num_phone = '$numPhone' OR name = '$numPhone' OR email = '$numPhone'");
    }

    /**
     * signUp: đăng ký tài khoản người dùng 
     *
     * @param array $data
     * @return void
     */
    public function signUp(array $data)
    {
        // $isNumPhone = $this->isValidTelephoneNumber($data['txt-num-phone']);
        $isNumPhone = is_numeric($data['txt-num-phone']);
        $isName = strpos($data['txt-name'], ' ');
        $isPw = strpos($data['password'], ' ') && count($data['password']) >= 4;
        
        if(empty($data['txt-num-phone']) || empty($data['password'])) {
            echo '<script> alert("Vui lòng nhập đầy đủ thông tin !") </script>';
            return;
        }
        if(count($this->getInfoByNumPhone($data['txt-num-phone'])) > 0) {
            echo '<script>alert("Thông tin đăng ký không hợp lệ !")</script>';
            return;
        }
      

        if($isNumPhone && !$isName && !$isPw) {
            $user = [
                'permission' => 0,
                'name' => trim($data['txt-name']),
                'address' => trim($data['txt-address']),
                'num_phone' => trim($data['txt-num-phone']),
                'password_current' => trim($data['password']),
                'password_hash' => password_hash(trim($data['password']), PASSWORD_DEFAULT),
                'create_at' => date("Ymd")
            ];

            $this->insert('users', $user);
            echo '<script>alert("Đăng ký tài khoản thành công !!!")</script>';
            return $user;
        }
    }
    
    /**
     * singIn: đăng nhập tài khoản người dùng
     *
     * @param array $data
     * @return void
     */
    public function signIn(array $data)
    {
        if(empty($data['txt-num-phone']) || empty($data['password'])) {
            echo '<script>alert(" Vui lòng nhập đầy đủ thông tin !")</script>';
            return false;
        }

        $phone = $this->checkLogin($data['txt-num-phone']);

        if(!count($phone)) {
            echo '<script>alert("Số điện thoại không tồn tại !!!")</script>';
            return false;
        }

        if(!password_verify($_POST['password'], $phone[0]['password_hash'])) {
            echo '<script>alert("Mật khẩu không đúng !!!")</script>';
            return false ;
        }
        $_SESSION['username'] = $phone[0]['name'];
        $_SESSION['role'] = $phone[0]['permission'];
        $_SESSION['id'] = $phone[0]['id'];
        return true;
    }

    /**
     * getInfoById: lấy thông tin người dùng qua mã người dùng
     *
     * @param integer $id
     * @return void
     */
    public function getInfoById(int $id)        
    {
        return $this->get_data("SELECT * FROM users WHERE id = $id")[0];
    }

    /**
     * userUpdate: Cập nhật thông tin người dùng.
     *
     * @param array $data
     * @return void
     */
    public function userUpdate(array $data)
    {
        
        $isNumPhone = $this->isValidTelephoneNumber($data['txt-num-phone']);
        $isName = strpos($data['txt-name'], ' ');
        $isPw = strpos($data['password'], ' ') && count($data['password']) >= 4;
        
        if(empty($data['txt-num-phone']) || empty($data['password'])) {
            echo 'Vui lòng nhập đầy đủ thông tin !!!';
            return;
        }
         $phone = $this->getInfoByNumPhone($data['txt-num-phone']);

        if(count($phone) >= 2) {
            echo '<script>alert("Số điện thoại không tồn tại !!!")</script>';
            return false;
        } 

        if($isNumPhone && !$isName && !$isPw) {
            $user = [
                'name' => trim($data['txt-name']),
                'address' => trim($data['txt-address']),
                'num_phone' => trim($data['txt-num-phone']),
                'password_current' => trim($data['password']),
                'password_hash' => password_hash(trim($data['password']), PASSWORD_DEFAULT),
            ];
            $this->update('users', $user, " id = '" . $data['id'] . "'");
            $_SESSION['username'] = $user['name'];
            $_SESSION['role'] = $_SESSION['role'];
            $_SESSION['id'] = $data['id'];
            echo '<script>alert("Cập nhật thông tin thành công !");  window.location="./user_update.php";</script>';
            return $user;
        }
    }

   /**
    * getUsers: tìm kiếm người dùng.
    *
    * @param [type] $page
    * @param [type] $nameS
    * @param [type] $dateS
    * @param [type] $role
    * @return void
    */
    public function getUsers(
        $page = null,
        $nameS = null,
        $dateS = null,
        $role = null
    )
    {
       
        if(!$nameS && !$dateS && !$role) {
            $query = " SELECT * FROM users";

            return $this->get_data($query);
        }

        if($nameS && $dateS && $role) {
            if($role == 6) {
                $role = 0;
            }
            $query = " SELECT * FROM users WHERE permission = " . $role . " AND create_at = '" . $dateS . "' AND ( name LIKE '%" . $nameS . "%' ";
            $query .= " OR  address LIKE '%" . $nameS . "%' ";
            $query .= " OR  num_phone LIKE '%" . $nameS . "%' ) ";

            return $this->get_data($query);
        }

        if($nameS && $dateS) {
            $query = " SELECT * FROM users WHERE create_at = '" . $dateS . "' AND ( name LIKE '%" . $nameS . "%' ";
            $query .= " OR  address LIKE '%" . $nameS . "%' ";
            $query .= " OR  num_phone LIKE '%" . $nameS . "%' ) ";

            return $this->get_data($query);
        }

        if($nameS && $role) {
            if($role == 6) {
                $role = 0;
            }
            $query = " SELECT * FROM users WHERE permission = " . $role . " AND ( name LIKE '%" . $nameS . "%' ";
            $query .= " OR  address LIKE '%" . $nameS . "%' ";
            $query .= " OR  num_phone LIKE '%" . $nameS . "%' ) ";

            return $this->get_data($query);
        }

        if($role && $dateS) {
            if($role == 6) {
                $role = 0;
            }
            $query = " SELECT * FROM users WHERE permission = " . $role . " AND create_at = '". $dateS ."'";

            return $this->get_data($query);
        }

        if($nameS) {
            $query = " SELECT * FROM users WHERE name LIKE '%" . $nameS . "%' ";
            $query .= " OR  address LIKE '%" . $nameS . "%' ";
            $query .= " OR  num_phone LIKE '%" . $nameS . "%' ";

            return $this->get_data($query);
        }

        if($dateS) {
            $query = " SELECT * FROM users WHERE create_at = '" . $dateS . "' ;";

            return $this->get_data($query);
        }

        if($role) {
            if($role == 6) {
                $role = 0;
            }
            $query = " SELECT * FROM users WHERE permission = " . $role . " ;";

            return $this->get_data($query);
        }
       
    }


    
}
