<?php
/* Template Name: Seller Add Product */
ob_start();
// Check if user is logged in.
if ( is_user_logged_in() && current_user_can( 'seller' ) || current_user_can('administrator')) {
 // Get the user ID.
 $user_id = get_current_user_id();
 // Get the user object.
 $user_meta = get_userdata($user_id);  
 $sLat = get_user_meta( $user_id, 'xpr_s_latitude', true );
 $sLon = get_user_meta( $user_id, 'xpr_s_longitude', true );
######################################## ADD PRODUCT START #################################################################


 function xpr_insert_product($post_author, $pName, $pDescription, $pShortDescription, $pMrp, $pPrice, $pSku, $pStockStatus, $pSellOnOff, $pWeight, $pLenght, $pWidth, $pHeight, $pCat, $sLat, $sLon) {
  $args = array(
      'post_author' => $post_author,
      'post_title' => $pName,
      'post_content' => $pDescription,
      'post_excerpt' => $pShortDescription,
      'post_status' => 'publish',
      'post_type' => 'xpr_product',
  );
  $product_id = wp_insert_post($args);

// WordPress environment
  require_once ABSPATH . 'wp-load.php';
  $current_user = wp_get_current_user();
  $upload_dir = wp_upload_dir();
// $upload_dir['path'] is the full server path to wp-content/uploads/2017/05, for multisite works good as well
  // $upload_dir['url'] the absolute URL to the same folder, actually we do not need it, just to show the link to file
  if (isset($current_user->user_login) && !empty($upload_dir['basedir'])) {
   $user_dirname = $upload_dir['basedir'] . '/' . $current_user->user_login;
   // print_r($user_dirname);
   if (!file_exists($user_dirname)) {
    wp_mkdir_p($user_dirname);
   }
  }
  $feaImg = $_FILES['feaimg'];
  $new_file_path1 = $user_dirname . '/' . $feaImg['name'];
  // $new_file_mime = mime_content_type($feaImg['tmp_name']);

  // if (empty($feaImg)) {
  //  die('File is not selected.');
  // }

  // if ($feaImg['error']) {
  //  die($feaImg['error']);
  // }

  // if ($feaImg['size'] > wp_max_upload_size()) {
  //  die('It is too large than expected.');
  // }

  // if (!in_array($new_file_mime, get_allowed_mime_types())) {
  //  die('This file type is acceptable');
  // }

  // while (file_exists($new_file_path)) {
  //  $i++;
  //  $new_file_path = $user_dirname . '/' . $i . '_' . $feaImg['name'];
  // }

// looks like everything is OK
  if (move_uploaded_file($feaImg['tmp_name'], $new_file_path1)) {

   $upload_id1 = wp_insert_attachment(array(
       'guid' => $new_file_path1,
       'post_mime_type' => $feaImg['type'],
       'post_title' => preg_replace('/\.[^.]+$/', '', $feaImg['name']),
       'post_content' => $feaImg['name'],
       'post_status' => 'inherit',
       'post_parent' => $product_id,
           ), $new_file_path1);

   // wp_generate_attachment_metadata() won't work if you do not include this file
   require_once ABSPATH . 'wp-admin/includes/image.php';

   // Generate and save the attachment metas into the database
   wp_update_attachment_metadata($upload_id1, wp_generate_attachment_metadata($upload_id1, $new_file_path1));

   set_post_thumbnail($product_id, $upload_id1);
   // Show the uploaded file in browser
   // wp_redirect($wordpress_upload_dir['url'] . '/' . basename($new_file_path));
   //  echo '<img src="'.$wordpress_upload_dir['url'] . '/' . basename($new_file_path).'">';
  }
##############################################################################################################################
  $galImg = $_FILES['galimg'];
  // pr($_FILES['galimg']);
  foreach ($_FILES['galimg']['name'] as $key => $val) {
   $new_file_path = $user_dirname . '/' . $_FILES['galimg']['name'][$key];
   $new_gal_mime = $_FILES['galimg']['type'][$key];
   $temploc = $_FILES['galimg']['tmp_name'][$key];
// looks like everything is OK
   if (move_uploaded_file($temploc, $new_file_path)) {
    // prd($new_file_path);
    $gal = wp_insert_attachment(array(
        'guid' => $new_file_path,
        'post_mime_type' => $new_gal_mime,
        'post_title' => preg_replace('/\.[^.]+$/', '', $_FILES['galimg']['name'][$key]),
        'post_content' => $_FILES['galimg']['name'][$key],
        'post_status' => 'inherit',
        'post_parent' => $product_id,
            ), $new_file_path);
    // $galIds .= $gal . ",";
    $galIds[] = $gal;
    // wp_generate_attachment_metadata() won't work if you do not include this file
    require_once ABSPATH . 'wp-admin/includes/image.php';
    // Generate and save the attachment metas into the database
    wp_update_attachment_metadata($gal, wp_generate_attachment_metadata($gal, $new_file_path));
   }
  }
##################################################################################################################################
  
add_post_meta($product_id, 'product_image_gallery', $galIds);
add_post_meta($product_id, 'xpr_p_latitude', $sLat);
add_post_meta($product_id, 'xpr_p_longitude', $sLon);
add_post_meta($product_id, 'stock_status', $pStockStatus);
add_post_meta($product_id, 'xpr_sell_on_off', $pSellOnOff);
add_post_meta($product_id, 'weight', $pWeight);
add_post_meta($product_id, 'length', $pLenght);
add_post_meta($product_id, 'width', $pWidth);
add_post_meta($product_id, 'height', $pHeight);
add_post_meta($product_id, 'sku', $pSku);
add_post_meta($product_id, 'mrp', $pMrp);
add_post_meta($product_id, 'price', $pPrice);
 }

 if (isset($_POST['xpr_save'])) {
  $post_author = $_POST[$user_id];
  // print_r($post_author);die();
   $pName = $_POST['xpr_name'];
   $pDescription = $_POST['xpr_description'];
   $pShortDescription = $_POST['xpr_short_description'];
   $pCat = $_POST['p_cat_id'];
   $pStockStatus = $_POST['xpr_stock_status'];
   $pSellOnOff = $_POST['xpr_sell_on_off'];
   $pWeight = $_POST['xpr_weight'];
   $pLenght = $_POST['xpr_lenght'];
   $pWidth = $_POST['xpr_width'];
   $pHeight = $_POST['xpr_height'];
   $pSku = $_POST['xpr_sku'];
   $pMrp = $_POST['xpr_mrp'];
   $pPrice = $_POST['xpr_price'];
   $pStatus = $_POST['publish'];
   wp_set_post_terms( $product_id, $pCat, 'xpr_category' );// postid, termid, taxonomy
  if (empty($pName) || empty($pDescription) || empty($pShortDescription) || empty($pMrp) || empty($pPrice)) { /* EMPTY START */
   echo "<script>alert('EMPTY');</script>";
  } /* EMPTY END */ else { /* ELSE RUN LOGIC */
   xpr_insert_product($post_author, $pName, $pDescription, $pShortDescription, $pMrp, $pPrice, $pSku, $pStockStatus, $pSellOnOff, $pWeight, $pLenght, $pWidth, $pHeight, $pCat, $sLat, $sLon);
   echo "<script>alert($product_id .'Product Saved');</script>";
   $location = "http://localhost/xpreskart/catalog/";
   wp_safe_redirect($location);
   // exit;
   echo '<meta http-equiv="refresh" content="0;url=http://localhost/xpreskart/catalog/" />';
  } /* ELSE END LOGIC */
 } /* ISSET END */
######################################## ADD PRODUCT END #################################################################

 get_template_part('sellerDashboard/seller-header');
 ?>
 <body class="d-flex flex-column h-100">
  <!-- Topbar -->
  <?php get_template_part('sellerDashboard/seller-nav'); ?>
  <!-- End of Topbar -->
  <div class="container-fluid"><!-- container-fluid -->
   <div class="row justify-content-center"><!-- row start-->
    <div class="col-sm-12 col-md-6 col-lg-5 col-xl-4"><!-- col start-->
     <!--Add Product -->
     <form action = "" method = "post" enctype = "multipart/form-data" id="addProduct">
      <!-- <input type="hidden" name="_nonce" value="<?php //echo wp_create_nonce('edit_product'); ?>"> -->
      <div class="text-center mb-3">
       <label class="text-center" id="xprName">Name</label>
       <input type="text" name = "xpr_name" id = "xprName" class="form-control" placeholder="Product Name" aria-label="Product Name/Title" aria-describedby="xprName">
      </div>
      <div class="text-center mb-3">
       <label class="text-center">Description</label>
       <textarea class="form-control" name = "xpr_description" id = "xprDescription" placeholder="Description" aria-label="Description"></textarea>
      </div>
      <div class="text-center mb-3">
       <label class="text-center" id="xprShortDescription">Short Description</label>
       <input type="text" name = "xpr_short_description" id = "xprShortDescription" class="form-control" placeholder="Short Description" aria-label="Short Description" aria-describedby="xprShortDescription">
      </div>
      <div class="text-center mb-3">
       <label class="text-center" for="feaImg">Feature Image</label>
       <input type="file" name="feaimg" id="feaImg" onclick="myFunction()" class="form-control" >
       <div class = "col-2 mt-2 mb-3">
        <img src="" id="feaImgPreview" alt="" class="img-fluid dashimg-thumbnail">
       </div>
      </div>
      <div class="text-center mb-3">
       <label class="text-center" for="galImg">Product Gallery</label>
      </div>
      <div class="input-images mb-3"></div>
      <div class="text-center mb-3">
      <select class="form-select" name="p_cat_id" aria-label='Default select example'>
      <option selected>Please Select a Category</option>
      <?php
        $args = array(
        'taxonomy'   => 'xpr_category',
        'orderby'    => 'name',
        'order' => 'ASC',
        'hide_empty' => false,
        'include' => 'all',
        'hierarchical' => true,
        );
        $product_cat = get_terms($args);
      foreach($product_cat as $cat) {?>
      <option value=<?=$cat->term_id?>><?=$cat->name?></option>
            <?php }?>
            </select>
            </div>
      <div class="form-check">
       <input type="radio" id="xprInstock" name="xpr_stock_status" value="instock" autocomplete="off" class="form-check-input btn-check">
       <label class="btn btn-outline-primary mt-2 mb-2" for="xprInstock">In Stock</label>
       <input type="radio" id="xprOutofStock" name="xpr_stock_status" value="outofstock" autocomplete="off" class="form-check-input btn-check">
       <label class="btn btn-outline-primary mt-2 mb-2" for="xprOutofStock">Out of Stock</label>
      </div>
      <div class="form-check">
       <input type="radio" id="sellOnline" name="xpr_sell_on_off" value="Sell Online" autocomplete="off" class="form-check-input btn-check">
       <label class="btn btn-outline-primary mt-2 mb-2" for="sellOnline">Sell Online</label>
       <input type="radio" id="sellOffline" name="xpr_sell_on_off" value="Sell Offline" autocomplete="off" class="form-check-input btn-check">
       <label class="btn btn-outline-primary mt-2 mb-2" for="sellOffline">Sell Instore</label>
      </div>
      <div class="text-center mb-3">
       <label class="text-center" id="xprWeight">kg</label>
       <input type="text" name = "xpr_weight" id = "xprWeight" class="form-control" placeholder="Weight in kilograms" aria-label="Weight in kilograms" aria-describedby="xprWeight">
      </div>
      <div class="text-center mb-3">
       <label class="text-center" id="xprLenght">cm</label>
       <input type="text" name = "xpr_lenght" id = "xprLenght" class="form-control" placeholder="Lenght in centimetres" aria-label="Lenght in centimetres" aria-describedby="xprLenght">
      </div>
      <div class="text-center mb-3">
       <label class="text-center" id="xprWidth">cm</label>
       <input type="text" name = "xpr_width" id = "xprWidth" class="form-control" placeholder="Width in centimetres" aria-label="Width in centimetres" aria-describedby="xprWidth">
      </div>
      <div class="text-center mb-3">
       <label class="text-center" id="xprHeight">cm</label>
       <input type="text" name = "xpr_height" id = "xprHeight" class="form-control" placeholder="Height in centimetres" aria-label="Height in centimetres" aria-describedby="xprHeight">
      </div>
      <div class="text-center mb-3">
       <label class="text-center" id="xprSku">SKU</label>
       <input type="text" name = "xpr_sku" id = "xprSku" class="form-control" placeholder="SKU" aria-label="SKU" aria-describedby="xprSku">
      </div>
      <div class="text-center mb-3">
       <label class="text-center">MRP</label>
       <label class="text-center">&#8377</label>
       <input type="text" name="xpr_mrp" id="xprMrp" class="form-control" placeholder="MRP">
      </div>
      <div class="text-center mb-3">
       <label class="text-center">Price</label>
       <label class="text-center">&#8377</label>
       <input type="text" name="xpr_price" id="xprPrice" class="form-control" placeholder="Price">
      </div>
      <button type="submit" name="xpr_save" id="xprSave" value="Save" class="btn btn-outline-primary btn-block ripple-surface mb-5">Save</button>
     </form><!-- Add Product End -->
    </div><!-- col end-->
   </div><!-- row end-->
  </div><!-- End of container-fluid -->
  <?php get_template_part('sellerDashboard/seller-footer'); ?>
 </body>
 </html>
 <script>
  $(document).ready(function () {
   $('.input-images').imageUploader();
  });

  $(function () {
   $("#feaImg").change(function (event) {
    var x = URL.createObjectURL(event.target.files[0]);
    $("#feaImgPreview").attr("src", x);
    console.log(event);
   });
  })
 </script>
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
