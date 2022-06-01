<?php
include 'header.php';
// include_once '../Repositories/SaleRevenue.php';
// include_once '../Repositories/ShopRepository.php';
// include_once '../Repositories/NotificationRepository.php';
include_once '../Repositories/ComplainRepository.php';
// include_once '../Repositories/ProductRepository.php';

// $_COMPLAIN = new SaleRevenue();
// $_COMPLAIN = new ShopRepository();
// $_COMPLAIN = new NotificationRepository();
$_COMPLAIN = new ComplainRepository();
// $_COMPLAIN = new ProductRepository();

/** Kiểm tra xem người dùng đã đăng nhập hay chưa, nếu chưa thì chuyển hướng về trang đăng nhập */
if (!isset($_SESSION['id'])) {
	echo '<script>
					alert("Bạn chưa đăng nhập !");
					window.location = "user_login.php";
				</script>';
	exit;
}

$shops = $_COMPLAIN->getAllShopByUserId($_SESSION['id']); // Lấy thông tin tất cả shop của người dùng
$countNotification = $_COMPLAIN->countNotification($_SESSION['id']);
$notifications = $_COMPLAIN->getNotificationByUserId($_SESSION['id']); // Lấy tất cả thông báo của người dùng

echo '<link rel="stylesheet" href="' . CSS . 'salerevenue.css" />';
echo '<script src="' . JS . 'salerevenue.js" defer></script>';
?>

<section id="salerevenue">
  <div class="container">
    <div class="breadcrumbs">
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li class="active">Thông báo </li>
      </ol>
    </div>

    <h2 class="title text-center">Thông báo </h2>

    <div class="row salerevenue-list">

      <?php
      if (!empty($notifications)) {
        foreach ($notifications as $notification) {
          /** Update thành đã xem thông báo */
          $status = [
            'id' => $notification['id'],
            'status' => 0 // Đã xem
          ];
          $_COMPLAIN->updateStatusNotification($status);

          $complain = $_COMPLAIN->getComplainByNotifiableId($notification['notifiable_id']); // Lấy thông tin của đơn khiếu nại theo notifiable_id
          $product = $_COMPLAIN->getProductById($complain['product_id']); // Lấy thông tin của sản phẩm theo product_id của đơn khiếu nại
          $shop = $_COMPLAIN->getShopById($product['shop_id']); // Lấy thông tin của shop theo product_id của sản phẩm đã được lấy ở trên
          $userShop = $_COMPLAIN->getUserbyId($shop['user_id']); // Lấy thông tin ngươi dùng của shop
          $numberOfViolations = $_COMPLAIN->getNumberOfViolations($shop['user_id']); // Số lần vi phạm của shop

          // var_dump($complain);
          // var_dump($product);
          // var_dump($shop);
          // var_dump($userShop);
          if ($complain['commentable_type'] == 1) {
            if ($complain['status'] === '0') {
              if ($_SESSION['id'] != $shop['user_id']) {
                echo '<div class="panel panel-success">
                        <div class="panel-heading">
                          <p class="panel-title">
                          Khiếu nại người dùng <b>' . $userShop['name'] . '</b> thành công
                          </p>
                        </div>
                      </div>';
              } else {
                echo '<div class="panel panel-warning">
                        <div class="panel-heading">
                          <p class="panel-title">
                          Cảnh báo vi phạm lần thứ <b>' . $numberOfViolations . '</b>, lí do <b>' . $complain['content'] . ',</b> tài khoản của bạn sẽ bị khoá nếu tiếp tục vi phạm đến lần thứ <b>5</b>
                          </p>
                        </div>
                      </div>';
              }
            } else if ($complain['status'] === '1') {
              echo '<div class="panel panel-danger">
                        <div class="panel-heading">
                          <p class="panel-title">
                          Khiếu nại người dùng <b>' . $userShop['name'] . '</b> không thành công
                          </p>
                        </div>
                      </div>';
            } else {
              echo '<div class="panel panel-info">
                      <div class="panel-heading">
                        <p class="panel-title">
                        Đơn khiếu nại người dùng <b>' . $userShop['name'] . '</b> của bạn đã được tạo. Vui lòng chờ duyệt
                        </p>
                      </div>
                    </div>';
            }
          }
        }
      } else {
        echo '
        <h2 class="text-center">Danh sách trống</h2>';
      }
      ?>

    </div>

</section>

<?php include 'footer.php' ?>