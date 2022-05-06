<?php 

include 'BaseRepository.php';

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
    public function selectByCode_category($code)
    {
        $category = $this->get_data("SELECT * FROM categories WHERE code = '$code'");
        return $category;
    }
    //
    public function SetCode(string $code)
    {
        // $category = $this->get_data("SELECT * FROM categories WHERE code = '$code'");
        // return count($category) ? true : false;
    }
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
                // header('location:category_list.php');    
                // return $category;
                if($a){
                    mkdir("../../public/images/$code", 0777);
                    return $code;

                }
            }
    }

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