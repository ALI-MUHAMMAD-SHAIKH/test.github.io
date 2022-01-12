<?php /* Template Name: Seller Dashboard */
// Check if user is logged in.
if ( is_user_logged_in() && current_user_can( 'seller' ) || current_user_can('administrator')) {
// Get the user ID.
$user_id = get_current_user_id();
// Get the user object.
$user_meta = get_userdata($user_id);
// print_r($user_meta);

get_template_part('sellerDashboard/seller-header');
?>
<body class="d-flex flex-column h-100">
<?php get_template_part('sellerDashboard/seller-nav'); ?>
<div class="container-fluid body-section"><!-- container-fluid -->
<?php
// echo $lat1 = get_user_meta( $user_id, 'xpr_s_latitude', true ).'<br>';
// echo $lon1 = get_user_meta( $user_id, 'xpr_s_longitude', true ).'<br>';
// echo $lat2 = get_user_meta( 3, 'xpr_c_latitude', true ).'<br>';
// echo $lon2 = get_user_meta( 3, 'xpr_c_longitude', true ).'<br>'.'<br>';

// function haversine($lat1, $lon1, $lat2, $lon2){ 
// // distance between latitudes 
// // and longitudes 
// $user_id = get_current_user_id();
// $lat1 = get_user_meta( $user_id, 'xpr_s_latitude', true );
// $lon1 = get_user_meta( $user_id, 'xpr_s_longitude', true );
// $lat2 = get_user_meta( 3, 'xpr_c_latitude', true );
// $lon2 = get_user_meta( 3, 'xpr_c_longitude', true );

// $dLat = ($lat2 - $lat1) * M_PI / 180.0; 
// $dLon = ($lon2 - $lon1) * M_PI / 180.0; 

// // convert to radians 
// $lat1 = ($lat1) * M_PI / 180.0; 
// $lat2 = ($lat2) * M_PI / 180.0; 

// // apply formulae 
// $a = pow(sin($dLat / 2), 2) + pow(sin($dLon / 2), 2) * cos($lat1) * cos($lat2); 
// $rad = 6371; 
// $c = 2 * asin(sqrt($a)); 
// return $rad * $c; 
// }
// echo haversine($lat1, $lon1, $lat2, $lon2) . " K.M.".'<br>'.'<br>'; 

// $user_id = get_current_user_id();
// $lat1 = get_user_meta( $user_id, 'xpr_s_latitude', true );
// $lon1 = get_user_meta( $user_id, 'xpr_s_longitude', true );
// $lat2 = get_user_meta( 3, 'xpr_c_latitude', true );
// $lon2 = get_user_meta( 3, 'xpr_c_longitude', true );
    
//     // Calculate distance between latitude and longitude
//     $theta    = $lon1 - $lon2;
//     $dist    = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
//     $dist    = acos($dist);
//     $dist    = rad2deg($dist);
//     $miles    = $dist * 60 * 1.1515;
//     echo round($miles * 1.609344, 2).' km';
//     // Convert unit and return distance
//     $unit = strtoupper($unit);
//     if($unit == "K"){
//         echo round($miles * 1.609344, 2).' km';
//     }elseif($unit == "M"){
//         echo round($miles * 1609.344, 2).' meters';
//     }else{
//         echo round($miles, 2).' miles';
//     }

?>
</div><!-- End of container-fluid -->
<?php get_template_part('sellerDashboard/seller-footer'); ?>
</body>
</html>
<?php
} 
else if(current_user_can( 'read' )){
$location = "http://localhost/xpreskart/";
wp_safe_redirect($location);
exit;
}
else {
$location = "http://localhost/xpreskart/login/";
wp_safe_redirect($location);
exit;
}
?>
