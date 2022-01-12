<?php
/* Template Name: Seller Orders */
if ( is_user_logged_in() && current_user_can( 'seller' ) || current_user_can('administrator')) {
    // Get the user ID.
    $user_id = get_current_user_id();
    // Get the user object.
    $user_meta = get_userdata($user_id);
    // print_r($user_meta);
    // global $woocommerce, $post;
    global  $wp_post_statuses;
    // pr($wp_post_statuses);
    global $wpdb;
    $limit = 2;
    $offset = 0;
    $cpage = 1;
    if(isset($_GET['/page'])){
        $offset = $_GET['/page'];
        $cpage = $offset;
        $offset--;
        $offset = $offset * $limit;
    }

    $sellerOrders = array(
        'post_type' => 'xpr_seller_orders',
        'posts_per_page' => 10,
        'post_status' => 'publish',
        );
        $orders = get_posts($sellerOrders);
    // foreach($order as $key1 => $orderDetails){
    //     $ds = unserialize($orderDetails->post_content);
    //     $d2 = $ds['orders'];
    //   foreach($d2 as $key2 => $val2){
    //     pr($key2);
    //     $args2 = array(
    //     'author'        =>  $user_id,
    //     'post__in' =>  array($key2),
    //     'post_type' => 'xpr_product',
    //     'posts_per_page' => 10,
    //     'post_status' => 'publish',
    //     );
    //     $prds = get_posts($args2);
    //     pr($prds);
    //   }
    //   }
?>
    
<?php get_template_part('sellerDashboard/seller-header'); ?>
<body class="d-flex flex-column h-100">
<?php get_template_part('sellerDashboard/seller-nav'); ?><!-- Topbar -->
<div class="container-fluid"><!-- container-fluid -->
<center><h2>Manage <b>Orders</b></h2></center>
    <div class="table-responsive">
    <table class="table table-sm table-striped table-hover table-bordered border-primary" id="dataTable">
    <thead>
    <tr>
        <th scope="col">Order ID</th>
        <th scope="col">Order Date</th>
        <th scope="col">Product Image</th>
        <th scope="col">Product ID</th>
        <th scope="col">Product Name</th>
        <th scope="col">Sale Price</th>
        <th scope="col">QTY</th>
        <th scope="col">Status</th>
        <th scope="col">Deliver</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th scope="col">Order ID</th>
        <th scope="col">Order Date</th>
        <th scope="col">Product Image</th>
        <th scope="col">Product ID</th>
        <th scope="col">Product Name</th>
        <th scope="col">Sale Price</th>
        <th scope="col">QTY</th>
        <th scope="col">Status</th>
        <th scope="col">Deliver</th>
    </tr>
    </tfoot>
    <tbody>
    <?php 
    $sellerOrders = array(
        'post_type' => 'xpr_seller_orders',
        'posts_per_page' => 10,
        'post_status' => 'publish',
        );
        $orders = get_posts($sellerOrders);
        // pr($orders);
    foreach($orders as $key1 => $orderDetails){
        // pr($orderDetails);
        $post_content = unserialize($orderDetails->post_content);
        $pids = $post_content['orderDetails'];
        // pr($pids[$key2]['price']);
    foreach($pids as $key2 => $val2){
        // pr($key2);
        $products = array(
        'author'        =>  $user_id,
        'post__in' =>  array($key2),
        'post_type' => 'xpr_product',
        // 'posts_per_page' => 10,
        'post_status' => 'publish',
        );
        $product = get_posts($products);
        // pr($product);
        // pr($d2[$key2]['price']);
        $product_thumbnail_url = get_the_post_thumbnail_url($key2, 'thumbnail');
        if(!empty($product[0]->post_title)){
            $order_status = get_post_meta( $orderDetails->ID, $product[0]->ID, true );
            // pr($order_status);
    ?>
    <tr>
        <td><?=$orderDetails->ID?></td>
        <td><?=$orderDetails->post_date?></td>
        <td><img src="<?php echo esc_url($product_thumbnail_url); ?>" class="catalogimg-thumb"></td>
        <td><?=$product[0]->ID?></td>
        <td><?=$product[0]->post_title?></td>
        <td><?=$pids[$key2]['price']?></td>
        <td><?=$pids[$key2]['qty']?></td>
        <td>
        <?php if($order_status == 'pending' || $order_status == NULL){
        echo '<h5><span class="badge bg-danger text-white">Pending</span></h5>';}
        elseif ($order_status == 'delivered') {echo '<span class="badge bg-success text-white">Order Delivered</span>';}
        elseif ($order_status == 'dispatched'){echo '<span class="badge bg-warning text-white">Dispatched</span>';}
        ?>
        </td>
        <td>
        <?php 
        if($order_status == 'dispatched'){
        ?>
        <button class="btn btn-outline-warning disabled">
        <?php if($order_status == 'dispatched'){echo 'Dispatched';}
        ?></button>
        <?php } elseif($order_status == 'delivered'){
        ?>
        <button class="btn btn-outline-success disabled">
        <?php if($order_status == 'dispatched' || $order_status == 'delivered'){echo 'Delivered';}
    //  else {echo 'Order Recieved';}
        ?></button>
        <?php }
        else { ?>
        <?php
        if (isset($_POST['dispatched'])) {
        $pr_id = $_POST['dispatched'];
        $orderDetailsID = $_POST['orderDetailsID'];
    //   $order = new WC_Order($dispatched);
    //   pr($_POST);
            if (!empty($pr_id)) {
                update_post_meta( $orderDetailsID, $pr_id, 'dispatched' );
            }
            echo '<meta http-equiv="refresh" content="0;url=http://localhost/xpreskart/orders/" />';
        }
        ?>
        <form method="POST" action="">
            <input type="hidden" name="orderDetailsID" value="<?=$orderDetails->ID?>">
        <button type="submit" name="dispatched" value="<?=$product[0]->ID?>" class="btn btn-outline-danger">Dispatch</button>
        </form>
        <?php } 
        ?>
        </td>
    </tr>
    <?php
    } } } ?>
    </tbody>
    </table>
    </div>
<?php
$sql1 = $wpdb->prepare(
    "SELECT
`xpr_wc_order_product_lookup`.order_id,
`xpr_wc_order_product_lookup`.product_id,
`xpr_posts`.post_author,
`xpr_wc_order_product_lookup`.date_created
FROM
`xpr_wc_order_product_lookup`,
`xpr_posts`
WHERE
`xpr_wc_order_product_lookup`.product_id = `xpr_posts`.ID AND `xpr_posts`.post_author = $user_id  ",
    '');
$order_query1 = $wpdb->get_results($sql1);
$count = count($order_query1);
$totalPage = ceil($count / $limit);
echo '<div class="clearfix"><ul class="pagination">';
for($i=1; $i<=$totalPage; $i++){
    $active = '';
    if ($cpage==$i) {
        $active = 'active';
    }
    echo '<li class="page-item '.$active.'"><a href="?/page='.$i.'" value="'.$i.'" class="page-link">'.$i.'</a></li>';
}
echo '</ul></div>';
?>
</div>
<!-- /.container-fluid -->

<?php get_template_part('sellerDashboard/seller-footer'); ?>
</body>

</html>
<?php
} else {
$location = "http://localhost/xpreskart/login/";
wp_safe_redirect($location);
exit;
}
