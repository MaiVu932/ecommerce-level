<?php 
include 'header.php';
// include 'define.php';
error_reporting(0);

if(!isset($_SESSION['cart'])) $_SESSION['cart']=[];


// xoa san pham trong gio
if(isset($_GET['delID'])&&($_GET['delID']>=0)){
    $id= $_GET['delID'];
    // echo $id;
    $qt = $_GET['quatity'];
    array_splice($_SESSION['cart'],$id,$qt);
}

//lay du lieu ra
if(isset($_POST['add']) &&($_POST['add'])){
    $product_id=$_POST['product_id'];
    $product_image=$_POST['product_image'];
    $product_name=$_POST['product_name'];
    $price_market=$_POST['price_market'];
    $product_code=$_POST['product_code'];
    $quanity=1;
     
    
    $fl=0;

    for($i=0; $i<sizeof($_SESSION['cart']);$i++ ){
        if ($_SESSION['cart'][$i][0]==$product_id){
            $_SESSION['cart'][$i][5]+=1;
            $fl = 1;
            break;
        }
    }
    if($fl==0){
        $sp=[$product_id,$product_image, $product_name, $price_market, $product_code,$quanity];
        $_SESSION['cart'][]=$sp;
        // var_dump( $_SESSION['cart']);
    }
    
}




?>


<body class="cnt-home">



    <!-- ============================================== HEADER ============================================== -->
    <header class="header-style-1">
        <?php include('includes/top-header.php');?>
        <?php include('includes/main-header.php');?>
        <?php include('includes/menu-bar.php');?>
    </header>
    <!-- ============================================== HEADER : END ============================================== -->
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="#"></a></li>
                    <li class='active'>Shopping Cart</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->

    <div class="body-content outer-top-xs">
        <div class="container">
            <div class="row inner-bottom-sm">
                <div class="shopping-cart">
                    <div class="col-md-12 col-sm-12 shopping-cart-table ">
                        <div class="table-responsive">
                            <form name="cart" method="post">


                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="cart-romove item">Remove</th>
                                            <th class="cart-description item">Image</th>
                                            <th class="cart-product-name item">Product Name</th>

                                            <th class="cart-qty item">Quantity</th>
                                            <th class="cart-sub-total item">Price Per unit</th>

                                            <th class="cart-total last-item">Grandtotal</th>
                                        </tr>

                                        <?php
                                            $total=0;
                                         if(isset($_SESSION['cart'])&&(is_array($_SESSION['cart']))){
                                            
                                            $number = 1;
                                            for($i=0;$i < sizeof($_SESSION['cart']);$i++){
                                        ?>
                                    <tbody>

                                        <td><a class="btn btn-danger"
                                                href="cart.php?delID=<?php echo $i; ?>&quatity=<?php echo  $_SESSION['cart'][$i][5]; ?>">Delete</a>
                                        </td>
                                        <td><img
                                                src="<?php  echo IMAGES . $_SESSION['cart'][$i][1] . '/' . $_SESSION['cart'][$i][4] . '.jpeg' ?>">
                                        </td>
                                        <td><?php echo $_SESSION['cart'][$i][2]; ?></td>
                                        <td><input type="number" name="numberQuatity"
                                                value="<?php echo  $_SESSION['cart'][$i][5]; ?>" /></td>
                                        <td><?php echo $_SESSION['cart'][$i][3]; ?></td>

                                        <td><?php echo  ($_SESSION['cart'][$i][5] * $_SESSION['cart'][$i][3])?></td>
                                        <?php $total += ($_SESSION['cart'][$i][5] * $_SESSION['cart'][$i][3])  ?>
                                    </tbody>
                                    <?php
                                                }
                                            }
                                         ?>
                                    </thead>
                                    <tr>
                                    <td> <button type="submit" name="ordersubmit" class="btn btn-primary">TO
                                                Continue</button></td>
                                        <td class="total"><b><strong>TOTAL</strong></b></td>
                                        <td colspan="3"><b><strong><?php echo $total ?></strong></b></td>
                                        <td> <button type="submit" name="ordersubmit" class="btn btn-primary">TO
                                                ORDER</button></td>
                                    </tr>
                                    <tfoot>
                                        
                                    </tfoot>




                                    </tbody>
                                </table>

                        </div>
                    </div>
                    
                    </div>
                </div>
            </div>
            </form>
            <?php echo include('includes/brands-slider.php');?>
        </div>
    </div>
    <?php include('includes/footer.php');?>

    <script src="../../public/js/jquery-1.11.1.min.js"></script>

    <script src="../../public/js/bootstrap.min.js"></script>

    <script src="../../public/js/bootstrap-hover-dropdown.min.js"></script>
    <script src="../../public/js/owl.carousel.min.js"></script>

    <script src="../../public/js/echo.min.js"></script>
    <script src="../../public/js/jquery.easing-1.3.min.js"></script>
    <script src="../../public/js/bootstrap-slider.min.js"></script>
    <script src="../../public/js/jquery.rateit.min.js"></script>
    <script type="text/javascript" src="assets/js/lightbox.min.js"></script>
    <script src="../../public/js/bootstrap-select.min.js"></script>
    <script src="../../public/js/wow.min.js"></script>
    <script src="../../public/js/scripts.js"></script>

    <!-- For demo purposes – can be removed on production -->

    <!-- <script src="switchstylesheet/switchstylesheet.js"></script>

</body>

</html>