<nav class="navbar navbar-expand navbar-light bg-nav topbar mb-2 static-top shadow">

 <!-- UL-1 -->
 <ul class="navbar-nav">
  <!-- Nav Item - Menu -->
  <li class="nav-item dropdown no-arrow mx-1">
   <a class="nav-link dropdown-toggle" href="#" id="menuDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <img src="http://localhost/xpreskart/wp-content/themes/xpreskart/sellerDashboard/css/bs-icons/stack.svg">

    <!-- Counter - Alerts -->
    <span class="badge badge-danger badge-counter"></span>
   </a>
   <!-- Dropdown - Menu -->
   <div class="dropdown-list dropdown-menu dropdown-menu-left shadow animated--grow-in" aria-labelledby="menuDropdown">
    <h6 class="dropdown-header">Menu</h6>
    <a class="dropdown-item d-flex align-items-center" href="http://localhost/xpreskart/dashboard/">
     <div class="mr-3">
      <div class="icon-circle bg-primary">
       <i class="fas fa-file-alt text-white"></i>
      </div>
     </div>
     <div>
      <!--<div class="small text-gray-500">December 12, 2019</div>-->
      <span class="font-weight-bold">Your Dashboard</span>
     </div>
    </a>
    <a class="dropdown-item d-flex align-items-center" href="http://localhost/xpreskart/catalog/">
     <div class="mr-3">

      <div class="icon-circle bg-success">
       <i class="fas fa-donate text-white"></i>
      </div>
     </div>
     <div>
      <!--<div class="small text-gray-500">December 7, 2019</div>-->
      <span class="font-weight-bold">Catalog</span>
     </div>
    </a>
    <a class="dropdown-item d-flex align-items-center" href="http://localhost/xpreskart/orders/">
     <div class="mr-3">
      <div class="icon-circle bg-success">
       <i class="fas fa-donate text-white"></i>
      </div>
     </div>
     <div>
      <!--<div class="small text-gray-500">December 2, 2019</div>-->
      <span class="font-weight-bold">Orders</span>
     </div>
    </a>
    <!--<a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>-->
   </div>
  </li>


  <!-- Nav Item - Search (Visible Only XS) -->
  <li class="nav-item dropdown no-arrow ">
   <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   <img src="http://localhost/xpreskart/wp-content/themes/xpreskart/sellerDashboard/css/bs-icons/search.svg">
   </a>
   <!--    Dropdown - Search -->
   <div class="dropdown-menu dropdown-menu-left p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
    <form class="mr-auto w-100 navbar-search">
     <div class="input-group">
      <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
      <div class="input-group-append">
       <button class="btn btn-primary" type="button">
       <img src="http://localhost/xpreskart/wp-content/themes/xpreskart/sellerDashboard/css/bs-icons/search.svg">
       </button>
      </div>
     </div>
    </form>
   </div>
  </li>
 </ul>

 <!-- Sidebar - Brand -->
 <a class="logo mx-auto" href="http://localhost/xpreskart/">
  <img src="http://localhost/xpreskart/xpreskart.png" alt="">
 </a>

 <!-- UL-2 -->
 <ul class="navbar-nav">
  <!-- Nav Item - Messages -->
  <li class="nav-item dropdown no-arrow mx-1">
   <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   <img src="http://localhost/xpreskart/wp-content/themes/xpreskart/sellerDashboard/css/bs-icons/bell-fill.svg">
    <!-- Counter - Messages -->
    <span class="badge badge-danger badge-counter">7</span>
   </a>
   <!-- Dropdown - Messages -->
   <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
    <h6 class="dropdown-header">
     Orders
    </h6>
    <a class="dropdown-item d-flex align-items-center" href="#">
     <div class="dropdown-list-image mr-3">
      <img class="rounded-circle" src="http://localhost/xpreskart/xpreskart.png" alt="">
      <div class="status-indicator bg-success"></div>
     </div>
     <div class="font-weight-bold">
      <div class="text-truncate">product Name</div>
      <div class="small text-gray-500">Order ID</div>
     </div>
    </a>
    <a class="dropdown-item d-flex align-items-center" href="#">
     <div class="dropdown-list-image mr-3">
      <img class="rounded-circle" src="http://localhost/xpreskart/xpreskart.png" alt="">
      <div class="status-indicator"></div>
     </div>
     <div>
      <div class="text-truncate">product Name</div>
      <div class="small text-gray-500">Order ID</div>
     </div>
    </a>
    <a class="dropdown-item d-flex align-items-center" href="#">
     <div class="dropdown-list-image mr-3">
      <img class="rounded-circle" src="http://localhost/xpreskart/xpreskart.png" alt="">
      <div class="status-indicator bg-warning"></div>
     </div>
     <div>
      <div class="text-truncate">product Name</div>
      <div class="small text-gray-500">Order ID</div>
     </div>
    </a>
    <a class="dropdown-item d-flex align-items-center" href="#">
     <div class="dropdown-list-image mr-3">
      <img class="rounded-circle" src="http://localhost/xpreskart/xpreskart.png" alt="">
      <div class="status-indicator bg-success"></div>
     </div>
     <div>
      <div class="text-truncate">product Name</div>
      <div class="small text-gray-500">Order ID</div>
     </div>
    </a>
    <a class="dropdown-item text-center small text-gray-500" href="http://localhost/xpreskart/orders/">Go to Orders</a>
   </div>
  </li>

  <!--<div class="topbar-divider d-none d-sm-block"></div>-->
  <?php $current_user = wp_get_current_user(); ?>
  <!-- Nav Item - User Information -->
  <li class="nav-item dropdown no-arrow">
   <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="mr-2 d-none d-lg-inline  small"><?php echo $current_user->user_login; ?></span>
    <img class="img-profile rounded-circle" src="http://localhost/xpreskart/xpreskart.png">
   </a>
   <!-- Dropdown - User Information -->
   <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
    <a class="dropdown-item" href="http://localhost/xpreskart/profile/">
     <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
     Profile
    </a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="http://localhost/xpreskart/logout/" data-bs-toggle="modal" data-bs-target="#logoutModal">
     <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
     Logout
    </a>
   </div>
  </li>
 </ul>
 <!--  Sidebar Toggle (Topbar)
   <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
   </button>-->
</nav>


<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
 <div class="modal-dialog" role="document">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title" id="logoutModalLabel">Ready to Leave?</h5>
    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">×</span>
    </button>
   </div>
   <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
   <div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
    <a class="btn btn-primary" href="http://localhost/xpreskart/logout/">Logout</a>
   </div>
  </div>
 </div>
</div>