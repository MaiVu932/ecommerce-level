<?php
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

/** Hàm kiểm tra xem ngày, tháng, năm truyền vào có hợp lệ hay không */
function validateDateTime($dateStr)
{
	date_default_timezone_set('UTC');
	$date = DateTime::createFromFormat('Y-m-d', $dateStr);
	return $date && ($date->format('Y-m-d') === $dateStr);
}

if (isset($_GET['date'])) {
	$checkDate = validateDateTime($_GET['date']); // Nếu ngày, tháng, năm truyền vào hợp lệ thì trả về true, nếu không hợp lệ thì trả về false
	if ($checkDate)
		$date = $_GET['date'];
	else {
		echo '<script>
						alert("Ngày tháng năm không tồn tại !");
						window.location = "sale-revenue-shop_detail.php?id=' . $id . '";
					</script>';
		exit;
	}
}

$shop = $_SHOP->getAllShop();
var_dump($shop);

$products = $_PRODUCT->getProductByShopId($shop['id']); // Lấy thông tin của sản phẩm của shop

/** Xử lý sắp xếp theo điều kiện */
$productNew = array();
foreach ($products as $product) {
	/** Nếu chọn thống kê theo ngày, tháng, năm lấy tổng số lượng sản phẩm đã bán được trong ngày đó */
	if (isset($date))
		$quantity = $_ORDER->getQuantityByProduct($product, $date); // Lấy tổng số lượng đã bán được theo ngày, tháng, năm nhập vào
	else
		$quantity = $_ORDER->getQuantityByProduct($product); // Lấy tổng số lượng đã bán được từ đầu đến hiện tại
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

		<?php if (!isset($date)) : ?>
			<h2 class="title text-center">Chọn thống kê theo ngày, tháng, năm</h2>
			<div class="row salerevenue-list">
				<form method="GET">
					<input type="hidden" name="id" value="<?= $id ?>">
					<input type="date" class="salerevenue-date" name="date" value="<?= date('Y-m-d', time()) ?>">
					<div class="salerevenue-button-group">
						<button type="submit" class="btn btn-primary">Xem chi tiết</button>
					</div>
				</form>
			</div>
		<?php else : ?>
			<h2 class="title text-center">Doanh số - Doanh thu của shop ngày <?= $date ?>
				<?php
				if (isset($_GET['sale']))
					echo '| Sắp xếp theo doanh số';
				else if (isset($_GET['revenue']))
					echo '| Sắp xếp theo doanh thu';
				?>
			</h2>


			<h4>Mã shop&nbsp: <span class="salerevenue-label label-danger"><?= $shop['id'] ?></span></h4>
			<h4>Tên shop: <span class="salerevenue-label label-success"><?= $shop['name'] ?></span></h4>

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
				<tbody>
					<?php
					if (!empty($productNew)) :
						foreach ($productNew as $product) :
					?>
							<tr>
								<td><?= $product['name'] ?></td>
								<td><?= $product['sold'] ?></td>
								<td><?= $product['inventory'] ?></td>
								<td><?= $product['sale'] ?></td>
								<td><?= $product['revenue'] ?></td>
							</tr>
					<?php
						endforeach;
					else :
						echo '<script>
						alert("Ngày tháng năm không tồn tại !");
						window.location = "sale-revenue-shop_detail.php?id=' . $id . '";
					</script>';
						exit;
					endif;
					?>
				</tbody>
			</table>

			<form method="GET">
				<input type="hidden" name="id" value="<?= $id ?>">
				<h4><span class="label label-success">Sắp xếp theo ngày, tháng, năm</span></h4>
				<input type="date" class="salerevenue-date" name="date" value="<?= $date ?>">
				<div class="salerevenue-button-group">
					<button type="submit" name="sale" value="1" class="btn btn-primary">Sắp xếp theo doanh số</button>&nbsp
					<button type="submit" name="revenue" value="1" class="btn btn-primary">Sắp xếp theo doanh thu</button>
				</div>
			</form>
		<?php endif; ?>

	</div>

</section>

<?php include 'footer.php' ?>