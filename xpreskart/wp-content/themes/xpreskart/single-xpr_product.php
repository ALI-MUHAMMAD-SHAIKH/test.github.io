<?php /* Template Name: Single Product */
session_start();
// print_r($_SESSION['cart']);
get_template_part('/header');
?>
<body class="d-flex flex-column h-100">
<?php get_template_part('/nav'); ?>
<div class="container-fluid"><!-- container-fluid -->
<div class="row justify-content-center"><!-- product row -->
<!-- <center><h2><b>Bismillahirrahmannnirraheeem</b></h2></center> -->
<?php
global $wp_query;
$pId = $wp_query->query_vars['spID'];
$pId = urldecode($pId);
global $wpdb;

$rw = $wpdb->get_row( $wpdb->prepare("select * from `xpr_posts` where post_title='{$pId}'",''));
// pr($rw);
$pId = $rw->ID;
$product_thumbnail_url = get_the_post_thumbnail_url($pId, 'thumbnail');
$product = get_post($pId);
$attachment_ids = $product->product_image_gallery;
// pr($attachment_ids);
// if (isset($_POST['add'])){
// 	if(isset($_POST['qty'])){
// 		$qty = $_POST['qty'];
// }else{
// 		$qty = 1;
// }
// // $id = $_POST['product_id'];

// $_SESSION['cart'][$pId] = array('qty' => $qty);
// header("location:http://localhost/xpreskart/product/'{$product->post_title}'");
// // pr($_SESSION['cart'][$id]['qty']);
// }
$qty = 1;

?>
<div class="col-6">
<img src="<?php echo esc_url($product_thumbnail_url); ?>" class="img-fluid">
<p id="para"></p>
<?php foreach ($attachment_ids as $attachment_id) { //pr($attachment_ids);?>
<div class = " mt-2">
<img src="<?php echo esc_url(wp_get_attachment_image_src( $attachment_id, 'thumbnail' )[0]); ?>" class="img-fluid">
</div><?php } ?>
</div>
<div class="col-6">
<?=$product->post_title?><br><br>
<?=$product->post_excerpt?><br><br>
<?=$product->description?><br><br>
<strike><b class="text-muted">MRP :<?=$product->mrp?></b></strike><br><br>
<b>Price :<?=$product->price?></b><br><br>
<form id="add_to_cart"><br><br>
<input type="hidden" name="product_id" id="product_id" value="<?=$product->ID?>">
<input type="hidden" name="type" id="type" value="add">
<input type="number" class="form-control" id="qty" name="qty" value="<?php if(isset($_SESSION['cart'][$pId]['qty'])) {echo $_SESSION['cart'][$pId]['qty'];}else{echo $qty;}?>"><br><br>
<!-- <button  href="javascript:void(0)" onclick="manage_cart('<?php echo $product->ID?>','add')" class="btn btn-outline-primary btn-sm">Add to Cart</button> -->
<?php if($product->xpr_sell_on_off=='Sell Online'){
echo '<button type="submit" name="add"  class="btn btn-outline-primary btn-sm">Add to Cart</button>';
}	else { echo 'In-Store';}
?>
</form>
</div>
</div><!-- End of product Row -->
</div><!-- End of container-fluid -->
<?php get_template_part('/footer'); ?>
<script src="http://localhost/xpreskart/wp-content/themes/xpreskart/js/jquery-3.5.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
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
// jQuery(document).ready(function($){
// function manage_cart(pid,type){
// 	var qty = jQuery("#qty").val();
// 	jQuery.ajax({
// 		type: "post",
// 		url: "http://localhost/xpreskart/manage_cart.php",
// 		data: "pid="+pid+"&qty="+qty+"&type="+type,
// 		// dataType: "dataType",
// 		success: function(response) {
// 			console.log(response);
// 			jQuery(".cart-count").html(response);
// 		}
// 	});
// }
// });
// jQuery(document).ready(function($){
// function manage_cart(pid,type){
// 	var qty = jQuery("#qty").val();
// 	jQuery.ajax({
// 		type: "post",
// 		url: "http://localhost/xpreskart/wp-json/xpr/v1/managecart",
// 		data: "pid="+pid+"&qty="+qty+"&type="+type,
// 		// dataType: "dataType",
// 		success: function(response) {
// 			// console.log(response);
// 			jQuery(".cart-count").html(response);
// 		}
// 	});
// }
// });

$(document).ready(function(){
	$("#add_to_cart").submit(function(e){
    e.preventDefault();
	var link = "http://localhost/xpreskart/wp-json/xpr/v1/managecart";
	// var product_id = $("#product_id").val();
	// var qty = $("#qty").val();
	var form = $("#add_to_cart").serialize();
	// var formData = new FormData;
    $.ajax({  
		url: link,  
		type: 'POST',
		data: form,
		// processData: false,
		// contentType: false,
		success: function(data) {  
		// $("#para").html(data);
		$(".cart-count").html(data);
		// console.log(data);
  }  
});  
});
});
</script>
</body>
</html>