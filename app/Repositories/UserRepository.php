<?php

<<<<<<< HEAD
include_once 'BaseRepository.php';
=======
// include 'BaseRepository.php';
>>>>>>> af8797c8364776efbd8b5c1123ab40073b4641a4

class UserRepository extends BaseRepository
{
    public function validate()
    {
        if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
            echo '<script>alert("Logout success !")</script>';
        }
    }

    function isDigits(string $s, int $minDigits = 9, int $maxDigits = 14): bool 
    {
        return preg_match('/^[0-9]{'.$minDigits.','.$maxDigits.'}\z/', $s);
    }

    function isValidTelephoneNumber(string $telephone, int $minDigits = 9, int $maxDigits = 14): bool 
    {
        $telephone = str_replace([' ', '.', '-', '(', ')'], '', $telephone); 
    
        return $this->isDigits($telephone, $minDigits, $maxDigits); 
    }

    public function getInfoByNumPhone(string $numPhone)
    {
        return $this->get_data("SELECT * FROM users WHERE num_phone = '$numPhone'");
    }

    public function checkLogin(string $numPhone)
    {
        return $this->get_data("SELECT * FROM users WHERE num_phone = '$numPhone' OR name = '$numPhone' OR email = '$numPhone'");
    }

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
            echo '<script>alert("Sign up success !")</script>';
            return $user;
        }
    }
    
    public function signIn(array $data)
    {
        if(empty($data['txt-num-phone']) || empty($data['password'])) {
            echo '<script>alert("Vui lòng nhập đầy đủ thông tin !")</script>';
            return false;
        }

        $phone = $this->checkLogin($data['txt-num-phone']);

        if(!count($phone)) {
            echo '<script>alert("Number phone not exist !")</script>';
            return false;
        }

        if(!password_verify($_POST['password'], $phone[0]['password_hash'])) {
            echo '<script>alert("Password fail !")</script>';
            return false ;
        }
        $_SESSION['username'] = $phone[0]['name'];
        $_SESSION['role'] = $phone[0]['permission'];
        $_SESSION['id'] = $phone[0]['id'];
        // header('location: home.php?login=true');
        // var_dump($_SESSION);
        return true;
    }

    public function getInfoById(int $id)        
    {
        return $this->get_data("SELECT * FROM users WHERE id = $id")[0];
    }

    public function userUpdate(array $data)
    {
        
        $isNumPhone = $this->isValidTelephoneNumber($data['txt-num-phone']);
        $isName = strpos($data['txt-name'], ' ');
        $isPw = strpos($data['password'], ' ') && count($data['password']) >= 4;
        
        if(empty($data['txt-num-phone']) || empty($data['password'])) {
            echo 'Please enter infomation !';
            return;
        }
         $phone = $this->getInfoByNumPhone($data['txt-num-phone']);

        if(count($phone) >= 2) {
            echo '<script>alert("Number phone not exist !")</script>';
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
            echo '<script>alert("Update infomation success !");  window.location="./user_update.php";</script>';
            return $user;
        }
    }

   

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
