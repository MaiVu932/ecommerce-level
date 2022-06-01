<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
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

$id = isset($_GET['id']) ? $_GET['id'] : 0;
/** Nếu là kiểm duyệt viên hoặc quản trị viên thì lấy thông tin của shop theo id, nếu là người dùng thì lấy thông tin của shop của người dùng */
if (isset($_SESSION['role']) && $_SESSION['role'] >= 2)
	$shop = $_SALEREVENUE->getShopById($id); // Lấy thông tin của shop theo id
else
	$shop = $_SALEREVENUE->getShopByIdAndUserId($id, $_SESSION['id']); // Lấy thông tin của shop của người dùng
/** Kiểm tra xem shop có tồn tại hay không */
if (!isset($shop)) {
	echo '<script>
					alert("Shop không tồn tại !");
					window.location = "sale-revenue-shop_list.php";
				</script>';
	exit;
}

$date = !empty($_GET['date']) ? sprintf("%02d", (int)$_GET['date']) : null; // Kiểm tra xem có nhập vào ngày hay không nếu có thì ép kiểu sang kiểu số nguyên và thêm số 0 vào đằng trước nếu ngày bé hơn 10. VD: 9 -> 09, 12 -> 12.
$month = !empty($_GET['month']) ? sprintf("%02d", (int)$_GET['month']) : null; // Kiểm tra xem có nhập vào tháng hay không nếu có thì ép kiểu sang kiểu số nguyên và thêm số 0 vào đằng trước nếu tháng bé hơn 10. VD: 9 -> 09, 12 -> 12.
$year = !empty($_GET['year']) ? (int)$_GET['year'] : null; // Kiểm tra xem có nhập vào năm hay không nếu có thì ép kiểu sang kiểu số nguyên.

$products = $_SALEREVENUE->getProductByShopId($shop['id']); // Lấy thông tin của sản phẩm của shop
//var_dump($products);

/** Xử lý sắp xếp theo điều kiện */
$productNew = array();
foreach ($products as $product) {
	/** Nếu chọn thống kê theo ngày, tháng, năm lấy tổng số lượng sản phẩm đã bán được trong ngày đó */
	$quantity = $_SALEREVENUE->getQuantityByProduct($product, $date, $month, $year); // Lấy tổng số lượng đã bán được theo ngày, tháng, năm nhập vào
	if ($quantity != null) {
		$productOld = $_SALEREVENUE->getSaleRevenueByQuantityAndProductId($quantity, $product['id']); // Lấy doanh số, doanh thu của sản phẩm
		array_push($productNew, $productOld); // Gộp thông tin doanh số, doanh thu đã tính toán được ở trên vào 1 mảng
	}
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

if (isset($_GET['sale']))
	$productNew = SelectionSortDescending($productNew, 'sale');
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
				<li class="active">Doanh số - Doanh thu của shop </li>
			</ol>
		</div>

		<?php
		if (empty($year) && empty($month) && empty($date)) {
			echo '
			<h2 class="title text-center">Chọn thống kê theo ngày, tháng, năm</h2>
			<div class="alert alert-warning">
				<strong>Gợi ý:</strong> Để trống ngày nếu muốn thống kê theo tháng năm. Để trống ngày và tháng nếu muốn thống kê theo năm
			</div>
			<div class="row salerevenue-list">
				<form method="GET">
					<input type="hidden" name="id" value="' . $id . '">
					<div class="date-list">
						<div class="date-label">
							<span class="salerevenue-label label-success">Ngày</span>
							<input class="salerevenue-date" name="date" type="number" min="01" max="31" step="1" value="' . date('d', time()) . '">
						</div>
						<div class="date-label">
							<span class="salerevenue-label label-primary">Tháng</span>
							<input class="salerevenue-date" name="month" type="number" min="01" max="12" step="1" value="' . date('m', time()) . '">
						</div>
						<div class="date-label">
							<span class="salerevenue-label label-warning">Năm</span>
							<input class="salerevenue-date" name="year" type="number" min="2022" max="2099" step="1" value="' . date('Y', time()) . '">
						</div>
					</div>
					<div class="salerevenue-button-group">
						<button type="submit" class="btn btn-primary">Thống kê</button>
					</div>
				</form>
			</div>';
		} else {
			echo '<h2 class="title text-center">Doanh số - Doanh thu của shop theo ';
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

			if (isset($_GET['sale'])) {
				echo ' | Sắp xếp theo doanh số';
			} else if (isset($_GET['revenue'])) {
				echo ' | Sắp xếp theo doanh thu';
			}
			echo '
			</h2>

			<h4 style="padding-bottom: 6px"><span class="salerevenue-label label-danger">Mã shop&nbsp: ' . $shop['id'] . '</span></h4>
			<h4><span class="salerevenue-label label-success">Tên shop: ' . $shop['name'] . '</span></h4>

			<table class="table salerevenue-table">
				<thead>
					<tr class="salerevenue-tr">
						<th>Tên sản phẩm</th>
						<th>Số lượng sản phẩm đã bán</th>
						<th>Số lượng sản phẩm tồn kho</th>
						<th>Doanh số của sản phẩm</th>
						<th>Doanh thu của sản phẩm</th>
					</tr>
				</thead>
				<tbody>';
			if (!empty($productNew)) {
				$totalSold = 0;
				$totalInventory = 0;
				$totalSale = 0;
				$totalRevenue = 0;
				foreach ($productNew as $product) {
					$totalSold += $product['sold'];
					$totalInventory += $product['inventory'];
					$totalSale += $product['sale'];
					$totalRevenue += $product['revenue'];
					echo '
							<tr>
								<td>' . $product['name'] . '</td>
								<td>' . $product['sold'] . '</td>
								<td>' . $product['inventory'] . '</td>
								<td>' . $product['sale'] . '</td>
								<td>' . $product['revenue'] . '</td>
							</tr>';
				}
				echo '
						<tr>
							<td class="salerevenue-bold">Tổng cộng:</td>
							<td class="salerevenue-bold">' . $totalSold . '</td>
							<td class="salerevenue-bold">' . $totalInventory . '</td>
							<td class="salerevenue-bold">' . $totalSale . '</td>
							<td class="salerevenue-bold">' . $totalRevenue . '</td>
						</tr>';
			} else {
				echo '<script>
						alert("Ngày tháng năm không tồn tại !");
						window.location = "sale-revenue-shop_detail.php?id=' . $id . '";
					</script>';
				exit;
			}
			echo '
				</tbody>
			</table>';

			echo '
			<form method="GET">
				<input type="hidden" name="id" value="' . $id . '">
				<h4><span class="salerevenue-label label-success">Sắp xếp theo ngày, tháng, năm</span></h4>
				<div class="alert alert-warning">
					<strong>Gợi ý:</strong> Để trống ngày nếu muốn thống kê theo tháng năm. Để trống ngày và tháng nếu muốn thống kê theo năm
				</div>
				<div class="row salerevenue-list">
					<form method="GET">
						<div class="date-list">
							<div class="date-label">
								<span class="salerevenue-label label-success">Ngày</span>
								<input class="salerevenue-date" name="date" type="number" min="01" max="31" step="1" value="' . $date . '">
							</div>
							<div class="date-label">
								<span class="salerevenue-label label-primary">Tháng</span>
								<input class="salerevenue-date" name="month" type="number" min="01" max="12" step="1" value="' . $month . '">
							</div>
							<div class="date-label">
								<span class="salerevenue-label label-warning">Năm</span>
								<input class="salerevenue-date" name="year" type="number" min="2022" max="2099" step="1" value="' . $year . '">
							</div>
						</div>
						<div class="salerevenue-button-group">
							<button type="submit" name="sale" value="1" class="btn btn-primary">Sắp xếp theo doanh số</button>&nbsp
							<button type="submit" name="revenue" value="1" class="btn btn-primary">Sắp xếp theo doanh thu</button>
						</div>
					</form>';
		}
		?>

	</div>

</section>

<?php include 'footer.php' ?>