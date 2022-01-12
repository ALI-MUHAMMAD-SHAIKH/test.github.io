<?php
/* Template Name: Seller Product Catalog */
session_start();
ob_start();
// Check if user is logged in.if ( current_user_can( 'edit_posts' ) && (is_user_logged_in) ) {
if ( is_user_logged_in() && current_user_can( 'seller' ) || current_user_can('administrator')) {
 // Get the user ID.
 $user_id = get_current_user_id();
 // Get the user object.
 $user_meta = get_userdata($user_id);
//  pr($user_roles);
// Get all the user roles as an array.
$user_roles = $user_meta->roles;
// pr($user_roles);
 if (isset($_POST['del'])) {
  $delid = $_POST['del'];

  if ($delid) {
   wp_delete_post($delid);
   $_SESSION['status'] = "Successfully Deleted";
   // echo '<meta http-equiv="refresh" content="0;url=http://localhost/xpreskart/catalogue/" />';
   // header('Location:http://localhost/xpreskart/catalogue/');
  } else {
   $_SESSION['status'] = "Product is not Deleted";
   // echo '<meta http-equiv="refresh" content="0;url=http://localhost/xpreskart/catalogue/" />';
  }
 }
 get_template_part('sellerDashboard/seller-header');
 ?>
 <body class="d-flex flex-column h-100">
  <?php get_template_part('sellerDashboard/seller-nav'); ?><!-- Topbar -->
  <div class="container-fluid"><!-- container-fluid -->
   <center><h2>Manage <b>Catalogue</b></h2></center>
   <?php if (isset($_SESSION['status']) && $_SESSION['status'] != '') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
     <strong><?= $_SESSION['status']; ?></strong>
     <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">&times;</button>
    </div>
    <?php
    unset($_SESSION['status']);
   }
   ?>
   <center><a class="btn btn-outline-primary btn-add-block ripple-surface" href="http://localhost/xpreskart/add/">Add Product</a></center>
   <div class="table-responsive"><?php ##Table##  ?>
    <table class="table table-sm table-striped text-center table-hover table-bordered border-primary">
     <thead>
      <tr>
       <th scope="col">Image</th>
       <th scope="col">ID</th>
       <th scope="col">Name</th>
       <th scope="col">Stock</th>
       <th scope="col">Online/In-Store</th>
       <th scope="col">Date</th>
       <th scope="col">Price</th>
       <th colspan="2">Actions</th>
      </tr>
     </thead>
       <tfoot>
        <tr>
      <th scope="col">Image</th>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Stock</th>
      <th scope="col">Online/In-Store</th>
      <th scope="col">Date</th>
      <th scope="col">Price</th>
      <th colspan="2">Actions</th>
        </tr>
       </tfoot>
     <tbody>
<?php
// global $wp_query;
// pr($wp_query);
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
      $args = array(
        'author' => $user_id,
        'post_type' => 'xpr_product',
        'post_status' => 'publish',
        'order' => 'DESC',
        'posts_per_page' => 10,
        'paged' => $paged,
      );
      $seller_products = new WP_Query( $args );
      // prd($seller_products->posts);
      $products = $seller_products->posts;
      foreach($products as $product){
        $product_id = $product->ID;
        $product_thumbnail_url = get_the_post_thumbnail_url($product_id, 'thumbnail');
        // pr($product);
              ?>
      <tr>
       <td>
        <img src="<?php echo esc_url($product_thumbnail_url); ?>" class="catalogimg-thumb">
       </td>
       <td><?= $product_id; ?></td>
       <td><?= $product->post_title; ?></td>
       <td><?php
        if (isset($product->stock_status) && $product->stock_status == "instock") {
            echo "Instock";
        } else {
            echo "Out of Stock";
        } ?></td>
       <?php $sellonoff = get_post_meta($product_id, 'xpr_sell_on_off', true);
              if (isset($sellonoff) && $sellonoff == "Sell Online") { ?>
       <td>Sell Online</td>
       <?php } elseif (isset($sellonoff) && $sellonoff == "Sell Offline") { ?>
            <td>Sell Instore</td>
            <?php } else { ?>
                  <td></td>
                  <?php } ?>
       <td><?= $product->post_date; ?></td>
       <td><?= $product->price; ?></td>
       <td>
        <form method="POST">
         <?php
         //$eId = $product_id;
        //$eId = urlencode(base64_encode($eId)); ?>
         <a type="submit" id="edit_btn" href="<?= $product->post_title; ?>"><img src="<?= get_stylesheet_directory_uri() . '/sellerDashboard/img/pencil-square.svg'; ?>">
         </a>
        </form>
       </td>
       <td>
        <a type="button" id="del_btn" data-delid="<?= $product_id; ?>"><img src="<?= get_stylesheet_directory_uri() . '/sellerDashboard/img/trash-fill.svg'; ?>"></a>
       </td>
      </tr>
     <?php
          } wp_reset_postdata();##### End of Main Loop Author posts #####      ?>
     </tbody>
    </table>
    <div class="clearfix">
     <!-- <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div> -->
     <ul class="pagination">
     <?php 
    //  echo paginate_links( 
    //    array('total' => $seller_products->max_num_pages ) ); 
    $big = 999999999; // need an unlikely integer
 echo paginate_links( array(
    'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
    'format' => '?paged=%#%',
    'current' => max( 1, get_query_var('paged') ),
    'total' => $seller_products->max_num_pages,
    'prev_text'    => __('<li class="btn btn-outline-primary">« prev</li>'),
    'next_text'    => __('<li class="btn btn-outline-primary">next »</li>'),
) );
     ?>
      <!-- <li class="page-item disabled"><a href="#">Previous</a></li> -->
      <!-- <li class="page-item"><a href="?page=1" class="page-link">1</a></li>
      <li class="page-item"><a href="page=2" class="page-link">2</a></li>
      <li class="page-item active"><a href="#" class="page-link">3</a></li>
      <li class="page-item"><a href="#" class="page-link">4</a></li>
      <li class="page-item"><a href="#" class="page-link">5</a></li>
      <li class="page-item"><a href="#" class="page-link">Next</a></li> -->
     </ul>
    </div>
   </div><!-- End of Table -->
   <!-- Delete Product -->
   <div class="modal fade" id="delProduct" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="delProduct" aria-hidden="true">
    <div class="modal-dialog">
     <div class="modal-content">
      <div class="modal-header">
       <h4 class="modal-title" id="delProduct">Delete Product</h4>
       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <p class="text-danger text-center">Are you sure you want to DELETE this Product ?</p>
      </div>
      <div class="modal-footer">
       <form  method="POST">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="submit" name="del" id="delid" class="btn btn-outline-danger">Yes</button>
       </form>
      </div>
     </div>
    </div>
   </div><!-- Delete Product End -->
  </div><!-- End of container-fluid -->
  <?php get_template_part('sellerDashboard/seller-footer'); ?>
 </body>
 </html>
 <script type="text/javascript">
  $(document).ready(function () {
   // Activate tooltip
   $('[data-toggle="tooltip"]').tooltip();

   // Select/Deselect checkboxes
   var checkbox = $('table tbody input[type="checkbox"]');
   $("#selectAll").click(function () {
    if (this.checked) {
     checkbox.each(function () {
      this.checked = true;
     });
    } else {
     checkbox.each(function () {
      this.checked = false;
     });
    }
   });
   checkbox.click(function () {
    if (!this.checked) {
     $("#selectAll").prop("checked", false);
    }
   });


   $(document).on("click", "#del_btn", function () {
    var delId = $(this).data('delid');
    console.log(delId);
    $("#delid").val(delId);
    $('#delProduct').modal('show');
   });
   $(document).on("click", "#edit_btn", function () {
    var editId = $(this).data('editid');
    console.log(editId);
    $("#editid").val(editId);
    $('#editProduct').modal('show');
   });

  });
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
