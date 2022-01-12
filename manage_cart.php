<?php

require_once('wp-load.php');
session_start();
// $sellerOrders = array(
// 	'post_type' => 'xpr_seller_orders',
// 	'posts_per_page' => 10,
// 	'post_status' => 'publish',
// 	);
// 	$orders = get_post(62);
// 	// echo $orders->ID;
// 	$d = $orders->post_content;
// 	$ser[] = unserialize($d);
// 	echo json_encode($ser);
if(isset($_POST['pid'])){
	if($type == 'add'){
	$pid = $_POST['pid'];
	$qty = $_POST['qty'];
	$type = $_POST['type'];
	
	$_SESSION['cart'][$pid] = array('qty' => $qty);
	echo $count = count($_SESSION['cart']);
	}
	}

