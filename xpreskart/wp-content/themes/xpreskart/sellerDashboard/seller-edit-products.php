<?php
/* Template Name: Seller Edit Product */
ob_start();
// Check if user is logged in.
if ( is_user_logged_in() && current_user_can( 'seller' ) || current_user_can('administrator')) {
 // Get the user ID.
$user_id = get_current_user_id();
// Get the user object.
$user_meta = get_userdata($user_id);
//  pr($current_user = wp_get_current_user());
$sLat = get_user_meta( $user_id, 'xpr_s_latitude', true );
$sLon = get_user_meta( $user_id, 'xpr_s_longitude', true );
$sCity = get_user_meta( $user_id, 'xpr_s_city', true );
$sArea = get_user_meta( $user_id, 'xpr_s_area', true );
 ########################################## EDIT PRODUCT #####################################################
global $wp_query;
// echo 'E : ' . $wp_query->query_vars['edit'];
$pId = $wp_query->query_vars['edit'];
// echo '<br />';
// pr($wp_query);
// pr($_SERVER['QUERY_STRING']);
//  $pId = $_GET['e'];
$pTitle = urldecode($pId);
//  if (isset($_GET['e'])) {
global $wpdb;

$rw = $wpdb->get_row( $wpdb->prepare("select * from `xpr_posts` where post_title='{$pTitle}'",''));
// pr($rw);
$eId = $rw->ID;
$product_thumbnail_url = get_the_post_thumbnail_url($eId, 'thumbnail');
$product = get_post($eId);
$attachment_ids = $product->product_image_gallery;
//  pr(wp_get_attachment_image_src( $attachment_ids, 'thumbnail' )[0]);
// foreach ($attachment_ids as $attachment_id) {
//Get URL of Gallery Images - default wordpress image sizes
//   echo $Original_image_url = wp_get_attachment_url( $attachment_id );
//   echo $full_url = wp_get_attachment_image_src( $attachment_id, 'full' )[0];
//   echo $medium_url = wp_get_attachment_image_src( $attachment_id, 'medium' )[0];
//   echo $thumbnail_url = wp_get_attachment_image_src( $attachment_id, 'thumbnail' )[0];

########################################## UPDATE PRODUCT #####################################################


 function xpr_update_product($eId, $post_author, $pName, $pDescription, $pShortDescription, $pMrp, $pPrice, $pSku, $pStockStatus, $pSellOnOff, $pWeight, $pLenght, $pWidth, $pHeight, $pCat, $sLat, $sLon, $sCity, $sArea) {
  $args = array(
      'ID' => $eId,
      'post_author' => $post_author,
      'post_title' => $pName,
      'post_content' => $pDescription,
      'post_excerpt' => $pShortDescription,
      'post_status' => 'publish',
      'post_type' => 'xpr_product',
  );
   wp_update_post($args);
// WordPress environment
  require_once ABSPATH . 'wp-load.php';
  $current_user = wp_get_current_user();
  $upload_dir = wp_upload_dir();
// $upload_dir['path'] is the full server path to wp-content/uploads/2017/05, for multisite works good as well
  // $upload_dir['url'] the absolute URL to the same folder, actually we do not need it, just to show the link to file
  $i = 1; // number of tries when the file with the same name is already exists
  if (isset($current_user->user_login) && !empty($upload_dir['basedir'])) {
   $user_dirname = $upload_dir['basedir'] . '/' . $current_user->user_login;
   // print_r($user_dirname);
   if (!file_exists($user_dirname)) {
    wp_mkdir_p($user_dirname);
   }
  }
  ########################################## FEATURE IMAGE #####################################################
  // pr($_FILES['feaimg']);
  // if (empty($feaImg = $_FILES['feaimg'])) {
  //     // $feaImg = $old_thumbnail_name;
  // }
  $feaImg = $_FILES['feaimg'];
  $new_file_path1 = $user_dirname . '/' .$feaImg['name'];
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
       'post_parent' => $eId,
           ), $new_file_path1);

   // wp_generate_attachment_metadata() won't work if you do not include this file
   require_once ABSPATH . 'wp-admin/includes/image.php';

   // Generate and save the attachment metas into the database
   wp_update_attachment_metadata($upload_id1, wp_generate_attachment_metadata($upload_id1, $new_file_path1));

   set_post_thumbnail($eId, $upload_id1);
   // Show the uploaded file in browser
   // wp_redirect($wordpress_upload_dir['url'] . '/' . basename($new_file_path));
  }
################################################ GALLERY IMAGES ##############################################################################
  $galImg = $_FILES['galimg'];
  $oldgalIds = get_post_meta($eId, 'product_image_gallery', true);
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
        'post_parent' => $eId,
            ), $new_file_path);
    // $galIds .= $gal . ",";
    $galIds[] = $gal;
    if(empty($gal)){
      $gal = $oldgalIds;
    }
    // wp_generate_attachment_metadata() won't work if you do not include this file
    require_once ABSPATH . 'wp-admin/includes/image.php';
    // Generate and save the attachment metas into the database
    wp_update_attachment_metadata($gal, wp_generate_attachment_metadata($gal, $new_file_path));
   }
  }
##################################################################################################################################
update_post_meta($eId, 'xpr_p_latitude', $sLat);
update_post_meta($eId, 'xpr_p_longitude', $sLon);
update_post_meta($eId, 'xpr_p_city', $sCity);
update_post_meta($eId, 'xpr_p_area', $sArea);
update_post_meta($eId, 'stock_status', $pStockStatus);
update_post_meta($eId, 'xpr_sell_on_off', $pSellOnOff);
update_post_meta($eId, 'weight', $pWeight);
update_post_meta($eId, 'length', $pLenght);
update_post_meta($eId, 'width', $pWidth);
update_post_meta($eId, 'height', $pHeight);
update_post_meta($eId, 'sku', $pSku);
update_post_meta($eId, 'mrp', $pMrp);
update_post_meta($eId, 'price', $pPrice);
  if(empty($galIds)){update_post_meta($eId, 'product_image_gallery', $oldgalIds);
  }else if(isset($galIds)){update_post_meta($eId, 'product_image_gallery', $galIds);}
  
 }

 if (isset($_POST['xpr_update'])) {
  $post_author = $_POST[$user_id];
  // pr($_POST);die();
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
   wp_set_post_terms( $eId, $pCat, 'xpr_category' );// postid, termid, taxonomy
  if (empty($pName) || empty($pDescription) || empty($pShortDescription) || empty($pMrp) || empty($pPrice)) { /* EMPTY START */
   echo "<script>alert('EMPTY');</script>";
  } /* EMPTY END */ else { /* ELSE RUN LOGIC */
    xpr_update_product($eId, $post_author, $pName, $pDescription, $pShortDescription, $pMrp, $pPrice, $pSku, $pStockStatus, $pSellOnOff, $pWeight, $pLenght, $pWidth, $pHeight, $pCat, $sLat, $sLon, $sCity, $sArea);
  //  echo "<script>alert($eId .'Product Saved');</script>";
   $location = "http://localhost/xpreskart/catalog/";
   wp_safe_redirect($location);
   exit;
  //  echo '<meta http-equiv="refresh" content="0;url=http://localhost/xpreskart/catalog/" />';
  } /* ELSE END LOGIC */
 } /* ISSET END */
########################################## END UPDATE PRODUCT #####################################################

 get_template_part('sellerDashboard/seller-header');
 ?>
 <body class="d-flex flex-column h-100">
  <?php get_template_part('sellerDashboard/seller-nav'); ?><!-- Topbar -->
  <div class="container-fluid"><!-- container-fluid -->
   <div class="row justify-content-center"><!-- row start-->
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5 col-xl-4 "><!-- col start-->
     <!--Edit Product -->
     <?php echo "<center>User ID of this Seller is <h2 style=color:red;>{$user_id}</h2></center>";?>
     <form action = "" method = "post" enctype = "multipart/form-data" class="">
      <!-- <input type="hidden" name="_nonce" value="<?php //echo wp_create_nonce('edit_product'); ?>"> -->
      <div class="text-center mb-3">
       <span class="text-center" id="xprName">Name</span>
       <input type="text" name = "xpr_name" id = "xprName" value="<?= $product->post_title ?>" class="form-control" placeholder="Product Name" aria-label="Product Name/Title" aria-describedby="xprName">
      </div>
      <div class="text-center mb-3">
       <span class="text-center">Description</span>
       <textarea class="form-control" name = "xpr_description" id = "xprDescription" aria-label="Description"><?= $product->post_content ?></textarea>
      </div>
      <div class="text-center mb-3">
       <span class="text-center" id="xprShortDescription">Short Description</span>
       <input type="text" name = "xpr_short_description" id = "xprShortDescription" value="<?= $product->post_excerpt ?>" class="form-control" placeholder="Short Description" aria-label="Short Description" aria-describedby="xprShortDescription">
      </div>
      <div class="text-center mb-3">
       <label class="text-center" for="feaImg">Feature Image</label>
       <input type="file" name="feaimg" id="feaImg" onclick="myFunction()" class="form-control" >
       <div class = "col-2 mt-2 mb-3">
        <img src="" id="feaImgPreview" alt="" class="img-fluid dashimg-thumbnail">
       </div>
      </div>
      <div class = "col-2 mt-2 mb-3">
       <img src="<?php echo esc_url($product_thumbnail_url); ?>" class="img-fluid">
      </div>
      <div class="text-center mb-3">
       <label class="text-center" for="galImg">Product Gallery</label>
      </div>         
      <div class="input-images"></div>
      <?php foreach ($attachment_ids as $attachment_id) { //pr($attachment_ids);?>
       <div class = "col-2 d-inline-flex mt-2">
        <img src="<?php echo esc_url(wp_get_attachment_image_src( $attachment_id, 'thumbnail' )[0]); ?>" class="img-fluid">
       </div><?php } ?>
       <div class="text-center mb-3 mt-3">
         <?php 
         $term = wp_get_object_terms( $eId,  'xpr_category' );?>
      <select class="form-select" name="p_cat_id" aria-label='Default select example'>
      <option selected value=<?=$term[0]->term_id?>><?php echo $term[0]->name;?></option>
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
      foreach($product_cat as $cat) {
            echo "<option value={$cat->term_id}>{$cat->name}</option>";}?>
            </select>
            </div>
      <div class="form-check">
       <input type="radio" id="xprInstock" name="xpr_stock_status" 
       <?php if (isset($product->stock_status) && $product->stock_status == "instock") echo "checked"; ?> 
              value="instock" autocomplete="off" class="form-check-input btn-check">
       <label class="btn btn-outline-primary mt-2 mb-2" for="xprInstock">In Stock</label>
       <input type="radio" id="xprOutofStock" name="xpr_stock_status" 
       <?php if (isset($product->stock_status) && $product->stock_status == "outofstock") echo "checked"; ?> 
              value="outofstock" autocomplete="off" class="form-check-input btn-check">
       <label class="btn btn-outline-primary mt-2 mb-2" for="xprOutofStock">Out of Stock</label>
      </div><?php $sellonoff = get_post_meta($eId, 'xpr_sell_on_off', true); ?>
      <div class="form-check">
       <input type="radio" id="sellOnline" name="xpr_sell_on_off" 
       <?php if (isset($sellonoff) && $sellonoff == "Sell Online") echo "checked"; ?> 
              value="Sell Online" autocomplete="off" class="form-check-input btn-check">
       <label class="btn btn-outline-primary mt-2 mb-2" for="sellOnline">Sell Online</label>
       <input type="radio" id="sellOffline" name="xpr_sell_on_off" 
       <?php if (isset($sellonoff) && $sellonoff == "Sell Offline") echo "checked"; ?> 
              value="Sell Offline" autocomplete="off" class="form-check-input btn-check">
       <label class="btn btn-outline-primary mt-2 mb-2" for="sellOffline">Sell Instore</label>
      </div>
      <div class="text-center mb-3">
       <span class="text-center" id="xprWeight">kg</span>
       <input type="text" name = "xpr_weight" id = "xprWeight" value="<?= $product->weight ?>" class="form-control" placeholder="Weight in kilograms" aria-label="Weight in kilograms" aria-describedby="xprWeight">
      </div>
      <div class="text-center mb-3">
       <span class="text-center" id="xprLenght">cm</span>
       <input type="text" name = "xpr_lenght" id = "xprLenght" value="<?= $product->length ?>" class="form-control" placeholder="Lenght in centimetres" aria-label="Lenght in centimetres" aria-describedby="xprLenght">
      </div>
      <div class="text-center mb-3">
       <span class="text-center" id="xprWidth">cm</span>
       <input type="text" name = "xpr_width" id = "xprWidth" value="<?= $product->width ?>" class="form-control" placeholder="Width in centimetres" aria-label="Width in centimetres" aria-describedby="xprWidth">
      </div>
      <div class="text-center mb-3">
       <span class="text-center" id="xprHeight">cm</span>
       <input type="text" name = "xpr_height" id = "xprHeight" value="<?= $product->height ?>" class="form-control" placeholder="Height in centimetres" aria-label="Height in centimetres" aria-describedby="xprHeight">
      </div>
      <div class="text-center mb-3">
       <span class="text-center" id="xprSku">SKU</span>
       <input type="text" name = "xpr_sku" id = "xprSku" value="<?= $product->sku ?>" class="form-control" placeholder="SKU" aria-label="SKU" aria-describedby="xprSku">
      </div>
      <div class="text-center mb-3">
       <span class="text-center">MRP</span>
       <span class="text-center">&#8377</span>
       <input type="text" name="xpr_mrp" id="xprMrp" value="<?= $product->mrp ?>" class="form-control" placeholder="MRP">
      </div>
      <div class="text-center mb-3">
       <span class="text-center">Price</span>
       <span class="text-center">&#8377</span>
       <input type="text" name="xpr_price" id="xprPrice" value="<?= $product->price ?>" class="form-control" placeholder="Price">
      </div>
      <button type="submit" name="xpr_update" id="xprUpdate" value="Update" class="btn btn-outline-primary btn-block ripple-surface mb-5">Save</button>
     </form><!-- Edit Product End -->
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
// echo get_template_directory();
// echo get_stylesheet_directory();
// echo get_stylesheet_directory_uri();
// echo  get_stylesheet_directory_uri() .'/dashboard/tables.php';
// // print_r($user_meta);
// // print_r($current_user);
// echo '</pre>';
// die;
?>