<?php
session_start();
/* Template Name: Cart */
ob_start();
if ( is_user_logged_in() && current_user_can( 'customer' ) || current_user_can( 'seller' ) || current_user_can('administrator')) {
$customer_id = get_current_user_id();
$user_data = get_user_meta($customer_id);

// pr($_SESSION['cart']);
if(isset($_POST['del'])){
 $remove = $_POST['del'];
 foreach($_SESSION['cart'] as $pid => $qty){
  //  pr($key);
   if($pid==$remove){
       unset($_SESSION['cart'][$pid]);
   }
 }
 if (empty($_SESSION['cart'])) {
  unset($_SESSION['cart']);
  // session_destroy();
  echo "<script>window.location.href = 'http://localhost/xpreskart/'</script>";
 }
}
// pr($_SESSION['cart']);

$cLat = get_user_meta( $customer_id, 'xpr_c_latitude', true );
$cLon = get_user_meta( $customer_id, 'xpr_c_longitude', true );


get_template_part('header');
?>
<body class="d-flex flex-column h-100">
<?php get_template_part('/nav'); ?>
<div class="container-fluid"><!-- container-fluid -->

<!-- <center><h2><b>Bismillahirrahmannnirraheeem</b></h2></center> -->
<center><h2>Your <b>Cart</b></h2></center>
<?php
// pr($_SESSION['cart']);
// pr($user_data);
if (isset($_SESSION['cart'])) {
  echo '<div class="row justify-content-center"><!-- Row 1 -->
  <div class="table-responsive-md">
  <table class="table text-center table-sm">
   <thead>
    <tr>
     <th scope="col">Image</th>
     <th scope="col">ID</th>
     <th scope="col">Name</th>
     <th scope="col">Qty</th>
     <th scope="col">Price</th>
     <th scope="col">Distance</th>
     <th scope="col">Delivery Cost</th>
     <th scope="col">SubTotal</th>
     <th scope="col">Remove</th>
    </tr>
   </thead>
   <tfoot>
    <tr>
     <th scope="col">Image</th>
     <th scope="col">ID</th>
     <th scope="col">Name</th>
     <th scope="col">Qty</th>
     <th scope="col">Price</th>
     <th scope="col">Distance</th>
     <th scope="col">Delivery Cost</th>
     <th scope="col">SubTotal</th>
     <th scope="col">Remove</th>
    </tr>
   </tfoot>
  <tbody>';
  $cart = $_SESSION['cart'];
  $total = 0;
  
  // pr($cart);
  foreach ($cart as $pid => $qty){
    // pr($pid);
    // pr($qty);
      $products = get_post($pid);
      // pr($products);
      $pLat = get_post_meta( $pid, 'xpr_p_latitude', true );
      $pLon = get_post_meta( $pid, 'xpr_p_longitude', true );
      // Calculate distance between latitude and longitude
      $theta    = $pLon - $cLon;
      $dist    = sin(deg2rad($pLat)) * sin(deg2rad($cLat)) +  cos(deg2rad($pLat)) * cos(deg2rad($cLat)) * cos(deg2rad($theta));
      $dist    = acos($dist);
      $dist    = rad2deg($dist);
      $miles    = $dist * 60 * 1.1515;
      $km = round($miles * 1.609344, 2);
      // $qty = 1;
      $del_cost = 0;
      $two_wheeler = 24.999;
      
      // $qty = $qty['qty'];
      "Actual weight ".$pWeight = get_post_meta( $pid, 'weight', true )."</br>";
      "Selected weight ".$actualWeight = ((int)$pWeight*(int)$qty['qty'])."</br>";
      $actualWeight = ((int)$actualWeight);
      if( $actualWeight <= 24.999 ){
        $del_cost = 10;
        $del_cost = round($km,0.5)*$del_cost;
      }
      if( $actualWeight >= 25.000 ){
        $del_cost = 20;
        $del_cost = round($km,0.5)*$del_cost;
      }
      ?>
      <?php
      $product_thumbnail_url = get_the_post_thumbnail_url($pid, 'thumbnail');
      echo '<tr>
      <td><img src="'.esc_url($product_thumbnail_url).'" class="cartimg-thumb"></td>
      <td>'.$products->ID.'</td>
      <td>'.$products->post_title.'</td>
      <td>'.$qty['qty'].'</td>
      <td class="price">'.$products->price.' Rs</td>
      <td>'.$km.' KM</td>
      <td class="delCost">'.$del_cost.' Rs</td>
      <td class="subTotal">'.(int)$products->price*($qty['qty'] )+($del_cost).' Rs</td>
      <td>
      <form method="POST" id="remove">
      <input type="hidden" name="product_id" value="'.$products->ID.'">
       <a type="button" id="remove_btn" data-removeid="'.$products->ID.'"><img src="'.get_stylesheet_directory_uri() . '/sellerDashboard/img/trash-fill.svg'.'">
       </a>
      </form>
      </td>
      </tr>';
      $total = $total +  ($products->price * $qty['qty']+$del_cost);
  }
  echo '</tbody>
  </table>
  </div>
  </div><!-- Row End 1 -->
<div class="row justify-content-center mt-2"><!-- Row 2-->
 <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5 col-xl-4 col-xxl-3 mt-2">
  <div class="accordion" id="cart">
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingBillingDetails">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#billingDetails" aria-expanded="true" aria-controls="billingDetails">
        Billing Details
        </button>
      </h2>
      <div id="billingDetails" class="accordion-collapse collapse" aria-labelledby="headingBillingDetails" data-bs-parent="#cart">
        <div class="accordion-body">
          <center><strong>Billing Details</strong></center>
          <div class = "text-center mb-3">
           <label class = "text-center" id = "xpr_b_username">Username</label>
           <input type = "text" name="xpr_b_username" id="xpr_b_username" value="'.$user_data['xpr_b_username'][0].'" class = "form-control" placeholder = "Username">

           <label class = "text-center" id = "xpr_billing_address">Address</label>
           <input type = "text" name="xpr_billing_address" id="xpr_billing_address" value="'.$user_data['xpr_billing_address'][0].'" class = "form-control" placeholder = "Address">

           <label class = "text-center" id = "xpr_billing_phone">Phone</label>
           <input type = "text" name="xpr_billing_phone" id="xpr_billing_phone" value="'.$user_data['xpr_billing_phone'][0].'" class = "form-control" placeholder = "Phone">

           <label class = "text-center" id = "xpr_billing_email">Email</label>
           <input type = "text" name="xpr_billing_email" id="xpr_billing_email" value="'.$user_data['xpr_billing_email'][0].'" class = "form-control" placeholder = "Email">
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
      <div id="deliveryDetails" class="accordion-collapse collapse" aria-labelledby="headingdeliveryDetails" data-bs-parent="#cart">
        <div class="accordion-body">
        <center><strong>delivery Details</strong></center>
        <div class = "text-center mb-3">
         <label class = "text-center" id = "xpr_d_username">Username</label>
         <input type = "text" name="xpr_d_username" id="xpr_d_username" value="'.$user_data['xpr_d_username'][0].'" class = "form-control" placeholder = "Username">

         <label class = "text-center" id = "xpr_delivery_address">Address</label>
         <input type = "text" name="xpr_delivery_address" id="xpr_delivery_address" value="'.$user_data['xpr_delivery_address'][0].'" class = "form-control" placeholder = "Address">

         <label class = "text-center" id = "xpr_delivery_phone">Phone</label>
         <input type = "text" name="xpr_delivery_phone" id="xpr_delivery_phone" value="'.$user_data['xpr_delivery_phone'][0].'" class = "form-control" placeholder = "Phone">

         <label class = "text-center" id = "xpr_delivery_email">Email</label>
         <input type = "text" name="xpr_delivery_email" id="xpr_delivery_email" value="'.$user_data['xpr_delivery_email'][0].'" class = "form-control" placeholder = "Email">
        </div>
        </div>
      </div>
    </div>
  </div>
  <center><h4 class="mt-3">Your order</h4></center>
  <hr>
   <div class="clearfix">
    <h6 class="my-0 float-start"><b>Total Order</b></h6>
    <h6 class="my-0 float-end gTotal"><b>'.$total.'</b></h6>
   </div><hr><br>
  <button type="submit" name="xpr_order" id="xprOrder" value="Order" class="btn btn-outline-primary btn-block ripple-surface mt-2 mb-5">Place Your Order</button>
 </div>
</div><!-- Row 2 end-->';
}else {echo '<center><h3>Your Cart is Empty</h3></center>';}

//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders
//
// if( isset( $total ) ) { $total;} else{ $total = 1.00; }
// $price = $total;
// $_SESSION['price'] = $price;
// $customername = $customer_id;
// $email = 'ali@xpreskart.com';
// $_SESSION['email'] = $email;
// $contactno = 9999999999;

// $orderData = [
//     'receipt'         => 3456,
//     'amount'          => $price * 100, // 2000 rupees in paise
//     'currency'        => 'INR',
//     'payment_capture' => 1 // auto capture
// ];

// $razorpayOrder = $api->order->create($orderData);
// // pr($razorpayOrder);

// $razorpayOrderId = $razorpayOrder['id'];

// $_SESSION['razorpay_order_id'] = $razorpayOrderId;

// $displayAmount = $amount = $orderData['amount'];

// if ($displayCurrency !== 'INR')
// {
//     $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
//     $exchange = json_decode(file_get_contents($url), true);

//     $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
// }

// $data = [
//     "key"               => $keyId,
//     "amount"            => $amount,
//     "name"              => "XpresKart",
//     "description"       => "DisKover LoKal Shops",
//     "image"             => "http://localhost/xpreskart/xpreskart.png",
//     "prefill"           => [
//     "name"              => $customername,
//     "email"             => $email,
//     "contact"           => $contactno,
//     ],
//     "notes"             => [
//     "address"           => "Hello World",
//     "order_id"          => "12312321",
//     ],
//     "theme"             => [
//     "color"             => "#4b0082"
//     ],
//     "order_id"          => $razorpayOrderId,
//     // "callback_url"      => "http://localhost/xpreskart/your-account/",
// ];

// if ($displayCurrency !== 'INR')
// {
//     $data['display_currency']  = $displayCurrency;
//     $data['display_amount']    = $displayAmount;
// }

// $json = json_encode($data);
// pr($json);

?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<form name='razorpayform' action="" method="POST">
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_order_id"  id="razorpay_order_id" >
    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
</form>
<script>
// Checkout details as a json
var options = <?php echo $json?>;
/**
* The entire list of checkout fields is available at
* https://docs.razorpay.com/docs/checkout-form#checkout-fields
*/
options.handler = function(response){
    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
    document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
    document.getElementById('razorpay_signature').value = response.razorpay_signature;
    console.log(response);
    document.razorpayform.submit();
    
};

// // Boolean whether to show image inside a white frame. (default: true)
// options.theme.image_padding = false;

var rzp = new Razorpay(options);

document.getElementById('xprOrder').onclick = function(e){
    rzp.open();
    // e.preventDefault();
}
</script>

<?php 
// pr($_SESSION['cart']);
$cart2 = "<script>document.write(localStorage.getItem('cart2'))</script>";
$cart2 =json_encode($cart2);
pr(json_decode($cart2));
if (isset($_POST['razorpay_payment_id'])) {
$razorpayPaymentId = $_POST['razorpay_payment_id'];
// $razorpayOrderId = $_SESSION['razorpay_order_id'];
$razorpaySignature = $_POST['razorpay_signature'];

// if (!empty($razorpayPaymentId) || !empty($razorpayOrderId) || !empty($razorpaySignature) || !empty($customer_id)) {
  $pids=[];
  $cart = $_SESSION['cart'];
  foreach ($cart as $pid => $qty){
    $products = get_post($pid);
    $pLat = get_post_meta( $pid, 'xpr_p_latitude', true );
    $pLon = get_post_meta( $pid, 'xpr_p_longitude', true );
    // Calculate distance between latitude and longitude
    $theta    = $pLon - $cLon;
    $dist    = sin(deg2rad($pLat)) * sin(deg2rad($cLat)) +  cos(deg2rad($pLat)) * cos(deg2rad($cLat)) * cos(deg2rad($theta));
    $dist    = acos($dist);
    $dist    = rad2deg($dist);
    $miles    = $dist * 60 * 1.1515;
    $km = round($miles * 1.609344, 2);
  
    $del_cost = 0;
    $two_wheeler = 24.999;
        
    // $qty = $qty['qty'];
    "Actual weight ".$pWeight = get_post_meta( $pid, 'weight', true )."</br>";
    "Selected weight ".$actualWeight = ((int)$pWeight*(int)$qty['qty'])."</br>";
    $actualWeight = ((int)$actualWeight);
    if( $actualWeight <= 24.999 ){
      $del_cost = 10;
      $del_cost = round($km,0.5)*$del_cost;
    }
    if( $actualWeight >= 25.000 ){
      $del_cost = 20;
      $del_cost = round($km,0.5)*$del_cost;
    }
    
    $subTotal = (int)$products->price*($qty['qty'] )+($del_cost);
  
    $pids[$pid] = ['qty'=>$qty['qty'],'price' => $products->price,'distance'=>$km,'delCost' => $del_cost,'subTotal' => $subTotal,];
  }
  pr($pids);
  echo $total;
$razorPaymentDetails = serialize([
                        'razorpay_payment_id' => $razorpayPaymentId,
                        'razorpay_order_id' => $razorpayOrderId,
                        'razorpay_signature' => $razorpaySignature
                       ]);

$orderDetails = serialize([
                    'orderDetails' => $pids,
                    'totalOrder' => $total,
                   ]);
$orderBillDetails = serialize([
                   'xpr_b_username' => $user_data['xpr_b_username'][0],
                   'xpr_billing_address' => $user_data['xpr_billing_address'][0],
                   'xpr_billing_phone' => $user_data['xpr_billing_phone'][0],
                   'xpr_billing_email' => $user_data['xpr_billing_email'][0],
                   'xpr_d_username' => $user_data['xpr_d_username'][0],
                   'xpr_delivery_address' => $user_data['xpr_delivery_address'][0],
                   'xpr_delivery_phone' => $user_data['xpr_delivery_phone'][0],
                   'xpr_delivery_email' => $user_data['xpr_delivery_email'][0],
                  ]);
// $xprDelDetails =  serialize([
//                     'xpr_d_username' => $user_data['xpr_d_username'][0],
//                     'xpr_delivery_address' => $user_data['xpr_delivery_address'][0],
//                     'xpr_delivery_phone' => $user_data['xpr_delivery_phone'][0],
//                     'xpr_delivery_email' => $user_data['xpr_delivery_email'][0],
//                   ]);
                  
function xpr_order($customer_id, $razorPaymentDetails, $orderDetails, $orderBillDetails) {
  $args = array(
    'ID'           => 63,
      'post_author' => $customer_id,
      'post_title' => $razorPaymentDetails,
      'post_content' => $orderDetails,
      'post_excerpt' => $orderBillDetails,
      'post_status' => 'publish',
      'post_type' => 'xpr_seller_orders',
  );
  $xpr_order_id = wp_insert_post($args);
  add_post_meta($xpr_order_id, NULL, 'pending');
  // add_post_meta($xpr_order_id, 'xpr_billing_address', $user_data['xpr_billing_address'][0]);
  // add_post_meta($xpr_order_id, 'xpr_billing_phone', $user_data['xpr_billing_phone'][0]);
  // add_post_meta($xpr_order_id, 'xpr_billing_email', $user_data['xpr_billing_email'][0]);
  // add_post_meta($xpr_order_id, 'xpr_d_username', $user_data['xpr_d_username'][0]);
  // add_post_meta($xpr_order_id, 'xpr_delivery_address', $user_data['xpr_delivery_address'][0]);
  // add_post_meta($xpr_order_id, 'xpr_delivery_phone', $user_data['xpr_delivery_phone'][0]);
  // add_post_meta($xpr_order_id, 'xpr_delivery_email', $user_data['xpr_delivery_email'][0]);
}
xpr_order($customer_id, $razorPaymentDetails, $orderDetails, $orderBillDetails);
}
// }
// pr($_POST);
?>
</div><!-- End of container-fluid -->
<!-- Remove Product -->
<!-- <div class="modal fade" id="removeProduct" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="removeProduct" aria-hidden="true">
<div class="modal-dialog">
 <div class="modal-content">
 <div class="modal-header">
 <h4 class="modal-title" id="removeProduct">Remove Product</h4>
 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
 </div>
 <div class="modal-body">
 <p class="text-danger text-center">Are you sure you want to REMOVE this Product ?</p>
 </div>
 <div class="modal-footer">
 <form  method="POST">
 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
 <button type="submit" name="del" id="removeid" class="btn btn-outline-danger">Yes</button>
 </form>
 </div>
 </div>
</div>
</div> -->
<!-- Remove Product End -->
<?php get_template_part('/footer'); ?>
<script>
  // <?php $d = json_encode($_SESSION['cart']); ?>
  // var p = JSON.parse('<?=$d?>');
  // var str = JSON.stringify(p);
  // var setItem = window.localStorage.setItem('cart2', str);
  // var getItem = JSON.parse(window.localStorage.getItem('cart2', str));
  // console.log(p);
  // console.log(str);
  // console.log(setItem);
  // console.log(getItem);
  $(document).ready(function(){
  $(document).on("click", "#remove_btn", function () {
    // console.log('removeid');
  let removeid = $(this).attr('data-removeid');
  let type = 'del';
  console.log('Delete ID ='+removeid);
  myData = {removeid:removeid,type:type};
  let link = "http://localhost/xpreskart/wp-json/xpr/v1/managecart";
  $.ajax({  
			url: link,  
			type: 'POST',
			data: myData,
			success: function(data) {
			console.log(data);
			}  
		}); 
  // $("#removeid").val(removeid);
  // $('#removeProduct').modal('show');
  // $("#remove")[0].reset();
});
});
// $(document).on("click", "#remove_btn", function () {
//   var removeid = $(this).data('removeid');
//   // console.log(removeid);
//   $("#removeid").val(removeid);
//   $('#removeProduct').modal('show');
//   $("#remove")[0].reset();
// });
// $("#remove")[0].reset();
</script>
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