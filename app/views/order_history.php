<?php
include 'header.php';
include_once '../Repositories/ComplainRepository.php';

$_COMPLAIN = new ComplainRepository();

/** Kiểm tra xem người dùng đã đăng nhập hay chưa, nếu chưa thì chuyển hướng về trang đăng nhập */
if (!isset($_SESSION['id'])) {
	echo '<script>
					alert("Bạn chưa đăng nhập !");
					window.location = "user_login.php";
				</script>';
	exit;
}

$histories = $_COMPLAIN->getHistoryByUserId($_SESSION['id']);

echo '<link rel="stylesheet" href="' . CSS . 'complain.css" />';
echo '<script src="' . JS . 'complain.js" defer></script>';
?>

<section id="complain">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li class="active">Lịch sử mua hàng </li>
			</ol>
		</div>

		<h2 class="title text-center">Lịch sử mua hàng </h2>

		<div class="complain-create">

			<?php
			if (!empty($histories)) {
				foreach ($histories as $history) {
					echo '
					<div class="list">
						<div class="info">
							<div class="image">
								<img src="' . IMAGES . '' . $history['code'] . '/' . $history['image'] . '" alt="">
							</div>
							<div class="detail-list">
								<span>' . $history['name'] . '</span>
								<span>Số lượng: ' . $history['quantity'] . '</span>
								<span>Tình trạng</span>
								<p>Đã giao</p>
								<span>Địa chỉ</span>
								<p>' . $history['address'] . '</p>
								<span>Số điện thoại</span>
								<p>' . $history['num_phone'] . '</p>
								<br>
								<a href="complain_create.php?id=' . $history['order_id'] . '">
									<button type="submit" class="btn btn-primary">Khiếu nại</button>
								</a>
							</div>
						</div>
					</div>';
				}
			} else {
				echo '
				<h1 style="text-align: center">Lịch sử mua hàng trống</h1>';
			}
			?>

		</div>
</section>

<?php include 'footer.php' ?>