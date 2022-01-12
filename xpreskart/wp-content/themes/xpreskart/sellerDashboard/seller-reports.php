<?php /* Template Name: Seller Reports */ ?>
<?php
ob_start();
// Check if user is logged in.
if (is_user_logged_in()) {
// Get the user ID.
 $user_id = get_current_user_id();
 get_template_part('sellerDashboard/head');
 ?>
 <body id="page-top">
  <!-- Topbar -->
  <?php get_template_part('sellerDashboard/top-bar'); ?>
  <!-- End of Topbar -->
  <div class="container-fluid">
   <!-- container-fluid -->
   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo the_title(); ?></h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
     <i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
   </div>
   <div class="table-responsive"><!-- Table -->
    <table class="table  table-striped table-hover">
     <thead>
      <tr>
       <th scope="col">Image</th>
       <th scope="col">Download File</th>
       <th scope="col">Name</th>
       <th scope="col">Name</th>
       <th scope="col">Name</th>
       <th scope="col">Name</th>
       <th scope="col">Name</th>
      </tr>
     </thead>
     <?php
     $files = get_post_meta(319, 'files');
//              echo '<pre>';
//              print_r($files);die;
     $current_user = wp_get_current_user();
     $upload_dir = wp_upload_dir();
     //print_r($upload_dir['baseurl'] . '/' . $current_user->user_login . '/');
     foreach ($files as $file) {
      foreach ($file as $key) {
//                  echo '<pre>';
//                  print_r($key);
       ?>
       <tr>
        <td> <img
          src="<?php echo $upload_dir['baseurl'] . '/' . $current_user->user_login . '/' . $key; ?>"
          class="img-fluid img-thumbnail" width="100" hieght="50"></td>
        <td><a href="<?php echo $upload_dir['baseurl'] . '/' . $current_user->user_login . '/' . $key; ?>">Download</a></td>
        <td>Products Name</td>
        <td>Products Name</td>
        <td>Products Name</td>
        <td>Products Name</td>
        <td>Products Name</td>
       </tr>

       <?php
      }
     }
     ?>

     </tbody>
    </table>
   </div>
  </div><!-- End of container-fluid -->
  <?php get_template_part('sellerDashboard/foot'); ?>
 </body>

 </html>
 <?php
} else {
 $location = "http://localhost/xpreskart/login/";
 wp_safe_redirect($location);
 exit;
}
// print_r($_SERVER);
$template = ob_get_contents();
ob_end_clean();
echo $template;
##### All posts meta in Loop  #####
$files = get_post_meta($key->ID, 'files');
foreach ($files as $file) { ##### Start of Main Loop Author posts #####
<?php }##### End of Meta Loop #####?>