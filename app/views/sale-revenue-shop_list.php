<?php
include 'header.php';
include '../Repositories/SaleRevenue.php';

$_SALEREVENUE = new SaleRevenue();

/** Kiểm tra xem người dùng đã đăng nhập hay chưa, nếu chưa thì chuyển hướng về trang đăng nhập */
if (!isset($_SESSION['id'])) {
	echo '<script>
					alert("Bạn chưa đăng nhập !");
					window.location = "user_login.php";
				</script>';
	exit;
}

$shops = $_SALEREVENUE->getAllShopByUserId($_SESSION['id']); // Lấy thông tin tất cả shop của người dùng

echo '<link rel="stylesheet" href="' . CSS . 'salerevenue.css" />';
echo '<script src="' . JS . 'salerevenue.js" defer></script>';
?>

<section id="salerevenue">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li class="active">Doanh số - Doanh thu của shop </li>
			</ol>
		</div>

		<h2 class="title text-center">Chọn Shop cần xem doanh số - doanh thu </h2>

		<div class="row salerevenue-list">

			<?php
			if (!empty($shops)) {
				$colors = array('warning', 'success', 'info', 'danger');
				$i = 0;
				foreach ($shops as $shop) {
					echo '<div class="panel panel-' . $colors[$i] . '">
						<div class="panel-heading">
							<h3 class="panel-title">' . $shop['name'] . '</h3>
						</div>
						<div class="panel-body">
							<p>' . $shop['description'] . '</p>
							<a href="sale-revenue-shop_detail.php?id=' . $shop['id'] . '">
								<button type="button" class="btn btn-primary">Xem chi tiết</button>
							</a>
						</div>
					</div>';
					$i++;
					if ($i == 4) $i = 0;
				}
			} else {
				echo '
				<h2 class="text-center">Danh sách trống</h2>';
			}
			?>

		</div>

</section>

<?php include 'footer.php' ?>