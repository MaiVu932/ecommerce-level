<?php
include_once 'BaseRepository.php';

class UserRepository extends BaseRepository
{
    function isDigits(string $s, int $minDigits = 9, int $maxDigits = 14): bool
    {
        return preg_match('/^[0-9]{' . $minDigits . ',' . $maxDigits . '}\z/', $s);
    }

    function isValidTelephoneNumber(string $telephone, int $minDigits = 9, int $maxDigits = 14): bool
    {
        $telephone = str_replace([' ', '.', '-', '(', ')'], '', $telephone);

        return $this->isDigits($telephone, $minDigits, $maxDigits);
    }

    public function isExistNumPhone(string $numPhone)
    {
        $user = $this->get_data("SELECT * FROM users WHERE num_phone = $numPhone");
        return count($user) ? true : false;
        // 0, null, undefine, false, '' 
    }

    public function isLogin(string $numPhone, string $password)
    {
        $user = $this->get_data("SELECT * FROM users WHERE num_phone = $numPhone AND password_current = '$password'");
        return count($user) ? true : false;
        // 0, null, undefine, false, '' 
    }

    public function signUp(array $data)
    {
        $isNumPhone = $this->isValidTelephoneNumber($data['txt-num-phone']);
        $isName = strpos($data['txt-name'], ' ');
        $isPw = strpos($data['password'], ' ');

        if ($this->isExistNumPhone($data['txt-num-phone'])) {
            echo '<script>
                    alert("Số điện thoại đã tồn tại !");
                  </script>';
            return;
        }

        if ($isNumPhone && !$isName && !$isPw) {
            $user = [
                'permission' => 1,
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

    public function login(array $data)
    {
        $isNumPhone = $this->isValidTelephoneNumber($data['txt-num-phone']);
        $isPw = strpos($data['password'], ' ');

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
