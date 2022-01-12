<?php
/**
 * Template Name: XpresPrint
 */
ob_start();
//For creating custom folder for users
$current_user = wp_get_current_user();
$upload_dir = wp_upload_dir();
if (isset($current_user->user_login) && !empty($upload_dir['basedir'])) {
 $user_dirname = $upload_dir['basedir'] . '/' . $current_user->user_login;
 // print_r($user_dirname);
 if (!file_exists($user_dirname)) {
  wp_mkdir_p($user_dirname);
 }
}

// Default title print form
function post_author_title_frontend($post_title, $post) {
 $current_user = wp_get_current_user();
 // $current_user->user_login;
 date_default_timezone_set('Asia/Kolkata');
 return $current_user->user_login . " Ordered on " . date("l, F j, Y  H:i:s A");
}

$price = 0.00;
$a475gsmssidebw = 0.85;
$a475gsmb2bsidebw = 1.00;

$a475gsmssidescolor = 7.00;
$a475gsmb2bsidescolor = 5.00;

$a375gsmssidebw = 2.00;
$a375gsmb2bsidebw = 1.00;

$a375gsmssidescolor = 10.00;
$a375gsmb2bsidescolor = 7.00;

$staple = 3.00;
$spiral = 25.00;
$projectWork = 150;
$phdThesis = 200;

add_action('init', 'xpr_insert_form');

function xpr_insert_form($username, $user_email, $filenames, $paperType, $paperSize, $printColor, $printSide, $numPages, $numCopies, $bindingType, $addInstruction, $price) {
 $post_arr = array(
 'post_title' => post_author_title_frontend($post_title, $post, ),
 'post_content' => $user_email,
 'post_status' => 'publish',
 'post_type' => 'xpr_xpresprints',
 // Meta input
 'meta_input' => array(
 'files' => $filenames,
 'paper_type' => $paperType,
 'paper_size' => $paperSize,
 'print_color' => $printColor,
 'print_side' => $printSide,
 'num_pages' => $numPages,
 'num_copies' => $numCopies,
 'binding_type' => $bindingType,
 'addinstruction' => $addInstruction,
 'price' => $price,
 ),
 );
 $product_ID = wp_insert_post($post_arr);

}

if (isset($_POST['print'])) { /* ISSET START */
  
$files = $_FILES['files']['name'];
$paperType = $_POST['paper_type'];
$paperSize = $_POST['paper_size'];
$printColor = $_POST['print_color'];
$printSide = $_POST['print_side'];
$numPages = $_POST['num_pages'];
$numCopies = $_POST['num_copies'];
$bindingType = $_POST['binding_type'];
$addInstruction = $_POST['addinstruction'];
$price = $_POST['price'];

 if (($files == '') || ($paperType == '') || ($paperSize == '') || ($printColor == '') || ($printSide == '') || ($numPages == '') || ($numCopies == '')) { /* EMPTY START */
  $msg = "Please select required fields";
 } /* EMPTY END */ else { /* ELSE RUN LOGIC */
  $targetDir = $user_dirname . '/';
  $allowedTypes = array('jpg', 'jpeg', 'png', 'pdf');
  if (!empty(array_filter($_FILES['files']['name']))) {
   foreach ($_FILES['files']['name'] as $key => $val) {
    // print_r($_FILES['files']['name']);die;
    $fileName = $_FILES['files']['name'][$key];
    $filenames = $_FILES['files']['name'];
    // print_r($filenames);die;
    // print_r($fileName);die;
    $temploc = $_FILES['files']['tmp_name'][$key];
    $targetpath = $targetDir . $fileName;
    // print_r($targetpath);die;
    $filetype = pathinfo($targetpath, PATHINFO_EXTENSION);
    if (in_array($filetype, $allowedTypes)) {
     $moved = move_uploaded_file($temploc, $targetpath);
     // print_r($moved);die;
    }
   }
  }
  $msg = "Fields selected";

  /*
    |----------------- ---------------------------------------------------------
    | CASE START 75GSM-NORMAL PAPER && A4 && B&W && SS && B2B && BINDING
    |--------------------------------------------------------------------------
   */
  switch ($paperType) {
   case '75GSM-NORMAL PAPER':
    switch ($paperSize) {
     case 'A4':
      /* CASE START B&W */
      switch ($printColor) {
       case 'BLACK & WHITE':
        switch ($printSide) {
         case 'SINGLE SIDE':
          $price = $a475gsmssidebw * $numCopies * $numPages;
          break;
         case 'DOUBLE SIDE (BACK TO BACK)':
          $price = $a475gsmb2bsidebw * $numCopies * $numPages / 2;
          break;
        }
      } /* CASE END B&W */
      /* CASE START SINGLE COLOUR */
      switch ($printColor) {
       case 'SINGLE COLOUR':
        switch ($printSide) {
         case 'SINGLE SIDE':
          $price = $a475gsmssidescolor * $numCopies * $numPages;
          break;
         case 'DOUBLE SIDE (BACK TO BACK)':
          $price = $a475gsmb2bsidescolor * $numCopies * $numPages;
          break;
        }
      } /* CASE END SINGLE COLOUR */
      /* BINDING CASE FOR STAPLE */
      switch ($bindingType) {
       case 'STAPLE':
        switch ($printColor) {
         case 'BLACK & WHITE':
          switch ($printSide) {
           case 'SINGLE SIDE':
            $price = $a475gsmssidebw * $numCopies * $numPages + $numCopies * $staple;
            break;
          }
        }
      }
      switch ($bindingType) {
       case 'STAPLE':
       case 'BLACK & WHITE':
        switch ($printSide) {
         case 'DOUBLE SIDE (BACK TO BACK)':
          $price = $a475gsmb2bsidebw * $numCopies * $numPages / 2 + $numCopies * $staple;
          break;
        }
      }
      /* BINDING CASE FOR SPIRAL */
      switch ($bindingType) {
       case 'SPIRAL':
        switch ($printSide) {
         case 'SINGLE SIDE':
          $price = $a475gsmssidebw * $numCopies * $numPages + $numCopies * $spiral;
          break;
        }
      }
      switch ($bindingType) {
       case 'SPIRAL':
        switch ($printSide) {
         case 'DOUBLE SIDE (BACK TO BACK)':
          $price = $a475gsmb2bsidebw * $numCopies * $numPages / 2 + $numCopies * $spiral;
          break;
        }
      }
      /* BINDING CASE FOR PROJECT WORK */
      switch ($bindingType) {
       case 'PROJECT WORK':
        switch ($printSide) {
         case 'SINGLE SIDE':
          $price = $a475gsmssidebw * $numCopies * $numPages + $numCopies * $projectWork;
          break;
        }
      }
      switch ($bindingType) {
       case 'PROJECT WORK':
        switch ($printSide) {
         case 'DOUBLE SIDE (BACK TO BACK)':
          $price = $a475gsmb2bsidbwe * $numCopies * $numPages + $numCopies * $projectWork;
          break;
        }
      }
      /* BINDING CASE FOR PHD THESIS */
      switch ($bindingType) {
       case 'PHD THESIS':
        switch ($printSide) {
         case 'SINGLE SIDE':
          $price = $a475gsmssidebw * $numCopies * $numPages + $numCopies * $phdThesis;
          break;
        }
      }
      switch ($bindingType) {
       case 'PHD THESIS':
        switch ($printSide) {
         case 'DOUBLE SIDE (BACK TO BACK)':
          $price = $a475gsmb2bsidebw * $numCopies * $numPages + $numCopies * $phdThesis;
          break;
        }
      }
    } /* CASE END A4 */
  } /* CASE END 75GSM-NORMAL PAPER && A4 && B&W && SS && B2B && BINDING */

  /*
    |--------------------------------------------------------------------------
    | CASE START 75GSM-NORMAL PAPER && A3 && B&W && SS && B2B && BINDING
    |--------------------------------------------------------------------------
   */
  switch ($paperType) {
   case '75GSM-NORMAL PAPER':
    switch ($PaperSize) {
     case 'A3':
      /* CASE START B&W */
      switch ($printColor) {
       case 'BLACK & WHITE':
        switch ($printSide) {
         case 'SINGLE SIDE':
          $price = $a375gsmssidebw * $numCopies * $numPages;
          break;
         case 'DOUBLE SIDE (BACK TO BACK)':
          $price = $a375gsmb2bsidebw * $numCopies * $numPages;
          break;
        }
      } /* CASE END B&W */
      /* CASE START SINGLE COLOUR */
      switch ($printColor) {
       case 'SINGLE COLOUR':
        switch ($printSide) {
         case 'SINGLE SIDE':
          $price = $a375gsmssidescolor * $numCopies * $numPages;
          break;
         case 'DOUBLE SIDE (BACK TO BACK)':
          $price = $a375gsmb2bsidescolor * $numCopies * $numPages;
          break;
        }
      } /* CASE END SINGLE COLOUR */
      /* BINDING CASE FOR STAPLE */
      switch ($bindingType) {
       case 'STAPLE':
        switch ($printColor) {
         case 'BLACK & WHITE':
          switch ($printSide) {
           case 'SINGLE SIDE':
            $price = $a375gsmssidebw * $numCopies * $numPages + $numCopies * $staple;
            break;
          }
        }
      }
      switch ($bindingType) {
       case 'STAPLE':
       case 'BLACK & WHITE':
        switch ($printSide) {
         case 'DOUBLE SIDE (BACK TO BACK)':
          $price = $a375gsmb2bsidebw * $numCopies * $numPages + $numCopies * $staple;
          break;
        }
      }
      /* BINDING CASE FOR SPIRAL */
      switch ($bindingType) {
       case 'SPIRAL':
        switch ($printSide) {
         case 'SINGLE SIDE':
          $price = $a375gsmssidebw * $numCopies * $numPages + $numCopies * $spiral;
          break;
        }
      }
      switch ($bindingType) {
       case 'SPIRAL':
        switch ($printSide) {
         case 'DOUBLE SIDE (BACK TO BACK)':
          $price = $a375gsmb2bsidebw * $numCopies * $numPages + $numCopies * $spiral;
          break;
        }
      }
      /* BINDING CASE FOR PROJECT WORK */
      switch ($bindingType) {
       case 'PROJECT WORK':
        switch ($printSide) {
         case 'SINGLE SIDE':
          $price = $a375gsmssidebw * $numCopies * $numPages + $numCopies * $projectWork;
          break;
        }
      }
      switch ($bindingType) {
       case 'PROJECT WORK':
        switch ($printSide) {
         case 'DOUBLE SIDE (BACK TO BACK)':
          $price = $a375gsmb2bsidbwe * $numCopies * $numPages + $numCopies * $projectWork;
          break;
        }
      }
      /* BINDING CASE FOR PHD THESIS */
      switch ($bindingType) {
       case 'PHD THESIS':
        switch ($printSide) {
         case 'SINGLE SIDE':
          $price = $a375gsmssidebw * $numCopies * $numPages + $numCopies * $phdThesis;
          break;
        }
      }
      switch ($bindingType) {
       case 'PHD THESIS':
        switch ($printSide) {
         case 'DOUBLE SIDE (BACK TO BACK)':
          $price = $a375gsmb2bsidebw * $numCopies * $numPages + $numCopies * $phdThesis;
          break;
        }
      }
    } /* CASE END A3 */
  } /* CASE END 75GSM-NORMAL PAPER && A3 && B&W && SS && B2B && BINDING */
  xpr_insert_form($username, $user_email, $filenames, $paperType, $paperSize, $printColor, $printSide, $numPages, $numCopies, $bindingType, $addInstruction, $price);
 } /* ELSE END LOGIC */
} /* ISSET END */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="h-100">

 <head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Xpreskart - Diskover Lokal Shops</title>
  <!-- <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700;800&display=swap" rel="stylesheet"> -->
  <link rel="shortcut icon" href="<?= get_stylesheet_directory_uri() . '/prints/xpreskart-icon.ico'; ?>" type="image/x-icon">
  <link href="<?= get_stylesheet_directory_uri() . '/prints/nunito-sans.css'; ?>" rel="stylesheet" type="text/css" />
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"> -->
  <!-- <link href="<?= get_stylesheet_directory_uri() . '/prints/bootstrap.css'; ?>" rel="stylesheet" type="text/css" /> -->
  <link href="<?= get_stylesheet_directory_uri() . '/prints/xpresPrints.css'; ?>" rel="stylesheet" type="text/css" />
 </head>

 <body class="d-flex flex-column h-100">
 <nav class="navbar navbar-expand navbar-light bg-nav topbar mb-2 static-top shadow">
<div class="btn-group">
  <a class="dropdown-toggle ms-3" href="#" role="button" id="dropdownMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  <img src="http://localhost/xpreskart/wp-content/themes/xpreskart/css/bs-icons/menu-button-wide-fill.svg">
  </a>

  <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="dropdownMenu">
    <li><a class="dropdown-item" href="http://localhost/xpreskart/">Home</a></li>
    <li><a class="dropdown-item" href="http://localhost/xpreskart/cart/">Cart</a></li>
    <li><a class="dropdown-item" href="http://localhost/xpreskart/checkout/">Checkout</a></li>
    <li><a class="dropdown-item" href="http://localhost/xpreskart/xpresprints/">XpresPrints</a></li>
  </ul>
</div>
<a class="logo mx-auto" href="http://localhost/xpreskart/">
  <img src="http://localhost/xpreskart/xpreskart.png" alt="">
</a>
  <a class=" me-3" href="http://localhost/xpreskart/your-account/">
  <img src="http://localhost/xpreskart/wp-content/themes/xpreskart/css/bs-icons/person-square.svg">
</a>
</nav>
  <div class="container-fluid mt-2 mb-5 "><!-- container-fluid start-->
   <div class="row d-flex justify-content-center"><!-- row 1 start-->
    <div class="col-sm-12 col-md-6 col-lg-5 col-xl-4 "><!-- col-lg-6 col-12 start col2-->
      <form action="" class="needs-validation mt-2 mb-2" novalidate method="post" enctype="multipart/form-data">
       <!-- start form-->
       <!-- USER NAME -->
       <div class="form-group">
        <input class="form-control mb-3" type="text" placeholder="<?php echo "Hello,  " . $current_user->user_login; ?>" readonly>
       </div>
       <div class="accordion accordion-flush" id="xpresPrints">
         <!-- Upload File -->
         <div class="accordion-item">
         <h2 class="accordion-header" id="flush-uploadFile">
         <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#uploadFile" aria-expanded="false" aria-controls="uploadFile">
         Upload File
         </button></h2>
         <div id="uploadFile" class="accordion-collapse collapse" aria-labelledby="flush-uploadFile" data-bs-parent="#xpresPrints">
      <div class="accordion-body">
         <div class=" mb-3 custom-file-container" data-upload-id="mySecondImage">
          <label>File Formats [pdf, doc, docx, csv] <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Files">
            &times;</a></label>
          <label class="custom-file-container__custom-file">
           <input type="file" name="files[]" id="files" onchange="javascript:updateList()"
                  class="custom-file-container__custom-file__custom-file-input form-control"
                  accept="*" multiple aria-label="Choose File">
           <span class="custom-file-container__custom-file__custom-file-control"></span>
          </label>
          <div class="custom-file-container__image-preview"></div>
         </div>
         </div>
         </div>
         </div>
         <!-- Paper Type -->
         <div class="accordion-item">
         <h2 class="accordion-header" id="flush-paperType">
         <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#paperType" aria-expanded="false" aria-controls="paperType">
         Paper Type
         </button></h2>
         <div id="paperType" class="accordion-collapse collapse" aria-labelledby="flush-paperType" data-bs-parent="#xpresPrints">
         <div class="accordion-body">
         <div class="form-check">
          <input type="radio" id="75gsm_nor_paper" name="paper_type"
                 value="75GSM-NORMAL PAPER" class="form-check-input btn-check" autocomplete="off"
                 required>
          <label class="btn btn-outline-primary mt-2 mb-2" for="75gsm_nor_paper">75GSM-NORMAL
           PAPER</label>
          <input type="radio" id="100gsm_nor_paper" name="paper_type"
                 value="100GSM-NORMAL PAPER" class="form-check-input btn-check"
                 autocomplete="off" required>
          <label class="btn btn-outline-primary mt-2 mb-2"
                 for="100gsm_nor_paper">100GSM-NORMAL PAPER</label>
         </div>
         </div>
         </div>
         </div>
         <!-- PAPER SIZE -->
         <div class="accordion-item">
         <h2 class="accordion-header" id="flush-paperSize">
         <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#paperSize" aria-expanded="false" aria-controls="paperSize">
         Paper Size
         </button></h2>
         <div id="paperSize" class="accordion-collapse collapse" aria-labelledby="flush-paperSize" data-bs-parent="#xpresPrints">
         <div class="accordion-body">
         <div class="form-check">
          <input type="radio" id="a4" name="paper_size" value="A4"
                 class="form-check-input btn-check" autocomplete="off" required>
          <label class="btn btn-outline-primary mt-2 mb-2" for="a4">A4</label>
          <input type="radio" id="a3" name="paper_size" value="A3"
                 class="form-check-input btn-check" autocomplete="off" required>
          <label class="btn btn-outline-primary mt-2 mb-2" for="a3">A3</label>
         </div>
         </div>
         </div>
         </div>
         <!-- PRINT COLOR -->
         <div class="accordion-item">
         <h2 class="accordion-header" id="flush-printColor">
         <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#printColor" aria-expanded="false" aria-controls="printColor">
         Print Color
         </button></h2>
         <div id="printColor" class="accordion-collapse collapse" aria-labelledby="flush-printColor" data-bs-parent="#xpresPrints">
         <div class="accordion-body">
         <div class="form-check">
          <input type="radio" id="black&white" name="print_color" value="BLACK & WHITE"
                 class="form-check-input btn-check" autocomplete="off" required>
          <label class="btn btn-outline-primary mt-2 mb-2" for="black&white">BLACK &
           WHITE</label>
          <input type="radio" id="color" name="print_color" value="COLOR"
                 class="form-check-input btn-check" autocomplete="off" required>
          <label class="btn btn-outline-primary mt-2 mb-2" for="color">COLOR</label>
         </div>
         </div>
         </div>
         </div>
         <!-- PRINT SIDE  -->
         <div class="accordion-item">
         <h2 class="accordion-header" id="flush-printSide">
         <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#printSide" aria-expanded="false" aria-controls="printSide">
         Print Side
         </button></h2>
         <div id="printSide" class="accordion-collapse collapse" aria-labelledby="flush-printSide" data-bs-parent="#xpresPrints">
         <div class="accordion-body">
         <div class="form-check">
          <input type="radio" id="backtoback" name="print_side"
                 value="DOUBLE SIDE (BACK TO BACK)" class="form-check-input btn-check"
                 autocomplete="off" required>
          <label class="btn btn-outline-primary mt-2 mb-2" for="backtoback">DOUBLE SIDE (BACK
           TO BACK)</label>
          <input type="radio" id="singleside" name="print_side" value="SINGLE SIDE"
                 class="form-check-input btn-check" autocomplete="off" required>
          <label class="btn btn-outline-primary mt-2 mb-2" for="singleside">SINGLE
           SIDE</label>
         </div>
         </div>
         </div>
         </div>
         <!-- NUMBER of PAGES -->
         <div class="accordion-item">
         <h2 class="accordion-header" id="flush-numberOfPages">
         <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#numberOfPages" aria-expanded="false" aria-controls="numberOfPages">
         Number of Pages
         </button></h2>
         <div id="numberOfPages" class="accordion-collapse collapse" aria-labelledby="flush-numberOfPages" data-bs-parent="#xpresPrints">
         <div class="accordion-body">
         <div class="form-check mt-2 mb-2">
          <input class="form-control mt-2 mb-2" type="number" min="10" value="0 Mark"
                 name="num_pages" placeholder="No. of PAGES" id="num_pages" required>
          <input class="form-control mt-2 mb-2" type="number" min="1" value="0 Mark"
                 name="num_copies" id="num_copies" placeholder="No. of COPIES" required>
         </div>
         </div>
         </div>
         </div>
         <!-- BINDING TYPE  -->
         <div class="accordion-item">
         <h2 class="accordion-header" id="flush-bindingType">
         <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#bindingType" aria-expanded="false" aria-controls="bindingType">
         Binding Type
         </button></h2>
         <div id="bindingType" class="accordion-collapse collapse" aria-labelledby="flush-bindingType" data-bs-parent="#xpresPrints">
         <div class="accordion-body">
         <div class="form-check">
          <input type="radio" id="staple" name="binding_type" value="STAPLE"
                 class="form-check-input btn-check" autocomplete="off" required>
          <label class="btn btn-outline-primary mt-2 mb-2" for="staple">STAPLE</label>
          <input type="radio" id="spiral" name="binding_type" value="SPIRAL"
                 class="form-check-input btn-check" autocomplete="off" required>
          <label class="btn btn-outline-primary mt-2 mb-2" for="spiral">SPIRAL</label>
          <input type="radio" id="projectWork" name="binding_type" value="PROJECT WORK"
                 class="form-check-input btn-check" autocomplete="off" required>
          <label class="btn btn-outline-primary mt-2 mb-2" for="projectWork">PROJECT
           WORK</label>
          <input type="radio" id="phpThesis" name="binding_type" value="PHD THESIS"
                 class="form-check-input btn-check" autocomplete="off" required>
          <label class="btn btn-outline-primary mt-2 mb-2" for="phpThesis">PHD THESIS</label>
         </div>
         </div>
         </div>
         </div>
         <div class="accordion-item">
         <h2 class="accordion-header" id="flush-addInfo">
         <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#addInfo" aria-expanded="false" aria-controls="addInfo">
         Any additional instructions
         </button></h2>
         <div id="addInfo" class="accordion-collapse collapse" aria-labelledby="flush-addInfo" data-bs-parent="#xpresPrints">
         <div class="accordion-body">
         <div class="form-check">
          <textarea class="form-control" placeholder="Any additional instructions :" name="addinstruction"
                    id="addInstruction"></textarea>
          <label for="addInstruction"></label>
         </div>
         </div>
         </div>
         </div>
          <div class="d-grid mt-5 mb-5 gap-2">
           <button class="btn btn-outline-primary btn-block ripple-surface" name="print"
                   value="" type="submit">Order Now</button>
          </div>
        </div><!-- end accordion-->
      </form><!-- end form-->
    </div><!-- col-lg-6 col-12 end col2-->
   </div><!-- row 1 end-->
</div><!-- container-->

   <footer class="footer text-center mt-auto bg-primary">
  <div class="container">
    <span class="copyright">Copyright &copy; XPRESKART 2020</span>
  </div>
</footer>
   <!-- Optional JavaScript -->
   <!-- jQuery first, then Popper.js, then Bootstrap JS -->
   <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
   <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script> -->
   <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js"></script> -->
   <script type="text/javascript" src="<?= get_stylesheet_directory_uri() . '/prints/jquery-3.5.1.min.js'; ?>"></script>
   <script type="text/javascript" src="<?= get_stylesheet_directory_uri() . '/prints/file-upload-with-preview.min.js'; ?>"></script>
   <script type="text/javascript" src="<?= get_stylesheet_directory_uri() . '/prints/bootstrap.bundle.min.js'; ?>"></script>
   <script type="text/javascript" src="<?= get_stylesheet_directory_uri() . '/prints/xpresPrints.js'; ?>"></script>
 </body>

</html>
<?php
$template = ob_get_contents();
ob_end_clean();
echo $template;