<?php 
include './header.php';
include '../Repositories/UserRepository.php';


echo '<link href="' . CSS . 'shop_list.css" rel="stylesheet">';
echo '<script src="' . JS . 'processDate.js" defer></script>';
echo '<script src="' . JS . 'process_table.js" defer></script>';

$user = new UserRepository();
$users = $user->getUsers();
if(isset($_POST['btn-search'])) {
    $users = $user->getUsers(
        null, 
        $_POST['txt-search-name'],
        $_POST['date-search'],
        $_POST['role']
    );
}



?>



<div class="container">
    
    <div class="content">
           
            <div class="search" style="margin-top: 20px;">
                <form method="POST">
                    <input 
                        type="text" 
                        style="width: 20%; "
                        placeholder="  Tìm kiếm"
                        name="txt-search-name" />
                        
                    <input 
                        type="text" 
                        name="date-search"
                        id="dateSearch"
                        style="width: 20%; outline: none;" 
                        placeholder="Thời gian tạo tài khoản" >
                    
                    <select name="role" style="width: 20%; background-color: #fff; border: 1px solid blcak">
                        <option value="">Chọn vai trò</option>
                        <option value="6">Người mua</option>
                        <option value="1">Người bán</option>
                        <?php if($_SESSION['role'] == 3): ?>
                            <option value="2">Người kiểm duyệt</option>
                        <?php endif; ?>
                    </select>

                    <input 
                        type="submit" 
                        name="btn-search"
                        value="Tìm kiếm" />
                </form>
                
            </div>

        <h1>Danh sách người dùng</h1>
        <table id="post">
            <tr>
                <th>STT</th>
                <th>Tên người dùng</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Vai trò</th>
                <th>Ngày tạo tài khoản</th>
                <th>Sửa</th>
                <th>Khóa</th>
            </tr>
            <?php 
            $i = 0;
            foreach($users as $value): 
            ?>
                <tr>
                    <td><?php echo $i + 1; $i++?></td>
                    <td><?php echo $value['name'] ?></td>
                    <td><?php echo $value['address'] ?></td>
                    <td><?php echo $value['num_phone'] ?></td>
                    <td>
                        <?php 
                            if($value['permission'] == 0) echo "Khách hàng";
                            else if ($value['permission'] == 1) echo "Người bán";
                            else if($value['permission'] == 2) echo "Người kiểm duyệt";
                            else echo "admin";
                        ?>
                    </td>
                    <td><?php echo $value['create_at'] ?></td>
                    <td>
                        <a href="./shop_update.php?id=<?php echo $value['id'] ?>">Sửa</a>
                    </td>
                    <td>
                        <a href="./shop_update.php?id=<?php echo $value['id'] ?>">Sửa</a>
                    </td>
                   
                </tr>
            <?php endforeach; ?>

        </table>
           
    </div>
</div>

<?php include './footer.php' ?>