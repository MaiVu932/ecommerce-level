<?php
include './header.php';

include '../Repositories/OrderRepository.php';
include '../Repositories/UserRepository.php';

if(!isset($_SESSION['id'])) {
    echo '<script>alert("Bạn cần đăng nhập trước !!"); window.location="./home.php?"</script>';
}



$order = new OrderRepository();
$products = $_SESSION['orders'];
// var_dump($products);
$infoUser = $order->getInfoUserById();
global $total;
$total = 0;

if(isset($_POST['btnDatHang'])) {
    $order->orderBuyListProducts1($_SESSION['selects']);
}


?>

<form action="/?act=ludonhang" method="post"></form>
<main role="main">
        <!-- Block content - Đục lỗ trên giao diện bố cục chung, đặt tên là `content` -->
        <div class="container mt-4">
            <form class="needs-validation" name="frmthanhtoan" method="post"
                action="#">
                <input type="hidden" name="kh_tendangnhap" value="dnpcuong">

                <div class="py-5 text-center">
                    <i class="fa fa-credit-card fa-4x" aria-hidden="true"></i>
                    <h2>Đặt Hàng</h2>
                    <p class="lead">Vui lòng kiểm tra thông tin trước khi xác nhận.</p>
                </div>

                <div class="row">
                    <div class="col-md-4 order-md-2 mb-4">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Giỏ hàng</span>
                            <span class="badge badge-secondary badge-pill">2</span>
                        </h4>
                        <ul class="list-group mb-3">
                        <?php foreach($products as $product): ?>
    <li class="list-group-item d-flex justify-content-between lh-condensed">
        <div>
            <h6 class="my-0"><?php echo $product['name'] ?></h6>
            <small class="text-muted"><?php echo $product['price'] . ' x ' . $product['quantity'] ?></small>
        </div>
        <span class="text-muted"><?php echo $product['price'] * $product['quantity'] ?></span>
    </li>
    <?php $total += $product['price'] * $product['quantity']; ?>
<?php endforeach; ?>
   
    <li class="list-group-item d-flex justify-content-between">
        <span>Tổng thành tiền</span>
        <strong><?php echo $total ?></strong>
    </li>
</ul>

                    </div>
                    <div class="col-md-8 order-md-1">
                    <h4 class="mb-3">Thông tin đặt hàng</h4>
<div class="row">
                    <div class="col-md-12">
                         <label for="kh_ht">Họ tên</label>
                         <input type="text" name="userName" class="form-control" style ="display:none"
                            value="<?php echo $infoUser['name']; ?>" />
                         <input disabled type="text" class="form-control" id="ht" name="HoTen" value="<?php echo $infoUser['name']; ?>"> 
                         </div>
                       
                    <div class="col-md-12">
                         <label for="diachi">Địa chỉ</label>
                         <input type="text" class="form-control" id="diachi" name="Diachi" value="<?php echo $infoUser['address']; ?>">
                         </div>
                    <div class="col-md-12">
                         <label for="sdt">SDT</label>
                         <input type="text" class="form-control" id="sdt" name="SDT" value="<?php echo $infoUser['num_phone']; ?>">
                         </div>
                   
  </div>
</fieldset>
                        
                           

                        <h4 class="mb-3">Hình thức thanh toán</h4>

                        <div class="d-block my-3">
                            <div class="custom-control custom-radio">
                            <label class="custom-control-label" for="httt-1">Tiền mặt</label>
                                
                            </div>
                            
                        </div>
                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block" type="submit" name="btnDatHang">Đặt
                            hàng</button>
                    </div>
                </div>
            </form>


<?php include './footer.php' ?>