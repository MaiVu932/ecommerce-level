<?php
    include 'header.php';
    include '../Repositories/AccuseRepository.php';
    $accuse = new AccuseRepository();
    if(isset($_POST['cr-accuse'])) {
        $accuse->accuse($_POST);
    }
    echo '<link rel="stylesheet" href="' . CSS . 'accuse_cr2.css">';
?>
<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<h2 style="color:#FE980F; text-align:center">CREATE ACCUSE</h2>
<div class="body">
    <form action="" method="POST" class="nd" enctype="multipart/form-data">
        <p>Tên tài khoản tạo đơn: <input type="text"  name="creatorN" class="ipt"></p>   
        <p>Tên tài khoản bị khiếu nại: <input type="text" name="accusedN" class="ipt"></p>

        <p><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Lí do khiếu nại:<br>
        <textarea cols="30" rows="7" name="message" class="ipt" required></textarea></p>

        <p><i class="fa fa-file-image-o" aria-hidden="true"></i>Hình ảnh dùng để khiếu nại:</p>
        <input type="file" name="file" id="file">
        <div class="nut">
          <button type="submit" name="cr-accuse" style="color:white; background-color:#FE980F">Đăng</button>
          <button type="submit" style="background-color:white"><a href="accuse_cr1.php" style="color:#FE980F">Hủy</a></button>
        </div>
 
    </form>
</div>

<?php include 'footer.php'?>