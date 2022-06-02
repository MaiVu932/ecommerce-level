<?php
    include('./header.php');

    if(!isset($_SESSION['role'])) {
       echo '<script>alert("Bạn cần đăng nhập trước"); window.location="./home.php"</script>';
     } 
     $notification = new NotificationRepository();
     $notis = $notification->getAllByUserId();

    echo '<link href="' . CSS . 'notificaltion.css" rel="stylesheet">';

?>
<div class="content">
        <h1>Thông báo</h1>
        <ul class="list-group">
            <?php foreach($notis as $noti) {
                if($noti['notifiable_type'] == 0) echo '<li class="list-group-item">Bạn có thông báo mới về nhân xét sản phẩm</li>';
                if($noti['notifiable_type'] == 1) echo '<li  class="list-group-item">Bạn có thông báo mới về đơn hàng</li>';
                if($noti['notifiable_type'] == 2 || $noti['notifiable_type'] == 3 ) echo '<li  class="list-group-item">Bạn có thông báo mới cần phê duyệt</li>';



            } ?>
               
           
        </ul>

</div>
<?php include('./footer.php') ?>
