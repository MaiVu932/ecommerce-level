<?php
    include VIEWS . 'index.php';
    if(file_exists('index.php')) {
        echo '<pre>';
        var_dump(scandir('./../app/views/index.php'));
        echo '</>';

        echo 'ton tai';
    } else {
        echo 'k tt';
    }
?>
<h1>admin/t</h1>