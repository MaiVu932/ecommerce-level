<?php 

// include 'BaseRepository.php';

class CategoryRepository extends BaseRepository
{
    public function isExistCode(string $code)
    {
        $category = $this->get_data("SELECT * FROM categories WHERE code = '$code'");
        return count($category) ? true : false;
    }
    public function isExistName(string $name)
    {
        $category = $this->get_data("SELECT * FROM categories WHERE name = '$name'");
        return count($category) ? true : false;
    }
    public function select_category()
    {
        $category = $this->get_data("SELECT * FROM categories ");
        return $category;
    }
    public function select_userById($id)
    {
        $sql = "SELECT permission FROM `users` WHERE id = '$id'";
        $category = $this->get_data($sql);
        return $category;
    }
    public function selectByID_category($id)
    {
        $category = $this->get_data(" SELECT * FROM `categories` WHERE id = '$id' ");
        return $category;
    }

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
    public function Insert_category(array $data)
    {
            $code=trim($data['tcode']);
            $name=trim($data['tname']);
            $description=trim($data['tmota']);

            $validateCode = $this->validateCode($code);
            if(count($validateCode) > 0){
                echo "<script>alert('Ma Danh mục khong hop le')</script>";
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
                            alert("Them danh muc thanh cong");
                            window.location = ("category_list.php");
                        </script>';
                    mkdir("../../public/images/$code", 0777);
                    return $code;

                }
            }
    }

    
    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM `categories` WHERE id = '$id'";
        $category = $this->get_data($sql);
        return $category;
    }
    public function Update_category(array $data)
    {
        $category = [
            // 'code' => $data['code'],
            'name' => $data['name'],
            'description' => $data['description'],
        ];
        $where = "id = ". $data['id'];
        $this->update('categories', $category, $where);
        echo '<script>alert("Update successful"); window.location=("category_list.php")</script>';
        return $category;
                
    }
            

    // public function delete_category($id, $code)
    // {
        
    //     $delete = $this->delete('categories','id ="'.$id.'"');
    //     return $delete;

    //     if($delete
    //     ){
    //         $status = unlink($code, "../../public/image/");
    //         echo '
    //             <script>
    //                 alert("Xóa danh muc thanh cong");
    //                 window.location = ("category_list.php");
    //             </script>';
    //         // rmdir("../../public/images/" . $code , 0777);
    //         // return $code;
    //     }

    // }

} 
