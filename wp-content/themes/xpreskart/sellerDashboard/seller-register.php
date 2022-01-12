<?php
/* Template Name : Seller Register */
global $wpdb;

if ($_POST) {
  // print_r($_POST);
  $sellerName = $wpdb->escape($_POST['sellername']);
  $sellerEmail = $wpdb->escape($_POST['selleremail']);
  $password = $wpdb->escape($_POST['password']);
  $confirmPassword = $wpdb->escape($_POST['confirmpassword']);

  $error = array();

  if(strpos( $sellerName, ' ' ) !== FALSE){
    $error['sellerName_space'] = "Username shouldn't contain spaces.";
  }
  if(empty($sellerName)){
    $error['sellerName_empty'] = "Username is empty";
  }
  if (username_exists( $sellerName )) {
    $error['sellerName_exists'] = "Username already exists";
  }
  if (!is_email( $sellerEmail )) {
    $error['sellerEmail_valid'] = "Email is not valid";
  }
  if (email_exists( $sellerEmail )) {
    $error['sellerEmail_exists'] = "Email already exists";
  }
  if (strcmp($password , $confirmPassword)!==0) {
    $error['password'] = "Password didn't matched";
  }
  if(count($error) == 0){
          $user_id = wp_insert_user(
        array(
          'user_login'  =>  $sellerName,
          'user_pass' =>  $password,
          'user_email' => $sellerEmail,
          'role'    =>  'seller'
        )
      );
          wp_redirect( home_url( ). "/dashboard" );

  }else{
    
  }
  
}



get_template_part('sellerDashboard/head');
    
?>


</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 900 mb-4">Create an Account!</h1>
              </div>
              <form method="post" class="user">
                <div class="form-group">
                    <input type="text" class="form-control form-control-user" name="sellername" id="sellerName" placeholder="Your Name">
                </div>
                <div class="alert-danger form-control-user mb-2" role="alert">
                  <small><?= $error['sellerName_exists']; ?></small>
                  <small><?= $error['sellerName_space']; ?></small>
                  <small><?= $error['sellerName_empty']; ?></small>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-user" name="selleremail" id="sellerEmail" placeholder="Email Address">
                </div>
                <div class="alert-danger form-control-user mb-2" role="alert">
                  <small><?= $error['sellerEmail_exists']; ?></small>
                  <small><?= $error['sellerEmail_valid']; ?></small>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" name="password" id="password" placeholder="Password">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" name="confirmpassword" id="confirmPassword" placeholder="Confirm  Password">
                  </div>
                </div>
                <div class="alert-danger form-control-user mb-2" role="alert">
                      <small><?= $error['password']; ?></small>
                </div>
                <button class="btn btn-primary btn-user btn-block" type="submit" name="register" >Create your XpresKart Account</button>
                <hr>
                <a href="index.html" class="btn btn-google btn-user btn-block">
                  <i class="fab fa-google fa-fw"></i> Register with Google
                </a>
                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                  <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                </a>
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="http://localhost/xpreskart/forgot-password/">Forgot Password?</a>
              </div>
              <div class="text-center">
                <a class="small" href="http://localhost/xpreskart/login/">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <?php get_template_part('sellerDashboard/foot');?>

</body>

</html>
