<?php
    // include('BaseRepository.php');
    class ProductRepository extends BaseRepository
    {
        public function getCategories()
        {
            $sql = "SELECT * FROM categories";
            $data = $this->get_data($sql);
            return $data;
        }

        public function getShops()
        {
            $sql = "SELECT * FROM shops WHERE user_id = " . $_SESSION['id'] . " AND id = " . $_GET['id'];
            $data = $this->get_data($sql);
            return $data[0];
        }

        public function getProducts(
            $category = null,
            $page = null
        )
        {
            if($page && $category) {
                $page_current = (int)$_GET['page'];
                $start = ($page_current - 1) * 12;

                $query = " SELECT P.id product_id, P.code product_code, P.name product_name, P.price_market product_price, P.image product_image, C.code ";
                $query .= " FROM products P, categories C WHERE C.id = P.category_id ";
                $query .= " AND P.category_id = " . $category . "  ORDER BY P.create_at DESC LIMIT 12 OFFSET " . $start ;

                return $this->get_data($query);
            }

            if(!$page && $category) {
                $page_current = 1;
                $start = ($page_current - 1) * 12;

                $query = " SELECT P.id product_id, P.code product_code, P.name product_name, P.price_market product_price, P.image product_image, C.code ";
                $query .= " FROM products P, categories C WHERE C.id = P.category_id ";
                $query .= " AND P.category_id = " . $category . "  ORDER BY P.create_at DESC LIMIT 12 OFFSET " . $start ;

                return $this->get_data($query);
            }


            if(!$category && !$page) {
                $page_current = 1;
                $start = ($page_current - 1) * 12;

                $query = " SELECT P.id product_id , P.code product_code, P.name product_name, P.price_market product_price, P.image product_image, C.code ";
                $query .= " FROM products P, categories C WHERE C.id = P.category_id ";
                $query .= " ORDER BY P.create_at DESC LIMIT 12 OFFSET " . $start ;

                return $this->get_data($query);
            }

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

            if(!isset($_FILES['image'])){
                return 'File ảnh không tồn tại !';

            }

            $temp_name = $_FILES['image']['tmp_name'];
            $file_size = $_FILES['image']['size'];
            $type = explode('/', $_FILES['image']['type']);
            $extension = end($type);
            $allowed = ['png', 'jpg', 'jpeg', 'jfif'];

            if(!in_array($extension, $allowed)){
                return 'File phải có định dạng png, jpg, jpeg, ifif ';
            }

            if($file_size >= 5000000){
                return 'Dung lượng file quá lớn !';
            }
            
            
            $path = '../../public/images/'. $categoryCode . '/' . $data . '.' . $extension;

            $is_upload_success = move_uploaded_file($temp_name, $path);

            if(!$is_upload_success){
                return 'Thêm ảnh thất bại !';
            }

            return '';

        }

        public function createProducts(array $data)
        {
            
                $shopName = trim($data['shop-name']);
                $categoryName = trim($data['category-name']);
                $code = trim($data['product-code']);
                $name = trim($data['product-name']);
                $price = (double)trim($data['product-price']);
                $priceMarket = (double)trim($data['product-priceMarket']);
                $quantity = (double)trim($data['product-quantity']);
                $unit = trim($data['product-unit']);
                $describe = trim($data['product-describe']);
                

                if(empty($shopName) || empty($categoryName) || empty($code) || empty($name) || empty($price) 
                    || empty($priceMarket) || empty($unit) || empty($quantity) || empty($describe) ){
                    
                        echo "<script>alert('Các trường thông tin không được bỏ trống!!!')</script>";
                        return ;
                }
                
                $validateCode = $this->validateCodeProduct($code);
               
                if(count($validateCode)>0){
                    
                    echo "<script>alert('Mã code không hợp lệ!!!')</script>";
                    return $validateCode;
                }
                
                if( $this->isExitCode($data['product-code']))
                {

                    echo "<script>alert('Mã code sản phẩm đã tồn tại!!!')</script>";
                    return;

                }

                $UpImage = $this->UpLoadImage($code, $categoryName);
                if (strlen($UpImage) > 0) {
                    echo "<script>alert('" . $UpImage . "')</script>";
                    return;
                }

                $type = explode('/', $_FILES['image']['type']);
                $image = $code . '.' . end($type);
                
                
                    $product = [
                        'shop_id'            => $shopName,
                        'category_id'        => $categoryName,
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
                    echo "<pre>";
                    print_r($product);
                    echo "</pre>";
                    $insert = $this->insert('products', $product);
                    if($insert){
                        echo 
                            "<script>
                                alert('Bạn đã thêm sản phẩm THÀNH CÔNG!!!'); 
                                window.location = 'ProductList.php?id=" . $_GET['id'] . "';
                            </script>";
                        return;
                    }
                    else{
                        echo "<script>alert('Bạn đã thêm sản phẩm THẤT BẠI!!!')</script>";
                        return;
                    }
                
        }

        public function getInfoProductByShopId(
            $name = null,
            $category = null,
            $status = null
        )
        {
            
            
            if($name && $category && $status) {
                if($status == 6) {
                    $status = 0;
                }
                $query = "SELECT p.id, c.id 'id-category',c.code 'code-category', c.name 'name-category', s.id 'id-shop',
                s.name 'name-shop', p.code, p.name, p.price_market, p.price_historical, p.quantity, 
                p.unit, p.image, p.description, p.status, p.reason_refusal
                FROM `products` p, `categories` c, `shops` s
                WHERE p.category_id = c.id AND p.shop_id = s.id AND s.id = " . $_GET['id'] . " AND p.name LIKE '%" . $name . "%' AND p.category_id = " . $category . " AND p.status = " . $status ;
                $data = $this->get_data($query);
                return($data);
            }

            if($name && $category) {
                $query = "SELECT p.id, c.id 'id-category',c.code 'code-category', c.name 'name-category', s.id 'id-shop',
                s.name 'name-shop', p.code, p.name, p.price_market, p.price_historical, p.quantity, 
                p.unit, p.image, p.description, p.status, p.reason_refusal
                FROM `products` p, `categories` c, `shops` s
                WHERE p.category_id = c.id AND p.shop_id = s.id AND s.id = " . $_GET['id'] . " AND p.name LIKE '%" . $name . "%' AND p.category_id = " . $category ;
                $data = $this->get_data($query);
                return($data);
            }

            if($category && $status) {
                if($status == 6) {
                    $status = 0;
                }
                $query = "SELECT p.id, c.id 'id-category',c.code 'code-category', c.name 'name-category', s.id 'id-shop',
                s.name 'name-shop', p.code, p.name, p.price_market, p.price_historical, p.quantity, 
                p.unit, p.image, p.description, p.status, p.reason_refusal
                FROM `products` p, `categories` c, `shops` s
                WHERE p.category_id = c.id AND p.shop_id = s.id AND s.id = " . $_GET['id'] . " AND p.category_id = " . $category . " AND status = " . $status ;
                $data = $this->get_data($query);
                return($data);
            }
            if($name && $status) {
                if($status == 6) {
                    $status = 0;
                }
                $query = "SELECT p.id, c.id 'id-category',c.code 'code-category', c.name 'name-category', s.id 'id-shop',
                s.name 'name-shop', p.code, p.name, p.price_market, p.price_historical, p.quantity, 
                p.unit, p.image, p.description, p.status, p.reason_refusal
                FROM `products` p, `categories` c, `shops` s
                WHERE p.category_id = c.id AND p.shop_id = s.id AND s.id = " . $_GET['id'] . " AND p.name LIKE '%" . $name . "%' AND status = " . $status ;
                $data = $this->get_data($query);
                return($data);
            }

            if($category) {
                $query = "SELECT p.id, c.id 'id-category',c.code 'code-category', c.name 'name-category', s.id 'id-shop',
                s.name 'name-shop', p.code, p.name, p.price_market, p.price_historical, p.quantity, 
                p.unit, p.image, p.description, p.status, p.reason_refusal
                FROM `products` p, `categories` c, `shops` s
                WHERE p.category_id = c.id AND p.shop_id = s.id AND s.id = " . $_GET['id'] . " AND c.id = " . $category ;
                $data = $this->get_data($query);
                return($data);
            }

            if($name) {
                $query = "SELECT p.id, c.id 'id-category',c.code 'code-category', c.name 'name-category', s.id 'id-shop',
                    s.name 'name-shop', p.code, p.name, p.price_market, p.price_historical, p.quantity, 
                    p.unit, p.image, p.description, p.status, p.reason_refusal
                    FROM `products` p, `categories` c, `shops` s
                    WHERE p.category_id = c.id AND p.shop_id = s.id AND s.id = " . $_GET['id'] . " AND p.name LIKE '%" . $name . "%' " ;
                $data = $this->get_data($query);
                return($data);

            }

            if($status) {
                if($status == 6) {
                    $status = 0;
                }
                $query = "SELECT p.id, c.id 'id-category',c.code 'code-category', c.name 'name-category', s.id 'id-shop',
                    s.name 'name-shop', p.code, p.name, p.price_market, p.price_historical, p.quantity, 
                    p.unit, p.image, p.description, p.status, p.reason_refusal
                    FROM `products` p, `categories` c, `shops` s
                    WHERE p.category_id = c.id AND p.shop_id = s.id AND s.id = " . $_GET['id'] . " AND p.status = " . $status ;
                $data = $this->get_data($query);
                return($data);
                
            }

            if(!$name && !$category && !$status) {
                $query = "SELECT p.id, c.id 'id-category',c.code 'code-category', c.name 'name-category', s.id 'id-shop',
                    s.name 'name-shop', p.code, p.name, p.price_market, p.price_historical, p.quantity, 
                    p.unit, p.image, p.description, p.status, p.reason_refusal
                    FROM `products` p, `categories` c, `shops` s
                    WHERE p.category_id = c.id AND p.shop_id = s.id AND s.id = " . $_GET['id'] ;
                $data = $this->get_data($query);
                return($data);
            }

            
        }

        public function getInfoProduct()
        {
            $sql = "SELECT p.id, c.id 'id-category',c.code 'code-category', c.name 'name-category', s.id 'id-shop',
                    s.name 'name-shop', p.code, p.name, p.price_market, p.price_historical, p.quantity, 
                    p.unit, p.image, p.description, p.status, p.reason_refusal
                    FROM `products` p, `categories` c, `shops` s
                    WHERE p.category_id = c.id AND p.shop_id = s.id" ;
            $data = $this->get_data($sql);
            return($data);
        }

        public function getInfoProductById($productId)
        {
            $sql = "SELECT p.id, c.id 'category-id',c.code 'category-code', c.name 'category-name', s.id 'shop-id',
                    s.name 'shop-name', p.code, p.name, p.price_market, p.price_historical, p.quantity, 
                    p.unit, p.image, p.description, p.status, p.reason_refusal
                    FROM `products` p, `categories` c, `shops` s
                    WHERE p.category_id = c.id AND p.shop_id = s.id AND p.id = '$productId'";
            $data = $this->get_data($sql)[0];
            return $data;
        }

        public function updateProductNoImage($data, $id)
        {

            $shopName = trim($data['shop-name']);
            $categoryName = trim($data['category-name']);
            $code = trim($data['product-code']);
            $name = trim($data['product-name']);
            $price = (double)trim($data['product-price']);
            $priceMarket = (double)trim($data['product-priceMarket']);
            $quantity = (double)trim($data['product-quantity']);
            $unit = trim($data['product-unit']);
            $describe = trim($data['product-describe']);
            

            if(empty($name) || empty($price) || empty($priceMarket) || empty($unit) || empty($quantity) || empty($describe) ){
                    
                    echo "<script>alert('Các trường có * không được bỏ trống!!!')</script>";
                    return ;
            }

            $UpImage = $this->UpLoadImage($code, $categoryName);
                if (strlen($UpImage) > 0) {
                    echo "<script>alert('" . $UpImage . "')</script>";
                    return;
                }

                $type = explode('/', $_FILES['image']['type']);
                $image = $code . '.' . end($type);

            $product = [
                'shop_id'            => $shopName,
                'category_id'        => $categoryName,
                'code'               => $code,
                'name'               => $name,
                'price_market'       => $priceMarket,
                'price_historical'   => $price,
                'quantity'           => $quantity,
                'unit'               => $unit,
                'image'              => $image,
                'description'        => $describe,     
            ];

            $update = $this->update('products', $product, 'id = "'. $id . '"');
            if($update){
                echo 
                    "<script>
                        alert('Bạn đã sửa thông tin sản phẩm THÀNH CÔNG!!!');
                        window.location = ('ProductList.php');
                        </script>";
                return;
            }
            else{
                echo "<script>alert('Bạn đã sửa thông tin sản phẩm THẤT BẠI!!!')</script>";
                return;
            }

        }
        public function updateProductImage($data, $id)
        {
            $shopName = trim($data['shop-name']);
            $categoryName = trim($data['category-name']);
            $code = trim($data['product-code']);
            $name = trim($data['product-name']);
            $price = (double)trim($data['product-price']);
            $priceMarket = (double)trim($data['product-priceMarket']);
            $quantity = (double)trim($data['product-quantity']);
            $unit = trim($data['product-unit']);
            $describe = trim($data['product-describe']);
            

            if(empty($name) || empty($price) || empty($priceMarket) || empty($unit) || empty($quantity) || empty($describe) ){
                    
                    echo "<script>alert('Các trường có * không được bỏ trống!!!')</script>";
                    return ;
            }

            $product = [
                'shop_id'            => $shopName,
                'category_id'        => $categoryName,
                'code'               => $code,
                'name'               => $name,
                'price_market'       => $priceMarket,
                'price_historical'   => $price,
                'quantity'           => $quantity,
                'unit'               => $unit,
                'description'        => $describe,     
            ];

            echo "<pre>";
            print_r($product);
            echo "</pre>";
            return;

            $update = $this->update('products', $product, 'id = "'. $id . '"');
            if($update){
                echo 
                    "<script>
                        alert('Bạn đã sửa thông tin sản phẩm THÀNH CÔNG!!!');
                        window.location = ('ProductList.php');
                        </script>";
                return;
            }
            else{
                echo "<script>alert('Bạn đã sửa thông tin sản phẩm THẤT BẠI!!!')</script>";
                return;
            }
        }
        public function validate()
        {
            if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
                echo '<script>alert("Logout success !")</script>';
            }
        }

        public function updateStatus($id)
        {
            $product = [
                'status' => 1,
            ];
            $update = $this->update('products', $product, 'id = '. $id  );
        }
        
        public function updateReason($id)
        {
            $product = [
                'status' => 2,
                'reason_réual' => 'Sẩn phẩm của bạn không đạt yêu cầu.',
            ];
            $update = $this->update('products', $product, 'id = '. $id  );
        }

        public function postProduct()
        {
            $isUpdate = $this->update('products', ['status' => 0], 'id = ' . $_GET['id']);

            if(!$isUpdate) {
                echo '<script>alert("Đăng bán thất bại !!!")</script>';
                return;
            }
            $product = [
                'user_id' => 11,
                'notifiable_id' => $_GET['id'],
                'notifiable_type' => 2,
                'status' => 1
            ];

            $isInsertNotification = $this->insert('notifications', $product);
            if(!$isInsertNotification) {
                echo '<script>alert("Đăng bán thất bại !!!")</script>';
                return;
            } 

            echo '<script>alert("Chúng tôi sẽ phê duyệt sản phẩm của bạn trong thời gian ngắn nhất !!!"); window.location="./ProductList.php"; </script>';
            return;
            
        }
        
    }
?>