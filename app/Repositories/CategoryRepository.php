<?php 

// include 'BaseRepository.php';

class CategoryRepository extends BaseRepository
{
    /**
     * isExitCode: kiểm tra code của danh mục đã tồn tại hay chưa
     *
     * @param string $code
     * @return boolean
     */
    public function isExistCode(string $code)
    {
        $category = $this->get_data("SELECT * FROM categories WHERE code = '$code'");
        return count($category) ? true : false;
    }

    /**
     * isExitName: kiểm tra xem tên danh mục đã tồn tại hay chưa
     *
     * @param string $name
     * @return boolean
     */
    public function isExistName(string $name)
    {
        $category = $this->get_data("SELECT * FROM categories WHERE name = '$name'");
        return count($category) ? true : false;
    }

    /**
     * select_category: Lấy ra thông tin danh mục
     *
     * @return array
     */
    public function select_category()
    {
        $category = $this->get_data("SELECT * FROM categories ");
        return $category;
    }

    /**
     * select_userById: lấy thông tin người dùng
     *
     * @param [type] $id
     * @return void
     */
    public function select_userById($id)
    {
        $sql = "SELECT permission FROM `users` WHERE id = '$id'";
        $category = $this->get_data($sql);
        return $category;
    }

    /**
     * selectById_category: lấy ra thông tin của danh mục
     *
     * @param [type] $id
     * @return void
     */
    public function selectByID_category($id)
    {
        $category = $this->get_data(" SELECT * FROM `categories` WHERE id = '$id' ");
        return $category;
    }

    /**
     * validate: xác thực dữ liệu
     *
     * @param [type] $code
     * @return void
     */
    public function validateCode($code)
    {
            $errors = [];
            $notAllow = ['&', '=', '_', "'", '-', '+', ',', '>', '<', '..'];

            if (stripos($code, ' ')) {
                $errors['code'] = 'Mã danh mục không được chứa dấu cách';
            }

            for($i=0; $i<strlen($code); $i++) {
            if(in_array($code[$i], $notAllow)) {
                $errors['code'] = "Mã danh mục không chứa các ký tự đặc biệt:'&', '=', '_', '-', '+', ',', '>', '<', '..' ";
                break;
                }
            }

            return $errors;
    }

    /**
     * Insert_category: thêm mới danh mục
     *
     * @param array $data
     * @return void
     */
    public function Insert_category(array $data)
    {
            $code=trim($data['tcode']);
            $name=trim($data['tname']);
            $description=trim($data['tmota']);

            $validateCode = $this->validateCode($code);
            if(count($validateCode) > 0){
                echo "<script>alert('Mã danh mục không hợp lệ')</script>";
                return $validateCode;
            }

            if($this->isExistCode($code) or $this->isExistName($name))
            {
                echo '<script>alert("Danh mục đã tồn tại!")</script>';
            }

            else{
                $category = [
                    'code'        => $code,
                    'name'        => $name,
                    'description' => $description
                ];
                $insert = $this->insert('categories', $category);
                if($insert){
                    echo '
                        <script>
                            alert("Thêm danh mục thành công");
                            window.location = ("category_list.php");
                        </script>';
                    mkdir("../../public/images/$code", 0777);
                    return $code;

                }
            }
    }

    /**
     * getCategoryById: lấy thông tin cảu một danh mục
     *
     * @param [type] $id
     * @return void
     */
    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM `categories` WHERE id = '$id'";
        $category = $this->get_data($sql);
        return $category;
    }
    
    /**
     * Update_category: cập nhật thông tin danh mục
     *
     * @param array $data
     * @return void
     */
    public function Update_category(array $data)
    {
        $category = [
            // 'code' => $data['code'],
            'name' => $data['name'],
            'description' => $data['description'],
        ];
        $where = "id = ". $data['id'];
        $this->update('categories', $category, $where);
        echo '<script>alert("Cập nhật danh mục thành công!!"); window.location=("category_list.php")</script>';
        return $category;
                
    }

} 
