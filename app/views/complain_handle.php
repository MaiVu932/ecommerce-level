<?php
include 'header.php';
include '../Repositories/UserRepository.php';
include '../Repositories/ComplainRepository.php';
include '../Repositories/ProductRepository.php';
include '../Repositories/ShopRepository.php';
include '../Repositories/NotificationRepository.php';

$_USER = new UserRepository();
$_COMPLAIN = new ComplainRepository();
$_PRODUCT = new ProductRepository();
$_SHOP = new ShopRepository();
$_NOTIFICATION = new NotificationRepository();

$user = $_USER->getUser(); // Lấy thông tin của người dùng
/** Kiểm tra xem người dùng có phải người kiểm duyệt hay không, nếu không thì chuyển hướng về trang chủ */
if ($user['permission'] < 2) {
	echo '<script>
					alert("Bạn không phải là người kiểm duyệt !");
					window.location = "home.php";
				</script>';
	exit;
}

$id = (int)$_GET['id'];
$complain = $_COMPLAIN->getComplainById($id); // Lấy thông tin của đơn khiếu nại
/** Kiểm tra xem đơn khiếu nại có tồn tại hay không */
if (empty($complain)) {
	echo '<script>
					alert("Không tồn tại đơn khiếu nại này !");
					window.location = "complain_list.php";
				</script>';
	exit;
}

/** Nếu tình trạng đơn khiếu nại là duyệt hoặc không duyệt thì cập nhật tình trạng thành: "Đang chờ duyệt" */
if ($complain['status'] != 0 && $complain['status'] != 1) {
	$status = [
		'id' => $id,
		'status' => 2 // Đang chờ duyệt
	];
	$_COMPLAIN->updateStatus($status); // Cập nhật tình trạng đơn khiếu nại thành: "Đang chờ duyệt"
}

/** Hàm check hàng giả từ lý do khiếu nại */
function checkCounterfeitFromReason($reason)
{
	$keywords = array('giả', 'nhái'); // Từ khoá cần check

	$counterfeit = false; // Đặt giá trị mặc định của hàng giả = false
	foreach ($keywords as $key) {
		$isIncludeKeyword = strpos($reason, $key); // Nếu tìm thấy từ khoá ở trên trong lý do khiếu nại thì trả về true ngược lại không tìm thấy trả về false
		/** Kiểm tra xem có chứa từ khoá trong lý do khiếu nại hay không? */
		if ($isIncludeKeyword)
			$counterfeit = true; // Đặt giá trị hàng giả = true
	}

	return $counterfeit; // Trả về kết quả của hàm bằng true hoặc false tuỳ thuộc theo có tìm thấy từ khoá trong lý do khiếu nại hay không?
}

/** Nếu người kiểm duyệt bấm nút Duyệt */
if (isset($_POST['approve'])) {
	$product = $_PRODUCT->getProductById($complain['product_id']); // Lấy thông tin của sản phẩm theo product_id của đơn khiếu nại
	$shop = $_SHOP->getShopById($product['shop_id']); // Lấy thông tin của shop theo shop_id của sản phẩm đã lấy được ở trên
	$userIdShop = $shop['user_id']; // Lấy user_id của shop bị khiếu nại

	$approve = [
		'user_id' => $userIdShop,
		'notifiable_id' => $id
	];
	$_COMPLAIN->approve($approve); // Duyệt
	
	$numberOfViolations = $_COMPLAIN->getNumberOfViolations($userIdShop); // Lấy số lần bị khiếu nại của shop
	$counterfeit = checkCounterfeitFromReason($complain['content']); // Kiểm tra xem có phải hàng giả hay không, dựa theo lý do khiếu nại có chứa từ khoá đã liệt kê trong hàm checkCounterfeitFromReason hay không?

	/** Nếu duyệt trên 5 lần hoặc hàng giả thì khoá tài khoản */
	if ($numberOfViolations >= 5 || $counterfeit) {
		$_USER->deleteUserById($userIdShop); // Khoá tài khoản của shop bị khiếu nại
	}
}

/** Nếu người kiểm duyệt bấm nút Không duyệt */
if (isset($_POST['notApprove'])) {
	$notApprove = [
		'user_id' => $complain['user_id'],
		'notifiable_id' => $id
	];
	$_COMPLAIN->notApprove($notApprove); // Không duyệt
}

echo '<link rel="stylesheet" href="' . CSS . 'complain.css" />';
echo '<script src="' . JS . 'complain.js" defer></script>';
?>

<section id="complain">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li class="active">Xử lý khiếu nại </li>
			</ol>
		</div>

		<h2 class="title text-center">Xử lý khiếu nại </h2>

		<div class="complain-create">
			<form method="POST">
				<?php
				$product = $_PRODUCT->getProductById($complain['product_id']); // Lấy thông tin của sản phẩm theo product_id của đơn khiếu nại
				$shop = $_SHOP->getShopById($product['shop_id']); // Lấy thông tin của shop theo product_id của sản phẩm đã được lấy ở trên
				$counterfeit = checkCounterfeitFromReason($complain['content']); // Kiểm tra xem có phải hàng giả hay không, dựa theo lý do khiếu nại có chứa từ khoá đã liệt kê trong hàm checkCounterfeitFromReason hay không?
				?>
				<div class="info">
					<div class="detail">
						<span><?= $product['name'] ?></span>
						<span>Số lượng: <?= $product['quantity'] ?></span>
						<span>Bán bởi: <?= $shop['name'] ?></span>
						<span>Số lần vi phạm: <?=
																	$_COMPLAIN->getNumberOfViolations($shop['user_id']) ?></span>
					</div>
					<div class="image">
						<img src="<?php echo IMAGES . $product['image'] ?>" alt="">
					</div>
				</div>
				<br>
				<h4>Người khiếu nại</h4>
				<p><?= $_USER->getUserbyId($complain['user_id'])['name'] ?></p>
				<br>
				<h4>Lý do khiếu nại</h4>
				<p><?= $complain['content'] ?></p>
				<h4>Trạng thái khiếu nại</h4>
				<p>
					<?php
					if ($complain['status'] === '0')
						echo 'Duyệt';
					elseif ($complain['status'] === '1')
						echo 'Không duyệt';
					elseif ($complain['status'] === '2')
						echo 'Đang chờ duyệt';
					else
						echo 'Mới';
					?>
				</p>
				<div class="info">
					<i style="flex: 1">Ngày tạo đơn: <?= date_format(date_create($complain['create_at']), 'd/m/Y') ?></i>
					<button type="submit" name="approve" class="btn btn-primary pull-right"
					<?php
					/** Nếu hàng giả thì hiện ra thông báo */
					if ($counterfeit)
						echo 'onclick="return confirm(\'Shop này bán hàng giả. Bạn có chắc chắn muốn khoá tài khoản này vĩnh viễn không?\');"';
					?>>Duyệt</button>
					<button type="submit" name="notApprove" class="btn btn-primary pull-right cancel"> Không Duyệt</button>
				</div>
			</form>
		</div>
</section>

<?php include 'footer.php' ?>