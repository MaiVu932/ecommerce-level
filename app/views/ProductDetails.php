<?php 
include ('./header.php');
// include '../Repositories/UserRepository.php';
include '../Repositories/CategoryRepository.php';
include '../Repositories/ProductRepository.php';
include '../Repositories/CommentRepository.php';
include '../Repositories/OrderRepository.php';
// $user = new UserRepository();
// $user->validate();
$category = new CategoryRepository();
$categories = $category->select_category();

$product = new ProductRepository();
$infoDetail = $product->getInfoDetailProductById();
$products = $product->getProductsByCategoryID();

$comment = new CommentRepository();
$comments = $comment->getCommentsByProductId();

$order = new OrderRepository();

// var_dump($_SESSION['product_id']);

if(isset($_POST['btn-comment'])) {
    $comment = new CommentRepository();
    $comment->createComment($_POST['txt-comment']);
}

if(isset($_POST['btn-add-to-cart'])) {
    $order->addToCart($_POST['quantity']);
}

if(isset($_POST['btn-buy']) ) {
    $_SESSION['quantity_order'] = $_POST['quantity'];
    echo '<script>window.location="./order_create.php"</script>';
}


?>
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
						
						
					
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					<div class="product-details"><!--product-details-->
						<form method="POST">
                        <div class="col-sm-5">
							<div class="view-product">
								<img src="../../public/images/<?php echo $infoDetail['code'] . '/' . $infoDetail['image'] ?>" alt="" />
								<h3>ZOOM</h3>
							</div>

						</div>
						<!-- <div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
								<img src="../../public/images/product-details/new.jpg" class="newarrival" alt="" />
								<h2><?php echo $infoDetail['name'] ?></h2>
								<span>
									<span>Giá: US $<?php echo $infoDetail['price_market'] ?></span>
									<br>
                                    <label>Số Lượng:</label>
									<input type="number" name="quantity" value="1" min="1" />
									<p><?php echo $infoDetail['description'] ?></p>

                                    <button type="submit" name="btn-add-to-cart" class="btn btn-fefault cart">
										<i class="fa fa-shopping-cart"></i>
										Thêm vào giỏ hàng
									</button>

                                    <button type="submit" name="btn-buy" class="btn btn-fefault cart">
										<i class="fa fa-shopping-cart"></i>
										Mua hàng
									</button>
								</span>
						
                        </form>
					</div><!--/product-details-->
					
					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<!-- <li><a href="#details" data-toggle="tab">Details</a></li>
								<li><a href="#companyprofile" data-toggle="tab">Company Profile</a></li> -->
								<!-- <li><a href="#tag" data-toggle="tab">Tag</a></li> -->
								<li class="active"><a href="#reviews" data-toggle="tab">Nhận xét (<?php echo count($comments); ?>)</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade" id="details" >
								
							</div>
							
							
							
							
							<div class="tab-pane fade active in" id="reviews" >
								<div class="col-sm-12">
									<ul>
										<li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
										<li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
										<li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
									</ul>
									<p>Mô tả sản phẩm: <?php echo $infoDetail['description'] ?></p>
                                    <p><b>Danh sách nhận xét</b></p>
                                        <?php foreach($comments as $comment): ?>
                                            <i class="fa fa-user"></i><span style="margin-left: 0.5% ;"><?php echo $comment['name'] . '   (' . $comment['create_at'] . ')' ?></span> <br>
                                            <p style="margin-left: 3% ;"><?php echo $comment['content'] ?></p>
                                        <?php endforeach; ?>
                                        
									<p><b>Viết nhận xét của bạn ....</b></p>
									
									<form method="POST">
										<textarea name="txt-comment" placeholder="Nhập đánh giá" required></textarea>
										<button type="submit" name="btn-comment" class="btn btn-default pull-right">
											Nhận xét
										</button>
									</form>
								</div>
							</div>
							
						</div>
					</div><!--/category-tab-->
					
					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">Các sản phẩm cùng loại</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
                                <?php foreach($products as $product): ?>
                                    <div class="col-sm-4">
                                                <div class="product-image-wrapper">
                                                    <div class="single-products">
                                                        <div class="productinfo text-center">
                                                            <img style="height: 200px;" src="../../public/images/<?php echo $product['code'] . '/' . $product['image']  ?>" alt="" />
                                                            <h2>$<?php echo $product['price_market'] ?></h2>
                                                            <p><?php echo $product['name'] ?></p>
                                                            <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                <?php endforeach; ?>
								
							</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items-->
					
				</div>
			</div>
		</div>
	</section>
<?php include('./footer.php') ?>