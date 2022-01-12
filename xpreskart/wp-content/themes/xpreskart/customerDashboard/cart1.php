<?php
session_start();
/* Template Name: Cart1 */
if ( is_user_logged_in() && current_user_can( 'customer' ) || current_user_can( 'seller' ) || current_user_can('administrator')) {
// pr($_SESSION);
// pr($_SESSION['cart']);
if(isset($_POST['del'])){
    $remove = $_POST['del'];
    foreach($_SESSION['cart'] as $key => $value){
        // pr($key);
        if($value['product_id']==$remove){
            unset($_SESSION['cart'][$key]);
        }
    }
    if (empty($_SESSION['cart'])) {
        unset($_SESSION['cart']);
        // session_destroy();
        echo "<script>window.location.href = 'http://localhost/xpreskart/'</script>";
    }
}
get_template_part('header');
?>
<body class="d-flex flex-column h-100">
<?php get_template_part('/nav'); ?>
<div class="container-fluid"><!-- container-fluid -->
<div class="row justify-content-center"><!-- product row -->
<center><h2><b>Bismillahirrahmannnirraheeem</b></h2></center>
<center><h2>Your <b>Cart</b></h2></center>
<?php

if (isset($_SESSION['cart'])) {
    echo '<div class="table-responsive-md">
    <table class="table text-center table-sm">
    <thead>
    <tr>
    <th scope="col">Image</th>
    <th scope="col">ID</th>
    <th scope="col">Name</th>
    <th scope="col">Qty</th>
    <th scope="col">Price</th>
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
    <th scope="col">Delivery Cost</th>
    <th scope="col">SubTotal</th>
    <th scope="col">Remove</th>
        </tr>
    </tfoot>
    <tbody>';
    $product_id = array_column($_SESSION['cart'], 'product_id');
    // pr($product_id);
    foreach ($product_id as $id){
        $products = get_post($id);
        // pr($products);
        $product_thumbnail_url = get_the_post_thumbnail_url($id, 'thumbnail');
        echo '<tr>
        <td><img src="'.esc_url($product_thumbnail_url).'" class="cartimg-thumb"></td>
        <td>'.$products->ID.'</td>
        <td>'.$products->post_title.'</td>
        <td><input class="cart-qty" type="number" name="qty" value="1"></td>
        <td>'.$products->price.'</td>
        <td>50</td>
        <td>'.(int)$products->price*(1)+(50).'</td>
        <td>
        <form method="POST">
        <input type="hidden" name="product_id" value="'.$products->ID.'">
         <a type="button" id="remove_btn" data-removeid="'.$products->ID.'"><img src="'.get_stylesheet_directory_uri() . '/sellerDashboard/img/trash-fill.svg'.'">
         </a>
        </form>
        </td>
        </tr>';
    }
}else {echo '<center><h3>Your Cart is Empty</h3></center>';}
?>
</tbody>
</table>
</div>
<!-- Remove Product -->
<div class="modal fade" id="removeProduct" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="removeProduct" aria-hidden="true">
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
</div><!-- Remove Product End -->
</div><!-- End of product Row -->
</div><!-- End of container-fluid -->
<?php get_template_part('/footer'); ?>
<script>
$(document).on("click", "#remove_btn", function () {
    var removeid = $(this).data('removeid');
    console.log(removeid);
    $("#removeid").val(removeid);
    $('#removeProduct').modal('show');
});
</script>
</body>
</html>
<?php
} else {
    $location = "http://localhost/xpreskart/login/";
    wp_safe_redirect($location);
    exit;
}