<nav class="navbar navbar-expand bg-nav topbar mb-2 static-top shadow">
  <div class="btn-group">
    <a class="dropdown-toggle ms-3" href="#" role="button" id="dropdownMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <img src="http://localhost/xpreskart/wp-content/themes/xpreskart/css/bs-icons/menu-button-wide-fill.svg">
    </a>

    <ul class="dropdown-menu " aria-labelledby="dropdownMenu">
    <li><a class="dropdown-item" href="http://localhost/xpreskart/">Home</a></li>
    <li><a class="dropdown-item" href="http://localhost/xpreskart/checkout/">Checkout</a></li>
    <li><a class="dropdown-item" href="http://localhost/xpreskart/xpresprints/">XpresPrints</a></li>
    </ul>
  </div>
  <a class="logo mx-auto" href="http://localhost/xpreskart/">
  <img src="http://localhost/xpreskart/xpreskart.png" alt="XpresKart">
  </a>
  <div class="cart">
    <!-- onclick="location.href='http://localhost/xpreskart/checkout'" -->
    <button class="cart-icon btn-sm" data-bs-toggle="offcanvas" data-bs-target="#cart-canvas" aria-controls="cart-canvas" type="button">
    <img src="http://localhost/xpreskart/wp-content/themes/xpreskart/css/bs-icons/cart-fill.svg">
    <b><sup><span class="spinner-grow cart-count spinner-grow-sm">0</span></sup></b>
    </button>
  </div>
  <a class=" me-3" href="http://localhost/xpreskart/your-account/">
  <img src="http://localhost/xpreskart/wp-content/themes/xpreskart/css/bs-icons/person-square.svg">
  </a>
</nav>
<form class="searchRow mb-3" method="post" action="search">
  <div class="col-lg-3 col-md-3 col-sm-12">
    <input class="form-control" name="city" list="cityOptions" id="cityList" placeholder="Select City...">
    <datalist id="cityOptions">
    <option value="Bangalore">
    <option value="Mandya">
    <option value="Delhi">
    <option value="Mumbai">
    </datalist>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-12">
    <input class="form-control" name="area" list="areaOptions" id="areaList" placeholder="Select Area...">
    <datalist id="areaOptions">
    <option value="Bangalore">
    <option value="Guthal Rd, Gautaham Badavane, Mandya, Karnataka 571401">
    <option value="Delhi">
    <option value="Haripriya Hotel">
    </datalist>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-12">
    <input class="form-control" type="text" name="text" placeholder="Search Products" aria-label="search products">
  </div>
  <div class="col-lg-1 col-md-1 col-sm-12">
    <button class="btn btn-outline-primary" type="submit" name="search" id="search">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
  </button>
  </div>
</form>
<?php
// if ( is_user_logged_in() && current_user_can( 'customer' ) || current_user_can( 'seller' ) || current_user_can('administrator')) {
?>
<!-- CART CANVAS -->
<div class="offcanvas offcanvas-top" data-bs-backdrop="true" style="visibility: hidden; color:white;" tabindex="-1" id="cart-canvas" aria-labelledby="cart-canvas">
<div class="offcanvas-header">
<!-- <h5 class="offcanvas-title text-center" id="cart-canvas">CART DETAILS</h5> -->
<button type="button" style="margin: 10px 10px 0 0;" class="btn-close btn-close-white float-end" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<!-- CART DETAILS BODY -->
<div class="offcanvas-body small text-center">
  <table id="cart_table" class="table table-responsive-md table-hover table-cart">
    <thead>
      <tr>
        <th scope="col">Image</th>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Qty</th>
        <th scope="col">Price</th>
        <!-- <th scope="col">Distance</th>
        <th scope="col">Delivery Cost</th> -->
        <th scope="col">SubTotal</th>
      </tr>
      </thead>
      <tfoot>
      <tr>
        <th scope="col">Image</th>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Qty</th>
        <th scope="col">Price</th>
        <!-- <th scope="col">Distance</th>
        <th scope="col">Delivery Cost</th> -->
        <th scope="col">SubTotal</th>
      </tr>
    </tfoot>
    <tbody class="cart-items">
    </tbody>
  </table>
  <!-- CART GRAND TOTAL -->
  <div class="total" style="color: white;font-weight: bold;font-size: medium;">Total (0 items): ₹ 0</div>
  </div>
  <center><a href="http://localhost/xpreskart/checkout/" class="btn btn-outline-primary btn-sm chkt mb-2" style="color: white;">Proceed to Checkout</a></center>
</div>
<?php
// }
?>