<?php
/* Template Name : Loggin */
if (isset($_POST['login'])) {
    global $wpdb;

    //We shall SQL escape all inputs
    $username = $wpdb->escape($_REQUEST['sellername']);
    $password = $wpdb->escape($_REQUEST['password']);
    $remember = $wpdb->escape($_REQUEST['rememberme']);

    if ($remember) {
        $remember = "true";
    } else {
        $remember = "false";
    }

    $login_data = array();
    $login_data['user_login'] = $username;
    $login_data['user_password'] = $password;
    $login_data['remember'] = $remember;

    $user_verify = wp_signon($login_data, false);
    if (is_wp_error($user_verify)) {
        $msg='Invalid login details';
    } else {
        echo "<script type='text/javascript'>window.location.href='" . home_url() . "/dashboard'</script>";
        exit();
    }
}
if (is_user_logged_in()) {
    echo "<script type='text/javascript'>window.location.href='" . home_url() . "/dashboard'</script>";
    exit();
}
?>
<?php get_template_part('sellerDashboard/seller-header');?>

<body class="bg-gradient-primary">
  <div class="container"><!-- container-fluid -->
   <div class="row justify-content-center my-15"><!-- row start-->
    <div class="col-sm-12 col-md-6 col-lg-5 col-xl-4 col-login"><!-- col start-->
      <center><h1 class="h4 text-primary-900 mt-2 mb-4">Welcome Back!</h1></center>
      <?php if (isset($msg)&&!empty($msg)) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <center>'.$msg.'</center>
      <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">&times;</button>
      </div>';
}?>
    <?php if (!$user_ID) {?>
    <form method="post" class="user">
    <?php wp_nonce_field('SELLER_NONCE', 'seller_check'); ?>

      <div class="form-group">
        <input type="text" name="sellername" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Username">
      </div>
      <div class="form-group">
        <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
      </div>
      <div class="form-group">
        <div class="custom-control custom-checkbox small">
          <input type="checkbox" class="custom-control-input" name="rememberme" id="customCheck">
          <label class="custom-control-label" for="customCheck">Remember Me</label>
        </div>
      </div>
      <button class="btn btn-primary btn-user btn-block" name="login">Login</button>
      </a>
      <hr>
      <a href="" class="btn btn-google btn-user btn-block">
        <i class="fab fa-google fa-fw"></i> Login with Google
      </a>
      <a href="" class="btn btn-facebook btn-user btn-block">
        <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
      </a>
    </form>
  <?php } else {
}?>
    <hr>
    <div class="text-center">
      <a class="small" href="http://localhost/xpreskart/forgot-password/">Forgot Password?</a>
    </div>
    <div class="text-center">
      <a class="small" href="http://localhost/xpreskart/register/">Create an Account!</a>
    </div>
</div>
</div>
</div>

<script src="<?= get_stylesheet_directory_uri() . '/sellerDashboard/js/jquery-3.5.1.min.js'; ?>"></script>
<script src="<?= get_stylesheet_directory_uri() . '/sellerDashboard/js/bootstrap.min.js'; ?>"></script>
<script src="<?= get_stylesheet_directory_uri() . '/sellerDashboard/js/popper.min.js'; ?>"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>-->
<script src="<?= get_stylesheet_directory_uri() . '/sellerDashboard/js/admin.js'; ?>"></script>
</body>
</html>
