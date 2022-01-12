<?php /* Template Name: Seller Inventory */ ?>
<?php
session_start();
ob_start();
// Check if user is logged in.
if (is_user_logged_in()) {
 get_template_part('sellerDashboard/seller-header');
 ?>
 <body id="page-top">
  <!-- Topbar -->
  <?php get_template_part('sellerDashboard/seller-nav'); ?>
  <!-- End of Topbar -->
  <div class="container-fluid"><!-- container-fluid -->


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