<?php
/* Template Name: Your Account */
ob_start();
if ( is_user_logged_in() && current_user_can( 'customer' ) || current_user_can('administrator')) {
$customer_id = get_current_user_id();
// $con = mysqli_connect("localhost", "root", "", "xprdb");
// pr($con);
// $sql = "select * from xpr_wc_order_stats";
// pr($sql);
// $res = mysqli_query($con,$sql);
// pr($res);
// // $row = mysqli_fetch_assoc($res);
// // pr($row);
// while($row = mysqli_fetch_assoc($res)){
//     echo $row['order_id'].'<br>';
// }


// $args = array(
//  'author' => $user_id,
//  'post_type' => 'xpr_product',
//  'post_status' => 'publish',
//  'order' => 'DESC',
//  'posts_per_page' => 10,
//  'paged' => $paged,
// );
// $seller_products = new WP_Query( $args );
// pr($seller_products->posts);


if (isset($_POST['xpr_save'])) {
 $bUserName = $_POST['xpr_b_username'];
 $bAddr = $_POST['xpr_billing_address'];
 $bPhone = $_POST['xpr_billing_phone'];
 $bEmail = $_POST['xpr_billing_email'];
 $dUserName = $_POST['xpr_d_username'];
 $dAddr = $_POST['xpr_delivery_address'];
 $dPhone = $_POST['xpr_delivery_phone'];
 $dEmail = $_POST['xpr_delivery_email'];
// /**
// * Google Maps Platform Geocoding API
// **/
//   //Formatted address
//   $formattedAddr = str_replace(' ','+',$dAddr);
//   //Send request and receive json data by address
//   $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false&key=AIzaSyA5g3FtUX69ZqaytWoA_OR_-fEfU9Dty10'); 
//   $output = json_decode($geocodeFromAddr);
//   //Get latitude and longitute from json data
//   $data['latitude']  = $output->results[0]->geometry->location->lat; 
//   $data['longitude'] = $output->results[0]->geometry->location->lng;
//   //Return latitude and longitude of the given address
      

//  $cLat = 12.527683518739495;
//  $cLon = 76.90938085124905;
 $cLat = $data['latitude'];
 $cLon = $data['longitude'];
 if (empty($bUserName) || empty($bAddr) || empty($bPhone) || empty($bEmail) || empty($dUserName)) {
     echo "<script>alert('EMPTY');</script>";
 } else {
   update_user_meta($customer_id, 'xpr_b_username', $bUserName);
   update_user_meta($customer_id, 'xpr_billing_address', $bAddr);
   update_user_meta($customer_id, 'xpr_billing_phone', $bPhone);
   update_user_meta($customer_id, 'xpr_billing_email', $bEmail);
   update_user_meta($customer_id, 'xpr_d_username', $dUserName);
   update_user_meta($customer_id, 'xpr_delivery_address', $dAddr);
   update_user_meta($customer_id, 'xpr_delivery_phone', $dPhone);
   update_user_meta($customer_id, 'xpr_delivery_email', $dEmail);
   update_user_meta($customer_id, 'xpr_c_latitude', $cLat);
   update_user_meta($customer_id, 'xpr_c_longitude', $cLon);
 }
}
$user_data = get_user_meta($customer_id);
get_template_part('header');
?>
<body class="d-flex flex-column h-100">
<?php get_template_part('/nav');pr($output); ?>
<div class="container-fluid"><!-- container-fluid -->
<div class="row justify-content-center"><!-- Row 1 -->
<!-- <center><h2><b>Bismillahirrahmannnirraheeem</b></h2></center> -->
<center><h2>Your <b>Account</b></h2></center>
<ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="pills-addresses-tab" data-bs-toggle="pill" data-bs-target="#pills-addresses" type="button" role="tab" aria-controls="pills-addresses" aria-selected="true">Addresses</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-orders-tab" data-bs-toggle="pill" data-bs-target="#pills-orders" type="button" role="tab" aria-controls="pills-orders" aria-selected="false">Orders</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</button>
  </li>
</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active mx-auto col-xs-12 col-sm-12 col-md-6 col-lg-5 col-xl-4 col-xxl-3" id="pills-addresses" role="tabpanel" aria-labelledby="pills-addresses-tab">
  <form action = "" method = "post" enctype = "multipart/form-data" id="billing&delivery">
  <div class="accordion" id="yourAccount">
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingBillingDetails">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#billingDetails" aria-expanded="true" aria-controls="billingDetails">
        Billing Details
        </button>
      </h2>
      <div id="billingDetails" class="accordion-collapse collapse" aria-labelledby="headingBillingDetails" data-bs-parent="#yourAccount">
        <div class="accordion-body">
          <center><strong>Billing Details</strong></center>
          <div class = "text-center mb-3">
           <label class = "text-center" id = "xpr_username">Username</label>
           <input type = "text" name="xpr_b_username" id="xpr_b_username" value="<?=$user_data['xpr_b_username'][0]?>" class = "form-control" placeholder = "Username">

           <label class = "text-center" id = "xpr_billing_address">Address</label>
           <input type = "text" name="xpr_billing_address" id="xpr_billing_address" value="<?=$user_data['xpr_billing_address'][0]?>" class = "form-control" placeholder = "Address">

           <label class = "text-center" id = "xpr_billing_phone">Phone</label>
           <input type = "text" name="xpr_billing_phone" id="xpr_billing_phone" value="<?=$user_data['xpr_billing_phone'][0]?>" class = "form-control" placeholder = "Phone">

           <label class = "text-center" id = "xpr_billing_email">Email</label>
           <input type = "text" name="xpr_billing_email" id="xpr_billing_email" value="<?=$user_data['xpr_billing_email'][0]?>" class = "form-control" placeholder = "Email">
          </div>
        </div>
      </div>
    </div>
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingdeliveryDetails">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#deliveryDetails" aria-expanded="false" aria-controls="deliveryDetails">
        Delivery Details
        </button>
      </h2>
      <div id="deliveryDetails" class="accordion-collapse collapse" aria-labelledby="headingdeliveryDetails" data-bs-parent="#yourAccount">
        <div class="accordion-body">
        <center><strong>Delivery Details</strong></center>
        <div class = "text-center mb-3">
         <label class = "text-center" id = "xpr_d_username">Username</label>
         <input type = "text" name="xpr_d_username" id="xpr_d_username" value="<?=$user_data['xpr_d_username'][0]?>" class = "form-control" placeholder = "Username">

         <label class = "text-center" id = "xpr_delivery_address">Address</label>
         <input type = "text" name="xpr_delivery_address" id="xpr_delivery_address" value="<?=$user_data['xpr_delivery_address'][0]?>" class = "form-control" placeholder = "Address">

         <label class = "text-center" id = "xpr_delivery_phone">Phone</label>
         <input type = "text" name="xpr_delivery_phone" id="xpr_delivery_phone" value="<?=$user_data['xpr_delivery_phone'][0]?>" class = "form-control" placeholder = "Phone">

         <label class = "text-center" id = "xpr_delivery_email">Email</label>
         <input type = "text" name="xpr_delivery_email" id="xpr_delivery_email" value="<?=$user_data['xpr_delivery_email'][0]?>" class = "form-control" placeholder = "Email">
        </div>
        </div>
      </div>
    </div>
  </div>
  <button type="submit" name="xpr_save" id="xprSave" value="Save" class="btn btn-outline-primary btn-block ripple-surface mt-5">Save</button>
  </form><!-- Billing & delivery End -->
  </div>
 
  <div class="tab-pane fade" id="pills-orders" role="tabpanel" aria-labelledby="pills-orders-tab">
  <?php 
  $cusOrders = array(
    'author' => $customer_id,
    'post_type' => 'xpr_seller_orders',
    'posts_per_page' => 10,
    'post_status' => 'publish',
    );
    $cusOrder = get_posts($cusOrders);
    // pr($cusOrder);
  if(!empty($cusOrder)){ ?>
  <div class="row justify-content-center"><!-- Row 2 -->
  <center><strong><h3>Orders</h3></strong></center>
   <div class="table-responsive-md">
    <table class="table text-center table-sm">
     <thead>
      <tr>
       <th scope="col">Order No.</th>
       <th scope="col">Order Amount</th>
       <th scope="col">Date</th>
       <th scope="col">Products</th>
       <th scope="col">Status</th>
       <th scope="col">View</th>
      </tr>
     </thead>
     <tfoot>
      <tr>
       <th scope="col">Order No.</th>
       <th scope="col">Order Amount</th>
       <th scope="col">Date</th>
       <th scope="col">Products</th>
       <th scope="col">Status</th>
       <th scope="col">View</th>
      </tr>
     </tfoot>
     <tbody>
<?php     
    foreach($cusOrder as $key1 => $orderDetails){
      // pr($orderDetails);
      $post_content = unserialize($orderDetails->post_content);
      $pids = $post_content['orderDetails'];
      // pr($post_content);

      // pr($product);
      // pr($d2[$key2]['price']);
      // $product_thumbnail_url = get_the_post_thumbnail_url($key2, 'thumbnail');
      // if(!empty($product[0]->post_title)){
      //     $order_status = get_post_meta( $orderDetails->ID, $product[0]->ID, true );
      //     // pr($order_status);
?>
     <tr>
        <td><?=$orderDetails->ID?></td>
        <td><?=$post_content['totalOrder']?></td>
        <td><?=$orderDetails->post_date?></td>
<?php        
        // foreach($pids as $key2 => $val2){
        //   pr($val2);
        //   $products = array(
        //   // 'author'        =>  $user_id,
        //   'post__in' =>  array($key2),
        //   'post_type' => 'xpr_product',
        //   // 'posts_per_page' => 10,
        //   'post_status' => 'publish',
        //   );
        //   $product = get_posts($products); 
          $count = count($post_content); ?>
        <td><?=$count?></td>  
<?php //} ?>

        <td><?='status'?></td>
        <td><?=$orderDetails->ID?></td>
     </tr>
<?php } ?>
    </tbody>
    </table>
   </div>
  </div>
  <?php } ?>
  </div>
  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>

</div>
</div><!-- Row 1 End -->
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
$template = ob_get_contents();
ob_end_clean();
echo $template;