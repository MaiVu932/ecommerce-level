<?php
    include '..\Repositories\UserRepository.php';
    $a = new UserRepository();
    $users = $a->test();
    var_dump($users);
?>


<?php include 'header.php'; ?>

<h1>Hello</h1>


<?php include 'footer.php' ?>