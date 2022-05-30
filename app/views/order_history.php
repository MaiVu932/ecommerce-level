<?php
include 'header.php';
include '../Repositories/OrderRepository.php';

$order = new OrderRepository();

$getUser = $order->getUser();
if (!$getUser) {
	echo '<script>alert("Bạn chưa đăng nhập !");window.location = "login.php"</script>';
	exit;
}

$histories = $order->getHistoryByUserId($getUser['id']);
//var_dump($histories);

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
		<!--/breadcrums-->

		<h2 class="title text-center">Lịch sử mua hàng </h2>

		<div class="complain-create">


			<?php
			if (!empty($histories)) :
				foreach ($histories as $history) :
			?>
					<div class="list">
						<div class="info">
							<div class="image">
								<img src="<?php echo IMAGES ?><?= $history['image'] ?>" alt="">
							</div>
							<div class="detail-list">
								<span><?= $history['name'] ?></span>
								<span>Số lượng: <?= $history['quantity'] ?></span>
								<span>Tình trạng</span>
								<p>Đã giao</p>
								<span>Địa chỉ</span>
								<p><?= $history['address'] ?></p>
								<span>Số điện thoại</span>
								<p><?= $history['num_phone'] ?></p>
								<br>
								<a href="complain_create.php?id=<?= $history['id'] ?>">
									<button type="submit" class="btn btn-primary">Khiếu nại</button>
								</a>
							</div>
						</div>
					</div>
				<?php
				endforeach;
			else :
				?>
				<h1 style="text-align: center">Lịch sử mua hàng trống</h1>
			<?php
			endif;
			?>

		</div>
</section>
<!--/form-->


<?php include 'footer.php' ?>