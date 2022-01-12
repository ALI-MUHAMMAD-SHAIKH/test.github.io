<!-- Footer -->
<footer class="text-center footer mt-auto">
 <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
 <?php echo get_bloginfo('description', 'display'); ?>
 <p>Copyright &copy; XPRESKART 2020</p>
</footer>
<!-- End of Footer -->
<script src="<?= get_stylesheet_directory_uri() . '/sellerDashboard/js/jquery-3.5.1.min.js'; ?>" type="text/javascript"></script>
<script src="<?= get_stylesheet_directory_uri() . '/sellerDashboard/js/bootstrap.min.js'; ?>"></script>
<script src="<?= get_stylesheet_directory_uri() . '/sellerDashboard/js/popper.min.js'; ?>"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>-->
<script src="<?= get_stylesheet_directory_uri() . '/sellerDashboard/js/admin.js'; ?>"></script>
<script src="<?= get_stylesheet_directory_uri() . '/sellerDashboard/js/image-uploader.min.js'; ?>"></script>
<script>
 $(document).ready(function () {
  $(function () { // Dark Mode function
   $("#darkFilter").click(function (event) {
    var x = $(this).is(':checked');
    if (x == true) {
     $('body').css("filter", "invert(1)");
    } else {
     $('body').css("filter", "none");
    }
   });
  });// Dark Mode
 });
</script> 