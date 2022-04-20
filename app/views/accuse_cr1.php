<?php
    include 'header.php';
    include '../Repositories/AccuseRepository.php';

    echo '<link rel="stylesheet" href="' . CSS . 'accuse_cr1.css">';
    echo '<img src="'. IMAGES . 'ac/bia.jpg" alt=""  style="margin-left: 200px">';
?>
<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="body">  
    <nav>
        <ul>
            <li><a href="#"><div class="nut" ></div></a>
            <ul>
                <li><a href="accuse_cr2.php"><p>Khiếu nại</p></a></li>
                <li><a href="home.php"><p>Quay lại trang chủ</p></a></li>
            </ul>
            </li>
        </ul>
    </nav>
</div>

<?php include 'footer.php'?>