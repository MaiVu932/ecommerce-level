<?php 

include 'BaseRepository.php';

class CategoryRepository extends BaseRepository
{
<<<<<<< HEAD
=======
    //ktra code da ton tai trong dl chua
>>>>>>> c1a0d5a03e8cf151577d005fdd20dc2048414a82
    public function isExistCode(string $code)
    {
        $category = $this->get_data("SELECT * FROM categories WHERE code = '$code'");
        return count($category) ? true : false;
    }
<<<<<<< HEAD
=======
    //ktra ten co bi trung k
>>>>>>> c1a0d5a03e8cf151577d005fdd20dc2048414a82
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
<<<<<<< HEAD
    //
    public function SetCode(string $code)
    {
        // $category = $this->get_data("SELECT * FROM categories WHERE code = '$code'");
        // return count($category) ? true : false;
    }
=======
    //creat category
>>>>>>> c1a0d5a03e8cf151577d005fdd20dc2048414a82
    public function Insert_category(array $data)
    {
            $code=trim($data['tcode']);
            $name=trim($data['tname']);
            $description=trim($data['tmota']);

<<<<<<< HEAD

=======
            
>>>>>>> c1a0d5a03e8cf151577d005fdd20dc2048414a82
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
<<<<<<< HEAD
                // header('location:category_list.php');    
                // return $category;
=======
                // return $category;
                
>>>>>>> c1a0d5a03e8cf151577d005fdd20dc2048414a82
                if($a){
                    mkdir("../../public/images/$code", 0777);
                    return $code;

                }
            }
    }
<<<<<<< HEAD

    public function Update_category(array $data)
    {

            $code=trim($data['tcode']);
            $name=trim($data['tname']);
            $description=trim($data['tmota']);
            var_dump($this->isExistCode($data['tcode'] == $_GET['updateCode']));

            if($this->isExistCode($data['tcode'] == $_GET['updateCode']))
            {
                $category = [
                    'code'        => $code,
                    'name'        => $name,
                    'description' => $description
                ];
                $category = $this->update('categories', $category, $_GET['updateCode']);
                echo '<script>alert("Update successful category")</script>';
            }
            
            else
            {
                echo '<script>alert("Update category failed")</script>';
                
            }
            
    }

    public function delete_category($code)
    {
        $category = $this->delete('categories','code ="'.$code.'"');
        return $category;
    }

} 
=======
    
    
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
>>>>>>> c1a0d5a03e8cf151577d005fdd20dc2048414a82
