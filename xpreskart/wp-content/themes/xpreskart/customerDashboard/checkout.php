<?php
/* Template Name: Checkout */
if ( is_user_logged_in() && current_user_can( 'customer' ) || current_user_can('administrator')) {
get_template_part('header');
$customer_id = get_current_user_id();
$user_data = get_user_meta($customer_id);

$cLat = get_user_meta( $customer_id, 'xpr_c_latitude', true );
$cLon = get_user_meta( $customer_id, 'xpr_c_longitude', true );
?>
<body class="d-flex flex-column h-100">
<?php get_template_part('/nav'); ?>
<div class="container-fluid"><!-- container-fluid -->
<div class="row justify-content-center"><!-- product row -->
<center><h2><b>Bismillahirrahmannnirraheeem</b></h2></center>



</div><!-- End of product Row -->
</div><!-- End of container-fluid -->
<?php get_template_part('/footer'); ?>
</body>
</html>
<?php
} else {
$location = "http://localhost/xpreskart/login/";
wp_safe_redirect($location);
exit;
}