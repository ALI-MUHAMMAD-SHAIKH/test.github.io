<?php
session_start();
// print_r($_SESSION['cart']);
get_template_part('/header');
?>
<body class="d-flex flex-column h-100">
<?php get_template_part('/nav'); ?>
<div class="container-fluid"><!-- container-fluid -->
<div class="row justify-content-center"><!-- product row -->
<!-- <center><h2><b>Bismillahirrahmannnirraheeem</b></h2></center>
<center><h2>INDEX.PHP</h2></center> -->
<!-- <input type="button" id="load_button" value="Load Data">
DelCost:<p id="delCost"></p>
Qty:<p id="qty"></p>
Price:<p id="price"></p> -->
<?php
$args = [
'post_type' => 'xpr_product',
'post_status' => 'publish',
'order' => 'DESC',
'posts_per_page' => 10,
'paged' => $paged,
];
$products = new WP_Query( $args );
$products = $products->posts;
foreach($products as $product){
$product_thumbnail_url = get_the_post_thumbnail_url($product->ID, 'thumbnail');
?>
<div class="xpr-col-xs xpr-col-sm xpr-col-ipad xpr-col-md xpr-col-lg xpr-col-xl xpr-col-xxl">
<div class="card-archive text-center">
<a href="product/<?=$product->post_title?>"><img src="<?php echo $product_thumbnail_url; ?>" class="card-img-top" alt="<?=$product->post_title?>">
<div class="card-body">
<h6 class="card-title"><?=$product->post_title?></h6></a>
<p class="card-text"><?=$product->post_excerpt?></p>
<p class="card-text"><strong class="text-muted"><strike><?=$product->mrp?></strike></strong></p>
<p class="card-text"><b><?=$product->price?></b></p>

<?php 
if($product->xpr_sell_on_off=='Sell Online'){?>
<input type="hidden" name="product_id" id="product_id" value="<?=$product->ID?>">
<input type="hidden" name="type" id="type" value="add">
<input type="number" name="qty" id="qty<?php echo $product->ID ?>" value="1" class="form-control">
<button   onclick="add_to_cart('<?=$product->ID?>')" class="btn btn-outline-primary btn-sm">Add to Cart</button><?php
}else { echo 'Buy In-Store';}
?>
</div>
</div>
</div>
<?php }
wp_reset_query(); 
// $data = file_get_contents('http://localhost/xpreskart/wp-json/xpr/v1/managecart');
// $data = json_decode($data, JSON_PRETTY_PRINT);
// pr($data);
// echo get_stylesheet_directory_uri() .'/index1.php';
// $data = get_post(62);
// pr(unserialize($data->post_content));
// pr(unserialize($data->post_excerpt));
// global $wpdb;
 
// $table_name = $wpdb->prefix . 'posts';
 
// $field_name = 'post_content';
// $user_id = get_current_user_id();
 
// echo $prepared_statement = $wpdb->prepare( "SELECT ID FROM xpr_posts WHERE  post_type = %s",'xpr_seller_orders' );
// $orderIds = $wpdb->get_col( $prepared_statement );
// pr($orderIds);
// echo $prepared_statement = $wpdb->prepare( "SELECT post_content FROM xpr_posts WHERE  post_type = %s",'xpr_seller_orders' );
// $post_content = $wpdb->get_col( $prepared_statement );
// pr($post_content);
// pr(unserialize($post_content[14]));?>
<script src="http://localhost/xpreskart/wp-content/themes/xpreskart/js/jquery-3.5.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
// $(document).ready(function(){
function add_to_cart(pid,qty,type){
	$(document).ready(function(){
		var link = "http://localhost/xpreskart/wp-json/xpr/v1/managecart";
		// var pid = $("#product_id"+pid).val();
		var type = $("#type").val();
		var qty = $("#qty"+pid).val();
		console.log(pid);
		console.log(type);
		console.log(qty);
		// $.ajax({  
		// 	url: link,  
		// 	type: 'POST',
		// 	data: {product_id:pid, qty:qty, type:type},
		// 	success: function(data) {
		// 	$(".cart-count").html(data);
		// 	console.log(data);
		// 	}  
		// });  
	});
}
window.localStorage.setItem('cart','ali');
// jQuery(document).ready(function($){
// 	jQuery("#add_to_cart").submit(function(e){
//     e.preventDefault();
// 	var link = "<?php echo admin_url('admin-ajax.php') ?>";
// 	// var product_id = $("#product_id").val();
// 	// var qty = $("#qty").val();
// 	var form = jQuery("#add_to_cart").serialize();
// 	var formData = new FormData;
// 		formData.append('action', 'xpr_add_cart');
// 		formData.append('var_add_cart', form);
// 		jQuery.ajax({  
// 		url: link,  
// 		type: 'POST',
// 		data: formData,
// 		processData: false,
// 		contentType: false,
// 		success: function(data) {  
// 		// $("#para").html(data);
// 		jQuery(".cart-count").html(data);
// 		// console.log(data);
//   }  
// });  
// });
// });

</script>
<!-- http://localhost/xpreskart/manage_cart.php
<script type="text/javascript">
	fetch('http://localhost/xpreskart/manage_cart.php')
	.then(response => response.json())
	.then(data => console.log(data)); -->
	<!-- // fetch('http://localhost/xpreskart/wp-json/xpr/v1/products')
	// .then(response => response.json())
	// .then(data => console.log(data));

// jQuery(document).ready(function($){
//   $("#add_to_cart").on("click",function(e){
// 	  var product_id = $("#product_id").val();
// 	  var qty = $("#qty").val();
//     $.ajax({  
// 	url: "wp-admin/admin-ajax.php",  
// 	type: 'POST',
// 	data: {
// 			'action' : 'xpr_add_cart',
// 			productId : product_id,
// 			qTy : qty,
// 		  },  
// 	success: function(data) {  
// 		// $("#para").html(data);
// 		console.log(data);                
//   }  
// });  
// });
// });

// jQuery(document).ready(function($){
//   $("#load_button").on("click",function(e){
//     $.ajax({  
// 	url: "wp-admin/admin-ajax.php",  
// 	type: 'POST',
// 	dataType: "json",
// 	data: {'action' : 'xpr_get_products',},  
// 	success: function(data) {  
// 		$("#delCost").html(data[0].orderDetails[28].delCost);
// 		$("#qty").html(data[0].orderDetails[28].qty);
// 		$("#price").html(data[0].orderDetails[28].price);
// 		// document.write(data[0].orderDetails[28].qty);
// 		console.log(data);                
//   }  
// });  
// });
// }); -->
</script>
<?php
// if (isset($_POST['data'])){
	// 	echo  $_POST['data'];
	// 	}
// if (isset($_POST['add'])){
// 	if(isset($_POST['qty'])){
// 		$qty = $_POST['qty'];
// }else{
// 		$qty = 1;
// }
// $pid = $_POST['product_id'];

// $_SESSION['cart'][$pid] = array('qty' => $qty);
// // header('location:http://localhost/xpreskart/');
// ?>
 <script>//window.location.href=window.location.href</script>
 <?php
// // pr($_SESSION['cart']);
// }
// pr($_SESSION['cart']);
// pr($_SESSION);
?>
</div><!-- End of product Row -->
</div><!-- End of container-fluid -->

<?php get_template_part('/footer'); ?>
</body>
</html>