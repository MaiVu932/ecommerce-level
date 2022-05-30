<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
include 'header.php';
include '../Repositories/SaleRevenue.php';
include '../Repositories/ShopRepository.php';
include '../Repositories/ProductRepository.php';
include '../Repositories/OrderRepository.php';


$_SALEREVENUE = new SaleRevenue();
$_SHOP = new ShopRepository();
$_PRODUCT = new ProductRepository();
$_ORDER = new OrderRepository();

$user = $_SALEREVENUE->getUser(); // Lấy thông tin của người dùng
/** Kiểm tra xem người dùng có phải người kiểm duyệt, Admin hay không, nếu không thì chuyển hướng về trang chủ */
if ($user['permission'] < 2) {
	echo '<script>
					alert("Bạn không phải là người kiểm duyệt hoặc quản trị viên !");
					window.location = "home.php";
				</script>';
	exit;
}

$id = isset($_GET['id']) ? $_GET['id'] : 0;

$date = !empty($_GET['date']) ? sprintf("%02d", (int)$_GET['date']) : null; // Kiểm tra xem có nhập vào ngày hay không nếu có thì ép kiểu sang kiểu số nguyên và thêm số 0 vào đằng trước nếu ngày bé hơn 10. VD: 9 -> 09, 12 -> 12.
$month = !empty($_GET['month']) ? sprintf("%02d", (int)$_GET['month']) : null; // Kiểm tra xem có nhập vào tháng hay không nếu có thì ép kiểu sang kiểu số nguyên và thêm số 0 vào đằng trước nếu tháng bé hơn 10. VD: 9 -> 09, 12 -> 12.
$year = !empty($_GET['year']) ? (int)$_GET['year'] : null; // Kiểm tra xem có nhập vào năm hay không nếu có thì ép kiểu sang kiểu số nguyên.

$shops = $_SHOP->getAllShop(); // Lấy thông tin của tất cả các shop
$index = 0;
foreach ($shops as $shop) {
	$products = $_PRODUCT->getProductByShopId($shop['id']); // Lấy thông tin của sản phẩm theo từng shop

	/** Xử lý sắp xếp theo điều kiện */
	$productNew[$index] = array();
	$productNew[$index]['id'] = $shop['id'];
	$productNew[$index]['name'] = $shop['name'];
	$productNew[$index]['sale'] = 0;
	$productNew[$index]['revenue'] = 0;
	foreach ($products as $product) {
		/** Nếu chọn thống kê theo ngày, tháng, năm lấy tổng số lượng sản phẩm đã bán được trong ngày đó */
		$quantity = $_ORDER->getQuantityByProduct($product, $date, $month, $year); // Lấy tổng số lượng đã bán được theo ngày, tháng, năm nhập vào
		if ($quantity != null) {
			$productOld = $_SALEREVENUE->getSaleRevenueByQuantityAndProductId2($quantity, $product['id']); // Lấy doanh số, doanh thu của sản phẩm
			$productNew[$index]['sale'] += $productOld['sale'];
			$productNew[$index]['revenue'] += $productOld['revenue'];
		}
	}
	$index++;
}

/** Thuật toán sắp xếp chọn giảm dần */
function SelectionSortDescending($mang, $conditon)
{
	// Đếm tổng số phần tử của mảng
	$sophantu = count($mang);
	// Lặp để sắp xếp
	for ($i = 0; $i < $sophantu - 1; $i++) {
		// Tìm vị trí phần tử lớn nhất
		$max = $i;
		for ($j = $i + 1; $j < $sophantu; $j++) {
			if ($mang[$j][$conditon] > $mang[$max][$conditon]) {
				$max = $j;
			}
		}
		// Sau khi có vị trí lớn nhất thì hoán vị
		// với vị trí thứ $i
		$temp = $mang[$i];
		$mang[$i] = $mang[$max];
		$mang[$max] = $temp;
	}
	// Trả về mảng đã sắp xếp
	return $mang;
}

if (isset($_GET['revenue']))
	$productNew = SelectionSortDescending($productNew, 'revenue');

echo '<link rel="stylesheet" href="' . CSS . 'salerevenue.css" />';
echo '<script src="' . JS . 'salerevenue.js" defer></script>';
?>

<section id="salerevenue">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li class="active">Doanh số - Doanh thu của sàn </li>
			</ol>
		</div>

		<?php if (empty($year) && empty($month) && empty($date)) : ?>
			<h2 class="title text-center">Chọn thống kê theo ngày, tháng, năm</h2>
			<div class="alert alert-warning">
				<strong>Gợi ý:</strong> Để trống ngày nếu muốn thống kê theo tháng năm. Để trống ngày và tháng nếu muốn thống kê theo năm
			</div>
			<div class="row salerevenue-list">
				<form method="GET">
					<div class="date-list">
						<div class="date-label">
							<span class="salerevenue-label label-success">Ngày</span>
							<input class="salerevenue-date" name="date" type="number" min="01" max="31" step="1" value="<?= date('d', time()) ?>">
						</div>
						<div class="date-label">
							<span class="salerevenue-label label-primary">Tháng</span>
							<input class="salerevenue-date" name="month" type="number" min="01" max="12" step="1" value="<?= date('m', time()) ?>">
						</div>
						<div class="date-label">
							<span class="salerevenue-label label-warning">Năm</span>
							<input class="salerevenue-date" name="year" type="number" min="2022" max="2099" step="1" value="<?= date('Y', time()) ?>">
						</div>
					</div>
					<div class="salerevenue-button-group">
						<button type="submit" class="btn btn-primary">Thống kê</button>
					</div>
				</form>
			</div>
		<?php else : ?>
			<h2 class="title text-center">Doanh số - Doanh thu của sàn theo
				<?php
				/** Kiểm tra xem có nhập vào ngày, tháng, năm hay không */
				if (!empty($_GET['date']) && !empty($_GET['month']) && !empty($_GET['year'])) {
					echo "ngày $date-$month-$year";
				} else if (!empty($_GET['month']) && !empty($_GET['year'])) {
					echo "tháng $month-$year";
				} else if (!empty($_GET['year'])) {
					echo "năm $year";
				} else {
					echo 'null';
				}

				if (isset($_GET['sale']))
					echo ' | Sắp xếp theo doanh số';
				else if (isset($_GET['revenue']))
					echo ' | Sắp xếp theo doanh thu';
				?>
			</h2>

			<!-- <h4><span class="salerevenue-label label-success">TOÀN SÀN</span></h4> -->

			<table class="table salerevenue-table table-striped">
				<thead>
					<tr class="salerevenue-tr">
						<th>Mã shop</th>
						<th>Tên shop</th>
						<th>Doanh số của shop</th>
						<th>Doanh thu của shop</th>
					</tr>
				</thead>
				<tbody>
					<?php
					function isArrayEmpty(array $array): bool
					{
						foreach ($array as $key => $val) {
							if (!empty($val))
								return false;
						}
						return true;
					}
					if (!empty($productNew)) :
						$totalSale = 0;
						$totalRevenue = 0;
						foreach ($productNew as $product) :
							if ($product['sale'] != 0 && $product['revenue'] != 0) :
								$totalSale += $product['sale'];
								$totalRevenue += $product['revenue'];
								$getShop = $_SHOP->getShopById($product['id']);
								if ($totalSale != 0 && $totalRevenue != 0) :
					?>

									<tr onclick="location.href='/<?php echo "sale-revenue-shop_detail.php?id=$getShop[id]&date=$date&month=$month&year=$year"; ?>'">
										<td><?= $getShop['id'] ?></td>
										<td><?= $getShop['name'] ?></td>
										<td><?= $product['sale'] ?></td>
										<td><?= $product['revenue'] ?></td>
									</tr>
						<?php
								endif;
							endif;
						endforeach;
						?>
						<tr class="danger">
							<td class="salerevenue-bold">Tổng cộng:</td>
							<td class="salerevenue-bold"></td>
							<td class="salerevenue-bold"><?= $totalSale ?></td>
							<td class="salerevenue-bold"><?= $totalRevenue ?></td>
						</tr>
					<?php
					else :
						echo '<script>
						alert("Ngày tháng năm không tồn tại !");
						window.location = "sale-revenue-exchange.php";
					</script>';
						exit;
					endif;
					?>
				</tbody>
			</table>

			<form method="GET">
				<h4><span class="salerevenue-label label-success">Sắp xếp theo ngày, tháng, năm</span></h4>
				<div class="alert alert-warning">
					<strong>Gợi ý:</strong> Để trống ngày nếu muốn thống kê theo tháng năm. Để trống ngày và tháng nếu muốn thống kê theo năm
				</div>
				<div class="row salerevenue-list">
					<form method="GET">
						<div class="date-list">
							<div class="date-label">
								<span class="salerevenue-label label-success">Ngày</span>
								<input class="salerevenue-date" name="date" type="number" min="01" max="31" step="1" value="<?= $date ?>">
							</div>
							<div class="date-label">
								<span class="salerevenue-label label-primary">Tháng</span>
								<input class="salerevenue-date" name="month" type="number" min="01" max="12" step="1" value="<?= $month ?>">
							</div>
							<div class="date-label">
								<span class="salerevenue-label label-warning">Năm</span>
								<input class="salerevenue-date" name="year" type="number" min="2022" max="2099" step="1" value="<?= $year ?>">
							</div>
						</div>
						<div class="salerevenue-button-group">
							<button type="submit" name="revenue" value="1" class="btn btn-primary">Sắp xếp theo doanh thu gỉảm dần</button>
						</div>
					</form>
				<?php endif; ?>

				</div>

</section>

<?php include 'footer.php' ?>