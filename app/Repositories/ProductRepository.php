<?php
    // include('BaseRepository.php');
    class ProductRepository extends BaseRepository{
        public function getCategories()
        {
            $sql = "SELECT * FROM categories";
            $data = $this->get_data($sql);
            return $data;
        }

        public function getShops()
        {
            $sql = "SELECT * FROM shops WHERE user_id = '1'";
            $data = $this->get_data($sql);
            return $data;
        }

        public function getProducts()
        {
            $sql = "SELECT * FROM products";
            $data = $this->get_data($sql);
            return $data;
        }

        public function validateCodeProduct($code)
        {
            // var_dump($data);
            // return;

            $errors = [];
            $notAllow = ['&', '=', '_', "'", '-', '+', ',', '>', '<', '..'];

            if (stripos($code, ' ')) {
                $errors['pcode'] = 'Mã code sản phẩm không chứa dấu cách';
            }

            for($i=0; $i<strlen($code); $i++) {
            if(in_array($code[$i], $notAllow)) {
                $errors['Pcode'] = "Mã code không chứa các ký tự đặc biết:'&', '=', '_', '-', '+', ',', '>', '<', '..' ";
                break;
                }
            }

            return $errors;
        }

        public function isExitCode ($code)
        {
            $sql = "SELECT * FROM products WHERE code = '$code'";
            $product = $this->get_data($sql); 
            return count($product) ? true : false;
        
        }

        public function getCodeCategoryById($categoryId)
        {
            $sql = "SELECT * FROM categories WHERE id = '$categoryId'";
            $data = $this->get_data($sql);
            return $data;
        }

        public function UpLoadImage($data,$category_id)
        {
            $categoryCode = $this->getCodeCategoryById($category_id)[0]['code'];

            $UploadErr = [];
            if(!isset($_FILES['image'])){
                $UploadErr['exitImage'] = 'File ảnh không tồn tại !';

            }

            $temp_name = $_FILES['image']['tmp_name'];
            $file_size = $_FILES['image']['size'];
            $type = explode('/', $_FILES['image']['type']);
            $extension = end($type);
            $allowed = ['png', 'jpg', 'jpeg', 'jfif'];

            if(!in_array($extension, $allowed)){

                $UploadErr['typeImage'] = 'File phải có định dạng png, jpg, jpeg, ifif ';
            }

            if($file_size >= 5000000){

                $UploadErr['sizeImage'] = 'Dung lượng file quá lớn !';
            }
            
            if(count($UploadErr)>0){
                var_dump($UploadErr);
                echo "loi Image 1";
                return [
                    'extension' => $extension,
                    'err' => $UploadErr,
                ];
            }
            $path = '../../public/images/'. $categoryCode . '/' . $data . '.' . $extension;

            $is_upload_success = move_uploaded_file($temp_name, $path);

            if(!$is_upload_success){

                $UploadErr['stageImage'] = 'Thêm ảnh thất bại !';

            }

            return [
                'extension' => $extension,
                'err' => $UploadErr,
            ];

        }

        public function createProducts(array $data)
        {
            
                $shopName = trim($data['shop-name']);
                $categoriesName = trim($data['category-name']);
                $code = trim($data['product-code']);
                $name = trim($data['product-name']);
                $price = (double)trim($data['product-price']);
                $priceMarket = (double)trim($data['product-priceMarket']);
                $quantity = (double)trim($data['product-quantity']);
                $unit = trim($data['product-unit']);
                $describe = trim($data['product-describe']);
                $errors = []; 

                if(empty($shopName) || empty($categoriesName) || empty($code) || empty($name) || empty($price) 
                    || empty($priceMarket) || empty($unit) || empty($quantity) || empty($describe) ){
                    
                    echo 'loi trong';
                    $errors['emptyData'] = "Các trường có (*) không được bỏ trống!!";
                    return $errors;
                }
                
                $validateCode = $this->validateCodeProduct($code);
               
                if(count($validateCode)>0){
                    
                    echo "Loi code";
                    return $validateCode;
                }

                $UpImage = $this->UpLoadImage($code, $categoriesName);

                $image = $code . '.' . $UpImage['extension'];
                
                if( $this->isExitCode($data['product-code']))
                {

                    echo "<script>alert('Mã code sản phẩm đã tồn tại!!!')</script>";
                    return;

                }
                
                    $product = [
                        'shop_id'            => $shopName,
                        'category_id'        => $categoriesName,
                        'status'             => 3,
                        'code'               => $code,
                        'name'               => $name,
                        'price_market'       => $priceMarket,
                        'price_historical'   => $price,
                        'quantity'           => $quantity,
                        'unit'               => $unit,
                        'image'              => $image,
                        'description'        => $describe,     
                    ];

                    $insert = $this->insert('products', $product);
                    if($insert){
                        echo "<script>alert('Bạn đã thêm sản phẩm THÀNH CÔNG!!!')</script>";
                    }
                    else{
                        echo "<script>alert('Bạn đã thêm sản phẩm THẤT BẠI!!!')</script>";
                    }
                
        }

        public function getInfoProduct()
        {
            $sql = "SELECT p.id, c.id 'id-category', c.name 'name-category', s.id 'id-shop',
                    s.name 'name-shop', p.code, p.name, p.price_market, p.price_historical, p.quantity, 
                    p.unit, p.image, p.description, p.status, p.reason_refusal
                    FROM `products` p, `categories` c, `shops` s
                    WHERE p.category_id = c.id AND p.shop_id = s.id";
            $data = $this->get_data($sql);
            return($data);
        }

        public function validate()
        {
            if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
                echo '<script>alert("Logout success !")</script>';
            }
        }

    }
?>