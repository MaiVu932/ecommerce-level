<?php
include_once 'BaseRepository.php';

class UserRepository extends BaseRepository
{
<<<<<<< HEAD
    function isDigits(string $s, int $minDigits = 9, int $maxDigits = 14): bool
    {
        return preg_match('/^[0-9]{' . $minDigits . ',' . $maxDigits . '}\z/', $s);
    }

    function isValidTelephoneNumber(string $telephone, int $minDigits = 9, int $maxDigits = 14): bool
    {
        $telephone = str_replace([' ', '.', '-', '(', ')'], '', $telephone);

        return $this->isDigits($telephone, $minDigits, $maxDigits);
=======
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
>>>>>>> 1ddd87c5365c72a40962919636ed44c03f6c0f9b
    }

    public function getInfoByNumPhone(string $numPhone)
    {
        return $this->get_data("SELECT * FROM users WHERE num_phone = '$numPhone'");
    }

    public function isLogin(string $numPhone, string $password)
    {
        $user = $this->get_data("SELECT * FROM users WHERE num_phone = $numPhone AND password_current = '$password'");
        return count($user) ? true : false;
        // 0, null, undefine, false, '' 
    }

    public function signUp(array $data)
    {
        // $isNumPhone = $this->isValidTelephoneNumber($data['txt-num-phone']);
        $isNumPhone = is_numeric($data['txt-num-phone']);
        $isName = strpos($data['txt-name'], ' ');
<<<<<<< HEAD
        $isPw = strpos($data['password'], ' ');

        if ($this->isExistNumPhone($data['txt-num-phone'])) {
            echo '<script>
                    alert("Số điện thoại đã tồn tại !");
                  </script>';
=======
        $isPw = strpos($data['password'], ' ') && count($data['password']) >= 4;
        
        if(empty($data['txt-num-phone']) || empty($data['password'])) {
            echo '<script> alert("Please enter infomation !") </script>';
            return;
        }
        if(count($this->getInfoByNumPhone($data['txt-num-phone'])) > 0) {
            echo '<script>alert("Number phone is exists !")</script>';
>>>>>>> 1ddd87c5365c72a40962919636ed44c03f6c0f9b
            return;
        }
      

        if ($isNumPhone && !$isName && !$isPw) {
            $user = [
<<<<<<< HEAD
                'permission' => 1,
=======
                'permission' => 0,
>>>>>>> 1ddd87c5365c72a40962919636ed44c03f6c0f9b
                'name' => trim($data['txt-name']),
                'address' => trim($data['txt-address']),
                'num_phone' => trim($data['txt-num-phone']),
                'password_current' => trim($data['password']),
                'password_hash' => password_hash(trim($data['password']), PASSWORD_DEFAULT),
                'create_at' => date("Ymd")
            ];

            $this->insert('users', $user);
            echo '<script>
                    alert("Đăng ký thành công !");
                  </script>';
            return $user;
        }
    }
<<<<<<< HEAD
=======
    
    public function signIn(array $data)
    {
        if(empty($data['txt-num-phone']) || empty($data['password'])) {
            echo '<script>alert("Please enter infomation !")</script>';
            return false;
        }

        $phone = $this->getInfoByNumPhone($data['txt-num-phone']);

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

    public function shopsOfUserId()
    {
        $query = "SELECT id, name FROM shops WHERE user_id = " + $_SESSION['id'];
        return $this->get_data($query);
    }
>>>>>>> 1ddd87c5365c72a40962919636ed44c03f6c0f9b

    public function login(array $data)
    {
        $isNumPhone = $this->isValidTelephoneNumber($data['txt-num-phone']);
        $isPw = strpos($data['password'], ' ');

<<<<<<< HEAD
        if (!$this->isExistNumPhone($data['txt-num-phone'])) {
            echo '<script>
                    alert("Số điện thoại không tồn tại!");
                  </script>';
            return;
        }

        if (true) {
            $user = [
                'num_phone' => trim($data['txt-num-phone']),
                'password_current' => $data['password']
            ];

            if ($this->isLogin($user['num_phone'], $user['password_current'])) {
                $_SESSION['num_phone'] = $user['num_phone'];
                $_SESSION['password'] = $user['password_current'];
                echo '<script>
                        alert("Đăng nhập thành công !");
                        window.location = "home.php";
                      </script>';
            } else {
                echo '<script>
                        alert("Sai mật khẩu !");
                      </script>';
                return;
            }
        }
    }

    public function getUserbyId($id)
    {
        $user = $this->get_data("SELECT * FROM users WHERE id = $id");
        return isset($user[0]) ? $user[0] : null;
    }

    public function deleteUserById($id)
    {
        $notifications = $this->delete('notifications', "user_id = $id");
        $shops = $this->delete('shops', "user_id = $id");
        $users = $this->delete('users', "id = $id");
        echo '<script>
                alert("Xoá tài khoản thành công !");
              </script>';
        return;
    }
}
=======
    
}

?>
>>>>>>> 1ddd87c5365c72a40962919636ed44c03f6c0f9b
