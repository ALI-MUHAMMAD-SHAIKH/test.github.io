<?php

echo "<center><h2><b>Bismillahirrahmannnirraheeem</b></h2></center>";
echo "<center><h2>INDEX1.PHP</h2></center>";
// $con = mysqli_connect("localhost", "root", "", "xprdb");
// // pr($con);
// $sql = "select * from xpr_posts";
// // pr($sql);
// $res = mysqli_query($con,$sql);
// // pr($res);
// // $row = mysqli_fetch_assoc($res);
// // pr($row);
// while($row = mysqli_fetch_assoc($res)){
//     // echo $row['order_id'].'<br>';
//     $output[] = $row;
// }





// $sellerOrders = array(
// 	'post_type' => 'xpr_seller_orders',
// 	'posts_per_page' => 10,
// 	'post_status' => 'publish',
// 	);
	// $orders = get_posts(62);
	//  $sql = "SELECT * FROM `xpr_posts`;";
	// function xpr_get_posts() {
		// $sellerOrders = array(
		// 'post_type' => 'xpr_seller_orders',
		// 'posts_per_page' => 10,
		// 'post_status' => 'publish',
		// );
		// $orders = get_post(62);
		// // echo $orders->ID;
		// $d = $orders->post_content;
		// $ser[] = unserialize($d);
		echo json_encode($output);
		// echo $orders->post_content;
		// echo $orders->post_content;
		// if (isset($_POST['data'])){
		// 	echo  $_POST['data'];
		// 	}
		// exit;
	// }
