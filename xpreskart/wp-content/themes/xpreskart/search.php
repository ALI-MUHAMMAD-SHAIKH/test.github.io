<?php
session_start();
ob_start();
/* Template Name: Search */
get_template_part('/header');
?>
<body class="d-flex flex-column h-100">
<?php get_template_part('/nav'); ?>
<div class="container-fluid"><!-- container-fluid -->
<div class="row justify-content-center"><!-- product row -->
<!-- <center><h2><b>Bismillahirrahmannnirraheeem</b></h2></center>
<center><h2>SEARCH.PHP</h2></center> -->

<?php
if (isset($_POST['search'])) {
$city = $_POST['city'];
$area = $_POST['area'];
$text = $_POST['text'];
// pr($_POST);
$args = isset($args) ? $args: '';
// $products = isset($products) ? $products: '';
// text only
if ( $text != "" && $city == "" && $area == "") {
$args = [
    'post_type' => 'xpr_product',
    'post_status' => 'publish',
    's' => $text,
    'compare' => 'LIKE',
    'order' => 'DESC',
    'posts_per_page' => 10,
    'paged' => $paged,
    ];
    $products = new WP_Query( $args );
}
// text AND city
elseif ( $text != "" && $city != "" &&  $area == "" ) {
    $args = [
        'post_type' => 'xpr_product',
        'post_status' => 'publish',
        's' => $text,
        'meta_query' => [ ['key' => 'xpr_p_city', 'value' => $city, 'compare' => 'LIKE'] ],
        'order' => 'DESC',
        'posts_per_page' => 10,
        'paged' => $paged,
        ];
        $products = new WP_Query( $args );
}
// text AND area
elseif ( $text != "" && $area != "" && $city == "" ) {
    $args = [
        'post_type' => 'xpr_product',
        'post_status' => 'publish',
        's' => $text,
        'meta_query' => [ ['key' => 'xpr_p_area', 'value' => $area, 'compare' => 'LIKE'] ],
        'order' => 'DESC',
        'posts_per_page' => 10,
        'paged' => $paged,
        ];
        $products = new WP_Query( $args );
}
// city only
elseif ( $city != "" && $text == "" && $area == "" ) {
$args = [
    'post_type' => 'xpr_product',
    'post_status' => 'publish',
    'meta_query' => [ ['key' => 'xpr_p_city', 'value' => $city, 'compare' => 'LIKE'] ],
    'order' => 'DESC',
    'posts_per_page' => 10,
    'paged' => $paged,
    ];
    $products = new WP_Query( $args );
}
// area only
elseif ( $area != "" && $city == "" && $text == "" ) {
    $args = [
        'post_type' => 'xpr_product',
        'post_status' => 'publish',
        'meta_query' => [ ['key' => 'xpr_p_area', 'value' => $area, 'compare' => 'LIKE'] ],
        'order' => 'DESC',
        'posts_per_page' => 10,
        'paged' => $paged,
        ];
        $products = new WP_Query( $args );
}
// city AND area
elseif ( $city != "" && $area != "" && $text == "") {
    $args = [
        'post_type' => 'xpr_product',
        'post_status' => 'publish',
        'meta_query' => [
            ['key' => 'xpr_p_city', 'value' => $city, 'compare' => 'LIKE'] , 
            ['key' => 'xpr_p_area', 'value' => $area, 'compare' => 'LIKE'] 
        ],
            'order' => 'DESC',
            'posts_per_page' => 10,
            'paged' => $paged,
        ];
        $products = new WP_Query( $args );
}
// city AND area AND text
elseif ( $city != "" && $area != ""  && $text != "" ) {
    $args = [
        'post_type' => 'xpr_product',
        'post_status' => 'publish',
        's' => $text,
        'meta_query' => [
            ['key' => 'xpr_p_city', 'value' => $city, 'compare' => 'LIKE'] , 
            ['key' => 'xpr_p_area', 'value' => $area, 'compare' => 'LIKE'] 
        ],
        'order' => 'DESC',
        'posts_per_page' => 10,
        'paged' => $paged,
        ];
        $products = new WP_Query( $args );
}
// pr($args);
// pr($products);
if (!empty($products) && $products->post_count != 0){
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
<form action="" method="POST">
<input type="hidden" name="product_id" value="<?=$product->ID?>">
<input type="hidden" name="qty" value="1">
<?php 
if($product->xpr_sell_on_off=='Sell Online'){
echo '<button type="submit" name="add"  class="btn btn-outline-primary btn-sm">Add to Cart</button>';
}else { echo 'Buy In-Store';}
?>

</form>
</div>
</div>
</div>
<?php 
}
}else { echo "<h2><center>Sorry! No products found</center></h2>";}
wp_reset_query();
}
if (isset($_POST['add'])){
	if(isset($_POST['qty'])){
		$qty = $_POST['qty'];
}else{
		$qty = 1;
}
$pid = $_POST['product_id'];

$_SESSION['cart'][$pid] = array('qty' => $qty);
// header('location:http://localhost/xpreskart/');
?>
<script>window.location.href='http://localhost/xpreskart/checkout'</script>
<?php
// pr($_SESSION['cart']);
}
$template = ob_get_contents();
ob_end_clean();
echo $template;
?>
</div><!-- End of product Row -->
</div><!-- End of container-fluid -->
<?php get_template_part('/footer'); ?>
</body>
</html>