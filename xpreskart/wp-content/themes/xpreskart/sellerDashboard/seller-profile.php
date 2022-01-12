<?php
/* Template Name: Seller Profile */
ob_start();
// Check if user is logged in.
if ( is_user_logged_in() && current_user_can( 'seller' ) || current_user_can('administrator')) {
// Get the user ID.
$user_id = get_current_user_id();
get_template_part('sellerDashboard/seller-header');
?>
<body class="d-flex flex-column h-100">
<?php get_template_part('sellerDashboard/seller-nav'); ?>
<div class="container-fluid"><!-- container-fluid -->
<center><h2><b>Bismillahirrahmannnirraheeem</b></h2></center>
<center><h4><b>Seller Profile</b></h4></center>
 <div class="row justify-content-center"><!-- row start-->


 </div><!-- row end-->
</div><!-- End of container-fluid -->
<?php get_template_part('sellerDashboard/seller-footer'); ?>
</body>
</html>
<?php
} else {
$location = "http://localhost/xpreskart/login/";
wp_safe_redirect($location);
exit;
}
$template = ob_get_contents();
ob_end_clean();
echo $template;
?>