    
<?php
        include 'header.php';   
        include '../Repositories/UserRepository.php';
        include '../Repositories/CategoryRepository.php';
        include '../Repositories/ProductRepository.php';
        $user = new UserRepository();
        $user->validate();
        $category = new CategoryRepository();
        $categories = $category->select_category();
        $product = new ProductRepository();
        $products = $product->getProducts(isset($_GET['category']) ? $_GET['category'] : null, isset($_GET['page']) ? $_GET['page'] : null);
        if(isset($_POST['btn-add-cart'])) {
            $_SESSION['product_id'] = $_POST['product-id'];
            echo '<script> window.location="ProductDetails.php" </script>';
        }

    ?>

<script src="../../public/js/process_price_range.js" defer></script>
	
	<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol>
						
						<div class="carousel-inner">
							<div class="item active">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>Thuận tiện mua sắm</h2>
									<p>Gió mưa không ngại đường xa, web đây có sẵn order liền tay </p>
									<button type="button" class="btn btn-default get">Cùng Mua Nào!</button>
								</div>
								<div class="col-sm-6">
									<img src="<?php echo IMAGES ?>home/girl1.jpg" class="girl img-responsive" alt="" />
									<img src="<?php echo IMAGES ?>home/pricing.png"  class="pricing" alt="" />
								</div>
							</div>
							<div class="item">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>Thuận tiện mua sắm</h2>
									<p>Gió mưa không ngại đường xa, web đây có sẵn order liền tay </p>
									<button type="button" class="btn btn-default get">Cùng Mua Nào!</button>
								</div>
								<div class="col-sm-6">
									<img src="<?php echo IMAGES ?>home/girl2.jpg" class="girl img-responsive" alt="" />
									<img src="<?php echo IMAGES ?>home/pricing.png"  class="pricing" alt="" />
								</div>
							</div>
							
							<div class="item">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>Thuận tiện mua sắm</h2>
									<p>Gió mưa không ngại đường xa, web đây có sẵn order liền tay </p>
									<button type="button" class="btn btn-default get">Cùng Mua Nào!</button>
								</div>
								<div class="col-sm-6">
									<img src="<?php echo IMAGES ?>home/girl3.jpg" class="girl img-responsive" alt="" />
									<img src="<?php echo IMAGES ?>home/pricing.png" class="pricing" alt="" />
								</div>
							</div>
							
						</div>
						
						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</section><!--/slider-->
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Danh Mục</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
                            
                        <?php foreach($categories as $category): ?>
                            <div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="?catgory-id=<?php $category['id'] ?>"><?php echo $category['name'] ?></a></h4>
								</div>
							</div>
                        <?php endforeach; ?>

							
						</div><!--/category-products-->
					
						<div class="price-range"><!--price-range-->
							<h2>Mức Giá</h2>
                            <span id="min-price">min: 250</span>
                            <span id="max-price">max: 450</span>
							<div class="well text-center">
								 <input 
                                    type="text" 
                                    class="span2" 
                                    value="" 
                                    data-slider-min="0" 
                                    data-slider-max="600" 
                                    data-slider-step="5" 
                                    data-slider-value="[250,450]" 
                                    id="sl2"
                                    oninput="changePrice(this)" >
                                    <br />
								 <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
							</div>
                            <button id="btn-search">Tìm kiếm</button>
						</div><!--/price-range-->
						
						<div class="shipping text-center"><!--shipping-->
							<img src="<?php echo IMAGES ?>home/shipping.jpg" alt="" />
						</div><!--/shipping-->
					
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Sản Phẩm</h2>

                        <?php foreach($products as $value): ?>
                            <div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
										<div class="productinfo text-center">
                                            
											<img style="height: 250px" src="<?php echo IMAGES . $value['code'] . '/' . $value['product_code'] . '.jpeg' ?>" alt="" />
											<h2>$<?php echo $value['product_price'] ?></h2>
											<p><?php echo $value['product_name'] ?></p>
											
                                                <form method="POST" class="btn btn-default add-to-cart">
                                                    <input type="text" name="product-id" value="<?php echo $value['product_id'] ?>" style="display: none;" >
                                                    <i class="fa fa-shopping-cart"></i>
                                                    <input type="submit" name="btn-add-cart" value="Thêm vào giỏ hàng">
                                                </form>
                                            
										</div>
										<div class="product-overlay">
											<div class="overlay-content">
                                            <h2><?php echo $value['product_price'] ?></h2>
											<p><?php echo $value['product_name'] ?></p>
                                            <form method="POST" class="btn btn-default add-to-cart">
                                                    <input type="text" name="product-id" value="<?php echo $value['product_id'] ?>" style="display: none;" >
                                                    <i class="fa fa-shopping-cart"></i>
                                                    <input type="submit" name="btn-add-cart" value="Thêm vào giỏ hàng">
                                                </form>
											</div>
										</div>
								</div>
								<div class="choose">
									<ul class="nav nav-pills nav-justified">
										<li><a href="#"><i class="fa fa-plus-square"></i>Yêu Thích</a></li>
										<li><a href="#"><i class="fa fa-plus-square"></i>So Sánh</a></li>
									</ul>
								</div>
							</div>
						</div>
                        <?php endforeach; ?>
						
						
					</div><!--features_items-->
					
				</div>
			</div>
		</div>
	</section>
    
 <?php
    include 'footer.php';
 ?>

