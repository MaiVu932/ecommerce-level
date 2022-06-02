<?php
include 'header.php';
include_once '../Repositories/ComplainRepository.php';

$_COMPLAIN = new ComplainRepository();

/** Kiểm tra xem người dùng có phải người kiểm duyệt, Admin hay không, nếu không thì chuyển hướng về trang chủ */
if (!isset($_SESSION['role']) || $_SESSION['role'] < 2) {
	echo '<script>
					alert("Bạn không phải là người kiểm duyệt hoặc quản trị viên !");
					window.location = "home.php";
				</script>';
	exit;
}

$complains = $_COMPLAIN->getListComplain(); // Lấy thông tin của tất cả đơn khiếu nại

echo '<link rel="stylesheet" href="' . CSS . 'complain.css" />';
echo '<script src="' . JS . 'complain.js" defer></script>';
?>

<section id="complain">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li class="active">Danh sách khiếu nại </li>
			</ol>
		</div>

		<h2 class="title text-center">Danh sách khiếu nại </h2>

		<div class="complain-create">

			<?php
			if (!empty($complains)) { // Kiểm tra xem danh sách khiếu nại có trống hay không?
				foreach ($complains as $complain) {
					$product = $_COMPLAIN->getProductById($complain['product_id']); // Lấy thông tin của sản phẩm theo product_id của đơn khiếu nại đó
					echo '
					<div class="list">
						<div class="info">
							<div class="image">
								<img src="' . IMAGES . $product['code'] . '/' . $product['image'] . '" alt="">
							</div>
							<div class="detail-list">
								<span>' . $product['name'] . '</span>
								<span>Số lượng: ' . $product['quantity'] . '</span>
								<span>Người khiếu nại</span>
								<p>' . $_COMPLAIN->getUserbyId($complain['user_id'])['name'] . '</p>
								<span>Trạng thái khiếu nại</span>
								<p>';
					if ($complain['status'] === '0')
						echo 'Duyệt';
					elseif ($complain['status'] === '1')
						echo 'Không duyệt';
					elseif ($complain['status'] === '2')
						echo 'Đang chờ duyệt';
					else
						echo 'Mới';
					echo '
								</p>
								<i style="flex: 1">Ngày tạo đơn: ' . date_format(date_create($complain['create_at']), 'd/m/Y') . '</i>
								<br>
								<a href="complain_handle.php?id=' . $complain['id'] . '">
									<button type="submit" class="btn btn-primary">Xem chi tiết</button>
								</a>
							</div>
						</div>
					</div>';
				}
			} else {
				echo '
				<h1 style="text-align: center">Danh sách khiếu nại trống</h1>';
			}
			?>

		</div>
</section>

<?php include 'footer.php' ?>