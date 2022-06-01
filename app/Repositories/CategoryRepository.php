<?php 

<<<<<<< HEAD
include_once 'BaseRepository.php';
=======
// include 'BaseRepository.php';
>>>>>>> af8797c8364776efbd8b5c1123ab40073b4641a4

class CategoryRepository extends BaseRepository
{
    //ktra code da ton tai trong dl chua
    public function isExistCode(string $code)
    {
        $category = $this->get_data("SELECT * FROM categories WHERE code = '$code'");
        return count($category) ? true : false;
    }
    //ktra ten co bi trung k
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
    public function selectByCode_category($code)
    {
        $category = $this->get_data("SELECT * FROM categories WHERE code = '$code'");
        return $category;
    }
    //creat category
    public function Insert_category(array $data)
    {
            $code=trim($data['tcode']);
            $name=trim($data['tname']);
            $description=trim($data['tmota']);

            
            if($this->isExistCode($data['tcode']) or $this->isExistName($data['tname']))
            {
                echo '<script>alert("Danh mục đã tồn tại!")</script>';
            }

            else{
                $category = [
                    'code'        => $code,
                    'name'        => $name,
                    'description' => $description
                ];
                $a = $this->insert('categories', $category);
                echo '<script>alert("Them danh muc thanh cong")</script>';
                // return $category;
                
                if($a){
                    mkdir("../../public/images/$code", 0777);
                    return $code;

                }
            }
    }
    
    
    // public function update_category('Categories', $data, $category)
    public function Update_category(array $data)
    {

            // $code=trim($data['tcode']);
            $name=trim($data['tname']);
            $description=trim($data['tmota']);

            if($this->isExistCode($data['tcode'] == $_GET['updateCode']))//????????
            {
                $category = [
                    // 'code'        => $code,
                    'name'        => $name,
                    'description' => $description
                ];
                $update = $this->update('categories', $category, $_GET['updateCode']);
                echo '<script>alert("Update successful category")</script>';
            }
            else
            {
                echo "Update category failed";
            }
    }

}