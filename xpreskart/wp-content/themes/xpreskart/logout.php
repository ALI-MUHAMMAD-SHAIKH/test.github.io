<?php
/**
 * Template Name: Logout
 */
wp_logout();
$redirect_url = site_url();
wp_safe_redirect( $redirect_url );
exit;
?>