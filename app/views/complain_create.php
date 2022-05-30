<?php
include 'header.php';
include '../Repositories/OrderRepository.php';
include '../Repositories/ComplainRepository.php';


$_ORDER = new OrderRepository();
$_COMPLAIN = new ComplainRepository();

$user = $_COMPLAIN->getUser(); // Lấy thông tin của người dùng
/** Kiểm tra xem người dùng đã đăng nhập hay chưa, nếu chưa thì chuyển hướng về trang đăng nhập */
if (!$user) {
	echo '<script>
					alert("Bạn chưa đăng nhập !");
					window.location = "login.php";
				</script>';
	exit;
}

$id = (int)$_GET['id'];
$product = $_ORDER->getProductByOrderId($id); // Lấy thông tin của sản phẩm
/** Kiểm tra xem sản phẩm có tồn tại hay không */
if (!isset($product)) {
	echo '<script>
					alert("Sản phẩm không tồn tại !");
					window.location = "order_history.php";
				</script>';
	exit;
}

/** Nếu bấm vào nút Tạo đơn */
if (isset($_POST['create'])) {
	$_COMPLAIN->createComplain($_POST, $user['id'], $product['id']); // Tạo đơn khiếu nại
}


echo '<link rel="stylesheet" href="' . CSS . 'complain.css" />';
echo '<script src="' . JS . 'complain.js" defer></script>';
?>

<section id="complain">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li class="active">Tạo đơn khiếu nại </li>
			</ol>
		</div>

		<h2 class="title text-center">Tạo đơn khiếu nại </h2>

		<div class="complain-create">
			<div class="info">
				<div class="detail">
					<span><?= $product['name'] ?></span>
					<span>Số lượng: <?= $product['quantity'] ?></span>
				</div>
				<div class="image">
					<img src="<?php echo IMAGES ?><?= $product['image'] ?>" alt="">
				</div>
			</div>
			<br>
			<form method="POST">
				<h4>Nhập lý do khiếu nại</h4>
				<textarea name="content" rows="6"></textarea>
				<div class="info">
					<i>Ngày tạo đơn: <?= date('d/m/Y', time()) ?></i>
					<button type="submit" name="create" class="btn btn-primary pull-right">Tạo đơn</button>
				</div>
			</form>
		</div>
</section>

<?php include 'footer.php' ?>