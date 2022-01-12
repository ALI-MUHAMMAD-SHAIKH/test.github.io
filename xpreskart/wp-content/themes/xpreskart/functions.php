<?php

// error_reporting(0);
////////////////////////////////////CATALOG EDIT REWRITE RULE////////////////////////////////////////////////////////
function catalog_edit_rewrite_tag() {
	add_rewrite_tag('%edit%', '([^&]+)');
}
add_action('init', 'catalog_edit_rewrite_tag', 10, 0);
function catalog_edit_rewrite_rules() {
add_rewrite_rule('^catalog/([^/]*)/?','index.php?page_id=11&edit=$matches[1]','top');
}
add_action('init', 'catalog_edit_rewrite_rules', 10, 0);
// page_id=19 [Edit page id in posts table]
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////SINGLE PRODUCT REWRITE RULE////////////////////////////////////////////////////////
function single_product_rewrite_tag() {
	add_rewrite_tag('%spID%', '([^&]+)');
}
add_action('init', 'single_product_rewrite_tag', 10, 0);
function single_product_rewrite_rules() {
add_rewrite_rule('^product/([^/]*)/?','index.php?page_id=21&spID=$matches[1]','top');
}
add_action('init', 'single_product_rewrite_rules', 10, 0);
// page_id=19 [Edit page id in posts table]
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_print_scripts', 'xpr_disable_autosave' );
function xpr_disable_autosave() {
  wp_deregister_script( 'autosave' );
} 

add_action( "init", "xpr_redirect_wp_admin" );
function xpr_redirect_wp_admin(){
  global $pagenow;
  if($pagenow ==  'wp-login.php' && $_GET['action'] != "logout"){
    wp_redirect( home_url()."/login");
    exit();
  }
}

add_action( "wp_logout", "xpr_redirect_login" );
function xpr_redirect_login(){
	wp_redirect( site_url()."/login" );
	exit();
}

add_action( 'admin_init', 'xpr_block_wp_admin' );
function xpr_block_wp_admin() {
	if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		wp_safe_redirect( home_url() );
		exit;
	}
}

add_filter( 'show_admin_bar', 'xpr_hide_admin_bar' );
function xpr_hide_admin_bar( $show ) {
	if ( ! current_user_can( 'administrator' ) ) {
		return false;
	}
	return $show;
}

function pr($arr){
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

function prd($arr){
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
	die();
}
/* ________________Register Product Post Type________________________________________ */
// Register Custom Post Type
function create_xpr_product_cpt() {

	$labels = array(
		'name' => __( 'XPR Products', 'Post Type General Name', 'xpreskart' ),
		'singular_name' => __( 'XPR Product', 'Post Type Singular Name', 'xpreskart' ),
		'menu_name' => __( 'XPR Products', 'xpreskart' ),
		'name_admin_bar' => __( 'XPR Product', 'xpreskart' ),
		'archives' => __( 'XPR Product Archives', 'xpreskart' ),
		'attributes' => __( 'XPR Product Attributes', 'xpreskart' ),
		'parent_item_colon' => __( 'Parent XPR Product:', 'xpreskart' ),
		'all_items' => __( 'All XPR Product', 'xpreskart' ),
		'add_new_item' => __( 'Add New XPR Product', 'xpreskart' ),
		'add_new' => __( 'Add New', 'xpreskart' ),
		'new_item' => __( 'New XPR Product', 'xpreskart' ),
		'edit_item' => __( 'Edit XPR Product', 'xpreskart' ),
		'update_item' => __( 'Update XPR Product', 'xpreskart' ),
		'view_item' => __( 'View XPR Product', 'xpreskart' ),
		'view_items' => __( 'View XPR Product', 'xpreskart' ),
		'search_items' => __( 'Search XPR Product', 'xpreskart' ),
		'not_found' => __( 'Not found', 'xpreskart' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'xpreskart' ),
		'featured_image' => __( 'Featured Image', 'xpreskart' ),
		'set_featured_image' => __( 'Set featured image', 'xpreskart' ),
		'remove_featured_image' => __( 'Remove featured image', 'xpreskart' ),
		'use_featured_image' => __( 'Use as featured image', 'xpreskart' ),
		'insert_into_item' => __( 'Insert into XPR Product', 'xpreskart' ),
		'uploaded_to_this_item' => __( 'Uploaded to this XPR Product', 'xpreskart' ),
		'items_list' => __( 'XPR Product list', 'xpreskart' ),
		'items_list_navigation' => __( 'XPR Product list navigation', 'xpreskart' ),
		'filter_items_list' => __( 'Filter XPR Product list', 'xpreskart' ),
	);
	$args = array(
		'label' => __( 'XPR Product', 'xpreskart' ),
		'labels' => $labels,
		'description' => __( 'These are different XPR products', 'xpreskart' ),
		'public' => true,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_admin_bar' => true,
		'show_in_rest' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-location',
		'capability_type' => 'post',
// 		'capabilities' => array(
//   'edit_post'          => 'edit_xpr_product', 
//   'read_post'          => 'read_xpr_product', 
//   'delete_post'        => 'delete_xpr_product', 
//   'edit_posts'         => 'edit_xpr_products', 
//   'edit_others_posts'  => 'edit_others_xpr_products', 
//   'publish_posts'      => 'publish_xpr_products',       
//   'read_private_posts' => 'read_private_xpr_products', 
//   'create_posts'       => 'edit_xpr_products', 
// ),
		'map_meta_cap' => true,
		'supports' => array('title', 'editor', 'thumbnail', 'author', 'comments', 'page-attributes', 'custom-fields', ),
		'taxonomies' => array(),
		'has_archive' => true,
		'can_export' => true,
	);
	register_post_type( 'xpr_product', $args );

}
add_action( 'init', 'create_xpr_product_cpt' );

// Register Taxonomy Category
// Taxonomy Key: Category
function create_xpr_product_tax() {

	$labels = array(
		'name'              => _x( 'Categories', 'taxonomy general name', 'xpreskart' ),
		'singular_name'     => _x( 'Category', 'taxonomy singular name', 'xpreskart' ),
		'search_items'      => __( 'Search Categories', 'xpreskart' ),
		'all_items'         => __( 'All Categories', 'xpreskart' ),
		'parent_item'       => __( 'Parent Category', 'xpreskart' ),
		'parent_item_colon' => __( 'Parent Category:', 'xpreskart' ),
		'edit_item'         => __( 'Edit Category', 'xpreskart' ),
		'update_item'       => __( 'Update Category', 'xpreskart' ),
		'add_new_item'      => __( 'Add New Category', 'xpreskart' ),
		'new_item_name'     => __( 'New Category Name', 'xpreskart' ),
		'menu_name'         => __( 'Categories', 'xpreskart' ),
	);
	$args = array(
		'labels' => $labels,
		'description' => __( 'types of Categories', 'xpreskart' ),
		'hierarchical' => true,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_rest' => false,
		'show_tagcloud' => true,
		'show_in_quick_edit' => true,
		'show_admin_column' => true,
	);
	register_taxonomy( 'xpr_category', array('xpr_product' ), $args );

	$labels = array(
		'name'              => _x( 'Tags', 'taxonomy general name', 'xpreskart' ),
		'singular_name'     => _x( 'Tag', 'taxonomy singular name', 'xpreskart' ),
		'search_items'      => __( 'Search Tags', 'xpreskart' ),
		'all_items'         => __( 'All Tags', 'xpreskart' ),
		'parent_item'       => __( 'Parent Tag', 'xpreskart' ),
		'parent_item_colon' => __( 'Parent Tag:', 'xpreskart' ),
		'edit_item'         => __( 'Edit Tag', 'xpreskart' ),
		'update_item'       => __( 'Update Tag', 'xpreskart' ),
		'add_new_item'      => __( 'Add New Tag', 'xpreskart' ),
		'new_item_name'     => __( 'New Tag Name', 'xpreskart' ),
		'menu_name'         => __( 'Tag', 'xpreskart' ),
	);
	$args = array(
		'labels' => $labels,
		'description' => __( 'types of Tags', 'xpreskart' ),
		'hierarchical' => true,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_rest' => false,
		'show_tagcloud' => true,
		'show_in_quick_edit' => true,
		'show_admin_column' => true,
	);
	register_taxonomy( 'xpr_tag', array('xpr_product', ), $args );

	$labels = array(
		'name'              => _x( 'Attributes', 'taxonomy general name', 'xpreskart' ),
		'singular_name'     => _x( 'Attribute', 'taxonomy singular name', 'xpreskart' ),
		'search_items'      => __( 'Search Attributes', 'xpreskart' ),
		'all_items'         => __( 'All Attributes', 'xpreskart' ),
		'parent_item'       => __( 'Parent Attribute', 'xpreskart' ),
		'parent_item_colon' => __( 'Parent Attribute:', 'xpreskart' ),
		'edit_item'         => __( 'Edit Attribute', 'xpreskart' ),
		'update_item'       => __( 'Update Attribute', 'xpreskart' ),
		'add_new_item'      => __( 'Add New Attribute', 'xpreskart' ),
		'new_item_name'     => __( 'New Attribute Name', 'xpreskart' ),
		'menu_name'         => __( 'Attribute', 'xpreskart' ),
	);
	$args = array(
		'labels' => $labels,
		'description' => __( 'Attributes description', 'xpreskart' ),
		'hierarchical' => false,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_rest' => false,
		'show_tagcloud' => true,
		'show_in_quick_edit' => true,
		'show_admin_column' => true,
	);
	register_taxonomy( 'xpr_attribute', array('xpr_product', ), $args );

}
add_action( 'init', 'create_xpr_product_tax' );
/* ________________________________________________Remove slug from custom post type post URLs________________________________ */
/* https://wordpress.stackexchange.com/questions/203951/remove-slug-from-custom-post-type-post-urls
_________________________Nate Allen______________________________________
 First, we will remove the slug from the permalink: */
function xpr_remove_slug( $post_link, $post, $leavename ) {

	if ( 'xpr_product' != $post->post_type || 'publish' != $post->post_status ) {
					return $post_link;
	}

	$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );

	return $post_link;
}
add_filter( 'post_type_link', 'xpr_remove_slug', 10, 3 );
// Just removing the slug isn't enough. Right now, you'll get a 404 page because 
// WordPress only expects posts and pages to behave this way. You'll also need to add the following:
function xpr_parse_request( $query ) {

	if ( ! $query->is_main_query() || 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
					return;
	}

	if ( ! empty( $query->query['name'] ) ) {
					$query->set( 'post_type', array( 'post', 'xpr_product', 'page' ) );
	}
}
add_action( 'pre_get_posts', 'xpr_parse_request' );

// remove_role( 'contributor' );
// remove_role( 'editor' );
// remove_role( 'author' );
// remove_role( 'subscriber' );


// function add_seller_role_permissions() {
// add_role('seller',__( 'Seller' ),

// array(
// 			'read' => true, // True allows that capability, False specifically removes it.
// 			'edit_posts' => true,
// 			'delete_posts' => true,
// 			'edit_published_posts' => true,
// 			'publish_posts' => true,
// 			'edit_files' => true,
// 			'upload_files' => true //last in array needs no comma!
// ));
// 	}
// add_action( 'init', 'add_seller_role_permissions' );

// $seller = get_role( 'seller' );
// $seller->add_cap(
// 	'upload_files',
// 	'edit_posts',
// 	'edit_published_posts',
// 	'publish_posts',
// 	'read',
// 	'level_2',
// 	'level_1',
// 	'level_0',
// 	'delete_posts',
// 	'delete_published_posts'
// );

// function add_customer_role_permissions() {
// add_role('customer',__( 'Customer' ),
// array('read' => true));
// 	}
// add_action( 'init', 'add_customer_role_permissions' );

/* ________________Register Seller Orders Post Type________________________________________ */
// Register Custom Post Type
function create_xpr_seller_orders_cpt() {

	$labels = array(
		'name' => __( 'Seller Orders', 'Post Type General Name', 'xpreskart' ),
		'singular_name' => __( 'Seller Order', 'Post Type Singular Name', 'xpreskart' ),
		'menu_name' => __( 'Seller Orders', 'xpreskart' ),
		'name_admin_bar' => __( 'Seller Order', 'xpreskart' ),
		'archives' => __( 'Seller Order Archives', 'xpreskart' ),
		'attributes' => __( 'Seller Order Attributes', 'xpreskart' ),
		'parent_item_colon' => __( 'Parent Seller Order:', 'xpreskart' ),
		'all_items' => __( 'All Seller Order', 'xpreskart' ),
		'add_new_item' => __( 'Add New Seller Order', 'xpreskart' ),
		'add_new' => __( 'Add New', 'xpreskart' ),
		'new_item' => __( 'New Seller Order', 'xpreskart' ),
		'edit_item' => __( 'Edit Seller Order', 'xpreskart' ),
		'update_item' => __( 'Update Seller Order', 'xpreskart' ),
		'view_item' => __( 'View Seller Order', 'xpreskart' ),
		'view_items' => __( 'View Seller Order', 'xpreskart' ),
		'search_items' => __( 'Search Seller Order', 'xpreskart' ),
		'not_found' => __( 'Not found', 'xpreskart' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'xpreskart' ),
		'featured_image' => __( 'Featured Image', 'xpreskart' ),
		'set_featured_image' => __( 'Set featured image', 'xpreskart' ),
		'remove_featured_image' => __( 'Remove featured image', 'xpreskart' ),
		'use_featured_image' => __( 'Use as featured image', 'xpreskart' ),
		'insert_into_item' => __( 'Insert into Seller Order', 'xpreskart' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Seller Order', 'xpreskart' ),
		'items_list' => __( 'Seller Order list', 'xpreskart' ),
		'items_list_navigation' => __( 'Seller Order list navigation', 'xpreskart' ),
		'filter_items_list' => __( 'Filter Seller Order list', 'xpreskart' ),
	);

	$args = array(
		'label' => __( 'Seller Order', 'xpreskart' ),
		'labels' => $labels,
		'description' => __( 'These are different Seller Orders', 'xpreskart' ),
		'public' => true,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_admin_bar' => true,
		'show_in_rest' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-cart',
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'supports' => array('title', 'editor', 'thumbnail', 'author', 'comments', 'page-attributes', 'custom-fields', ),
		'has_archive' => true,
		'can_export' => true,
	);
	register_post_type( 'xpr_seller_orders', $args );

}
add_action( 'init', 'create_xpr_seller_orders_cpt' );

// /* ________________Register Xpresprints Post Type________________________________________ */
// // Register Custom Post Type
function create_xpr_xpresprints_cpt() {

	$labels = array(
		'name' => __( 'XpresPrints', 'Post Type General Name', 'xpreskart' ),
		'singular_name' => __( 'XpresPrint', 'Post Type Singular Name', 'xpreskart' ),
		'menu_name' => __( 'XpresPrints', 'xpreskart' ),
		'name_admin_bar' => __( 'XpresPrint', 'xpreskart' ),
		'archives' => __( 'XpresPrint Archives', 'xpreskart' ),
		'attributes' => __( 'XpresPrint Attributes', 'xpreskart' ),
		'parent_item_colon' => __( 'Parent XpresPrint:', 'xpreskart' ),
		'all_items' => __( 'All XpresPrint', 'xpreskart' ),
		'add_new_item' => __( 'Add New XpresPrint', 'xpreskart' ),
		'add_new' => __( 'Add New', 'xpreskart' ),
		'new_item' => __( 'New XpresPrint', 'xpreskart' ),
		'edit_item' => __( 'Edit XpresPrint', 'xpreskart' ),
		'update_item' => __( 'Update XpresPrint', 'xpreskart' ),
		'view_item' => __( 'View XpresPrint', 'xpreskart' ),
		'view_items' => __( 'View XpresPrint', 'xpreskart' ),
		'search_items' => __( 'Search XpresPrint', 'xpreskart' ),
		'not_found' => __( 'Not found', 'xpreskart' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'xpreskart' ),
		'featured_image' => __( 'Featured Image', 'xpreskart' ),
		'set_featured_image' => __( 'Set featured image', 'xpreskart' ),
		'remove_featured_image' => __( 'Remove featured image', 'xpreskart' ),
		'use_featured_image' => __( 'Use as featured image', 'xpreskart' ),
		'insert_into_item' => __( 'Insert into XpresPrint', 'xpreskart' ),
		'uploaded_to_this_item' => __( 'Uploaded to this XpresPrint', 'xpreskart' ),
		'items_list' => __( 'XpresPrint list', 'xpreskart' ),
		'items_list_navigation' => __( 'XpresPrint list navigation', 'xpreskart' ),
		'filter_items_list' => __( 'Filter XpresPrint list', 'xpreskart' ),
	);

	$args = array(
		'label' => __( 'XpresPrints', 'xpreskart' ),
		'labels' => $labels,
		'description' => __( 'These are different XpresPrints', 'xpreskart' ),
		'public' => true,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_admin_bar' => true,
		'show_in_rest' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-printer',
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'supports' => array('title', 'editor', 'thumbnail', 'author', 'comments', 'page-attributes', 'custom-fields', ),
		'has_archive' => true,
		'can_export' => true,
	);
	register_post_type( 'xprprints', $args );

}
add_action( 'init', 'create_xpr_xpresprints_cpt', 0 );

// /* ________________Register Xpresprints Orders Post Type________________________________________ */
// // Register Custom Post Type
function create_xpr_xpresprints_orders_cpt() {

	$labels = array(
		'name' => __( 'XpresPrint Order', 'Post Type General Name', 'xpreskart' ),
		'singular_name' => __( 'XpresPrint Order', 'Post Type Singular Name', 'xpreskart' ),
		'menu_name' => __( 'XpresPrint Orders', 'xpreskart' ),
		'name_admin_bar' => __( 'XpresPrint Order', 'xpreskart' ),
		'archives' => __( 'XpresPrint Order Archives', 'xpreskart' ),
		'attributes' => __( 'XpresPrint Order Attributes', 'xpreskart' ),
		'parent_item_colon' => __( 'Parent XpresPrint Order:', 'xpreskart' ),
		'all_items' => __( 'All XpresPrint Order', 'xpreskart' ),
		'add_new_item' => __( 'Add New XpresPrint Order', 'xpreskart' ),
		'add_new' => __( 'Add New', 'xpreskart' ),
		'new_item' => __( 'New XpresPrint Order', 'xpreskart' ),
		'edit_item' => __( 'Edit XpresPrint Order', 'xpreskart' ),
		'update_item' => __( 'Update XpresPrint Order', 'xpreskart' ),
		'view_item' => __( 'View XpresPrint Order', 'xpreskart' ),
		'view_items' => __( 'View XpresPrint Order', 'xpreskart' ),
		'search_items' => __( 'Search XpresPrint Order', 'xpreskart' ),
		'not_found' => __( 'Not found', 'xpreskart' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'xpreskart' ),
		'featured_image' => __( 'Featured Image', 'xpreskart' ),
		'set_featured_image' => __( 'Set featured image', 'xpreskart' ),
		'remove_featured_image' => __( 'Remove featured image', 'xpreskart' ),
		'use_featured_image' => __( 'Use as featured image', 'xpreskart' ),
		'insert_into_item' => __( 'Insert into XpresPrint Order', 'xpreskart' ),
		'uploaded_to_this_item' => __( 'Uploaded to this XpresPrint Order', 'xpreskart' ),
		'items_list' => __( 'XpresPrint Order list', 'xpreskart' ),
		'items_list_navigation' => __( 'XpresPrint Order list navigation', 'xpreskart' ),
		'filter_items_list' => __( 'Filter XpresPrint Order list', 'xpreskart' ),
	);

	$args = array(
		'label' => __( 'XpresPrints Orders', 'xpreskart' ),
		'labels' => $labels,
		'description' => __( 'These are different XpresPrint Orders', 'xpreskart' ),
		'public' => true,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_admin_bar' => true,
		'show_in_rest' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-book-alt',
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'supports' => array('title', 'editor', 'thumbnail', 'author', 'comments', 'page-attributes', 'custom-fields', ),
		'has_archive' => true,
		'can_export' => true,
	);
	register_post_type( 'xpresprints_orders', $args );

}
add_action( 'init', 'create_xpr_xpresprints_orders_cpt');

// add_action( 'after_switch_theme', 'my_rewrite_flush' );
// function my_rewrite_flush() {
// 	create_xpr_product_cpt();
// 	create_xpr_seller_orders_cpt();
// 	create_xpr_xpresprints_cpt();
//     create_xpr_xpresprints_orders_cpt();
//     flush_rewrite_rules();
// }


/////////////////////////////////////////////////////////Razaorpay Integration//////////////////////////////////////////////////////////////

$keyId = 'rzp_test_3cZjkwyXUHodV7';
$keySecret ='6VzKbeypenRlBfIQKNJQUMY7';
$displayCurrency = 'INR';
require( get_stylesheet_directory() .'/razorpay/Razorpay.php');
// echo get_stylesheet_directory() .'/razorpay/Razorpay.php';

// Create the Razorpay Order

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$api = new Api($keyId, $keySecret);
/////////////////////////////////////////////////////////Razaorpay Integration//////////////////////////////////////////////////////////////
function xpr_get_posts() {
    $sellerOrders = array(
	'post_type' => 'xpr_seller_orders',
	'posts_per_page' => 10,
	'post_status' => 'publish',
	);
	$orders = get_post(62);
	// echo $orders->ID;
	$d = $orders->post_content;
	$ser[] = unserialize($d);
	echo json_encode($ser);
	// echo $orders->post_content;
	// echo $orders->post_content;
	// if (isset($_POST['data'])){
	// 	echo  $_POST['data'];
	// 	}
    exit;
}
//================================================WP Admin Ajax==================================
// add_action("wp_ajax_nopriv_load_blog_posts_sidebar", "xpr_get_posts");
// add_action("wp_ajax_xpr_get_products", "xpr_get_posts");
// add_action("wp_ajax_xpr_add_cart", "xpr_add_cart_func");
// add_action("wp_ajax_xpr_del_cart", "xpr_del_cart_func");
// function xpr_add_cart_func() {
// 	$arr =[];
// 	wp_parse_str($_POST['var_add_cart'],$arr);
// 	// pr($arr);
// 		if(isset($arr['qty'])){
// 		$qty = $arr['qty'];
// 		}else{
// 		$qty = 1;
// 		}
// 	$pid = $arr['product_id'];
// 	session_start();
// 	$_SESSION['cart'][$pid] = array('qty' => $qty);
// 	echo $count = count($_SESSION['cart']);
// 	// return $count;
// 	// wp_send_json_success($arr['qty']);
//     exit;

// }
// function xpr_del_cart_func() {
// 	$arr =[];
// 	wp_parse_str($_POST['var_del_cart'],$arr);
// 	pr($arr);
// 	// $remove = $arr['del'];
// 	// foreach($_SESSION['cart'] as $pid => $qty){
// 	  pr($arr);
// 	  foreach($_SESSION['cart'] as $pid => $qty){
// 		//  pr($key);
// 		 if($pid==$remove){
// 			 unset($_SESSION['cart'][$pid]);
// 		 }
// 	   }
// 	   if (empty($_SESSION['cart'])) {
// 		unset($_SESSION['cart']);
// 		// session_destroy();
// 		echo "<script>window.location.href = 'http://localhost/xpreskart/'</script>";
// 	   }
// 	// }
// 	// if (empty($_SESSION['cart'])) {
// 	//  unset($_SESSION['cart']);
// 	//  // session_destroy();
// 	//  echo "<script>window.location.href = 'http://localhost/xpreskart/'</script>";
// 	// }
//     exit;

// }
//================================================WP_REST_Server==================================
add_action( 'rest_api_init', 'xpr_register_rest_route_products');

function xpr_register_rest_route_products(){
	// Register REST route to GET all products
	register_rest_route("xpr/v1","/products",array(
        "methods"=> WP_REST_Server::READABLE,//"GET",
        "callback"=>"xpr_get_products"
    ));
	// // Register REST route to POST products
	// register_rest_route("xpr/v1","/products",array(
    //     "methods"=>WP_REST_Server::CREATABLE,//"POST",
    //     "callback"=>"xpr_post_products"
    // ));
	// Register REST route to add to cart products
	register_rest_route("xpr/v1","/managecart",array(
        "methods"=>WP_REST_Server::CREATABLE,//"POST",
        "callback"=>"xpr_manage_cart",
    ));
	// Register REST route to add to cart products
	// register_rest_route("xpr/v1","/delcart",array(
    //     "methods"=>WP_REST_Server::CREATABLE,//"POST",
    //     "callback"=>"xpr_del_cart",
    // ));
}
// Callback to GET Products
function xpr_get_products(){
	$sellerOrders = array(
		'post_type' => 'xpr_product',
		'posts_per_page' => 10,
		'post_status' => 'publish',
		);
		$orders = get_posts($sellerOrders);
				$data = [];
				$i = 0;
		foreach($orders as $order){
			// pr($order->post_content);
			$data[$i]['id'] = $order->ID;
			$data[$i]['title'] = $order->post_title;
			$data[$i]['excerpt'] = $order->post_excerpt;
			$data[$i]['mrp'] = ((int)$order->mrp);
			$data[$i]['price'] = ((int)$order->price);
			// $ser = unserialize($order->post_content);
			// $data[$i]['orderDetails'] = $ser;
			$data[$i]['fImg'] = get_the_post_thumbnail_url( $order->ID, 'thumbnail' );
			// echo json_encode($ser);
			$i++;
		}
		return $data;
		
}
// // Callback to POST Products
// function xpr_post_products(){
// 	$sellerOrders = array(
// 		'post_type' => 'xpr_seller_orders',
// 		'posts_per_page' => 10,
// 		'post_status' => 'publish',
// 		);
// 		$orders = get_post(62);
// 		// echo $orders->ID;
// 		$d = $orders->post_content;
// 		$ser[] = unserialize($d);
// 		echo json_encode($ser);
// }
// Callback to xpr_manage_cart Products
function xpr_manage_cart(){
	if(isset($_POST['product_id'])){
		$type = $_POST['type'];
		
		$pid = $_POST['product_id'];
		$qty = $_POST['qty'];
		// $delid = $_POST['removeid'];
		if($type == 'add'){
		
		session_start();
		$_SESSION['cart'][$pid] = array('qty' => $qty);
		return count($_SESSION['cart']);
		}
		if($type == 'del'){
			unset($_SESSION['cart'][$pid]);
		}
		
	}
	return rest_ensure_response( $_REQUEST);
}
// function xpr_del_cart(){
// 	// print_r( $_REQUEST);
// 	$delid = $_REQUEST['removeid'];
// 	$_SESSION['cart'][$pid] = array('qty' => $qty);
// 	if($delid){
// 		unset($_SESSION['cart'][$delid]);
// 	}
// 	return rest_ensure_response( $_REQUEST['removeid']);
// }
// update_user_meta(2, 'xpr_s_latitude', 12.52755797255471);
// update_user_meta(2, 'xpr_s_longitude', 76.88628602886546);
// update_user_meta(2, 'xpr_s_city', 'mandya');
// update_user_meta(2, 'xpr_s_area', 'Haripriya Hotel, SH 17,Bangalore Mysore Highway, Mandya, Karnataka 571401');


/**
* Google Maps Platform Geocoding API
**/
  //Formatted address
//   $formattedAddr = str_replace(' ','+','Haripriya Hotel, SH 17,Bangalore Mysore Highway, Mandya, Karnataka 571401');
//   //Send request and receive json data by address
//   $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false&key=AIzaSyA5g3FtUX69ZqaytWoA_OR_-fEfU9Dty10'); 
//   $output = json_decode($geocodeFromAddr);
//   //Get latitude and longitute from json data
//   $data['latitude']  = $output->results[0]->geometry->location->lat; 
//   $data['longitude'] = $output->results[0]->geometry->location->lng;
//   //Return latitude and longitude of the given address
// update_user_meta(2, 'xpr_s_latitude', $data['latitude']);
// update_user_meta(2, 'xpr_s_longitude', $data['longitude']);