<?php

include 'BaseRepository.php';

class UserRepository extends BaseRepository
{

    function isDigits(string $s, int $minDigits = 9, int $maxDigits = 14): bool {
        return preg_match('/^[0-9]{'.$minDigits.','.$maxDigits.'}\z/', $s);
    }

    function isValidTelephoneNumber(string $telephone, int $minDigits = 9, int $maxDigits = 14): bool {
        $telephone = str_replace([' ', '.', '-', '(', ')'], '', $telephone); 
    
        return $this->isDigits($telephone, $minDigits, $maxDigits); 
    }

    public function isExistNumPhone(string $numPhone)
    {
        $user = $this->get_data("SELECT * FROM users WHERE num_phone = $numPhone");
        return count($user) ? true : false;
        // 0, null, undefine, false, '' 
    }

    public function signUp(array $data)
    {
        $isNumPhone = $this->isValidTelephoneNumber($data['txt-num-phone']);
        $isName = strpos($data['txt-name'], ' ');
        $isPw = strpos($data['password'], ' ');

        if($this->isExistNumPhone($data['txt-num-phone'])) {
            echo '<script>alert("Number phone is exists !")</script>';
            return;
        }

        if($isNumPhone && !$isName && !$isPw) {
            $user = [
                'role_id' => 1,
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
  


}