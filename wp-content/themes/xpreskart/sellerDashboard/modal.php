
<!-- Edit Modal -->
<div class="modal fade" id="StudentEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Edit Student Data without page reload</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">&times;</span>
    </button>
   </div>
   <div class="modal-body">
    <div class="row">
     <input type="hidden" id="id_edit">

     <div class="col-md-12">
      <div class="error-message">

      </div>
     </div>
     <div class="col-md-6">
      <label for="">First Name</label>
      <input type="text" id="edit_fname" class="form-control">
     </div>
     <div class="col-md-6">
      <label for="">Last Name</label>
      <input type="text" id="edit_lname" class="form-control">
     </div>
     <div class="col-md-6">
      <label for="">Class</label>
      <input type="text" id="edit_class" class="form-control">
     </div>
     <div class="col-md-6">
      <label for="">Section</label>
      <input type="text" id="edit_section" class="form-control">
     </div>
    </div>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary student_update_ajax">Update</button>
   </div>
  </div>
 </div>
</div>

<div class="container mt-5">
 <div class="row">
  <div class="col-md-12">
   <div class="card">
    <div class="card-header">
     <h4>
      PHP - AJAX - CRUD | Data without page reload using jquery ajax in php.
      <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#Student_AddModal">
       Add
      </button>
     </h4>
    </div>
    <div class="card-body">
     <div class="message-show">

     </div>
     <table class="table table-bordered table-striped">
      <thead>
       <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Class</th>
        <th>Section</th>
        <th>Action</th>
       </tr>
      </thead>
      <tbody class="studentdata">

      </tbody>
     </table>
    </div>
   </div>
  </div>
 </div>
</div>


<script>
 $(document).ready(function () {
  getdata();

  $(document).on("click", ".edit_btn", function () {

   var stud_id = $(this).closest('tr').find('.stud_id').text();
   // alert(stud_id);

   $.ajax({
    type: "POST",
    url: "ajax-crud/code.php",
    data: {
     'checking_edit': true,
     'stud_id': stud_id,
    },
    success: function (response) {
     // console.log(response);
     $.each(response, function (key, studedit) {
      // console.log(studview['fname']);
      $('#id_edit').val(studedit['id']);
      $('#edit_fname').val(studedit['fname']);
      $('#edit_lname').val(studedit['lname']);
      $('#edit_class').val(studedit['class']);
      $('#edit_section').val(studedit['section']);
     });
     $('#StudentEditModal').modal('show');
    }
   });

  });

 });
</script>


<!-- Student Edit Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel" aria-hidden="true">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title" id="editStudentModalLabel">Student Edit Data</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">&times;</span>
    </button>
   </div>
   <form action="code.php" method="POST">
    <div class="modal-body">
     <input type="hidden" name="edit_id" id="edit_id">
     <div class="form-group">
      <label for="">First Name</label>
      <input type="text" name="fname" id="edit_fname" class="form-control" placeholder="Enter First Name">
     </div>
     <div class="form-group">
      <label for="">Last Name</label>
      <input type="text" name="lname" id="edit_lname" class="form-control" placeholder="Enter Last Name">
     </div>
     <div class="form-group">
      <label for="">Class</label>
      <input type="text" name="class" id="edit_class" class="form-control" placeholder="Enter Class">
     </div>
     <div class="form-group">
      <label for="">Section</label>
      <input type="text" name="section" id="edit_section" class="form-control" placeholder="Enter Section">
     </div>
    </div>
    <div class="modal-footer">
     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
     <button type="submit" name="update_student" class="btn btn-primary">Update</button>
    </div>
   </form>
  </div>
 </div>
</div>
<!-- Student Edit Modal -->



<div class="container mt-5">
 <div class="row">
  <div class="col-md-12">
   <div class="card">
    <?php
    if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
     ?>

     <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>Hey!</strong> <?php echo $_SESSION['status']; ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
      </button>
     </div>
     <?php
     unset($_SESSION['status']);
    }
    ?>
    <div class="card-header">
     <h5>
      PHP CRUD -  Bootstrap Modal (POP UP)
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#studentModal">
       Add Student
      </button>
     </h5>
    </div>
    <div class="card-body">
     <table class="table">
      <thead>
       <tr>
        <th scope="col">#ID</th>
        <th scope="col">First Name</th>
        <th scope="col">Last Name</th>
        <th scope="col">Class</th>
        <th scope="col">Section</th>
        <th scope="col">Action</th>
       </tr>
      </thead>
      <tbody>
       <?php
       $conn = mysqli_connect("localhost", "root", "", "phpcrud");
       $query = "SELECT * FROM students";
       $query_run = mysqli_query($conn, $query);

       if (mysqli_num_rows($query_run) > 0) {
        // while($row = mysqli_fetch_array($query_run))
        foreach ($query_run as $row) {
         ?>
         <tr>
          <td class="stud_id"><?php echo $row['id']; ?></td>
          <td><?php echo $row['fname']; ?></td>
          <td><?php echo $row['lname']; ?></td>
          <td><?php echo $row['class']; ?></td>
          <td><?php echo $row['section']; ?></td>
          <td>
           <a href="#" class="badge badge-primary view_btn">VIEW</a>
           <a href="#" class="badge badge-info edit_btn">EDIT</a>
           <a href="#" class="badge badge-danger">DELETE</a>
          </td>
         </tr>
         <?php
        }
       } else {
        echo "<h5>No Record Found</h5>";
       }
       ?>
      </tbody>
     </table>
    </div>
   </div>
  </div>
 </div>
</div>

<script>
 $(document).ready(function () {

  $('.edit_btn').click(function (e) {
   e.preventDefault();

   var stud_id = $(this).closest('tr').find('.stud_id').text();
   // console.log(stud_id);

   $.ajax({
    type: "POST",
    url: "code.php",
    data: {
     'checking_edit_btn': true,
     'student_id': stud_id,
    },
    success: function (response) {
     // console.log(response);
     $.each(response, function (key, value) {
      //  console.log(value['fname']);
      $('#edit_id').val(value['id']);
      $('#edit_fname').val(value['fname']);
      $('#edit_lname').val(value['lname']);
      $('#edit_class').val(value['class']);
      $('#edit_section').val(value['section']);
     });

     $('#editStudentModal').modal('show');
    }
   });

  });

 });
</script>

</body>
</html>

Step 3: Create a file named code.php
<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "phpcrud");

// Student Edit Data
if (isset($_POST['checking_edit_btn'])) {
 $s_id = $_POST['student_id'];
 // echo $return = $s_id;
 $result_array = [];

 $query = "SELECT * FROM students WHERE id='$s_id' ";
 $query_run = mysqli_query($conn, $query);

 if (mysqli_num_rows($query_run) > 0) {
  foreach ($query_run as $row) {
   array_push($result_array, $row);
   header('Content-type: application/json');
   echo json_encode($result_array);
  }
 } else {
  echo $return = "<h5>No Record Found</h5>";
 }
}

if (isset($_POST['update_student'])) {
 $id = $_POST['edit_id'];
 $fname = $_POST['fname'];
 $lname = $_POST['lname'];
 $class = $_POST['class'];
 $section = $_POST['section'];

 $query = "UPDATE students SET fname='$fname', lname='$lname', class='$class', section='$section' WHERE id='$id' ";
 $query_run = mysqli_query($conn, $query);

 if ($query_run) {
  $_SESSION['status'] = "Successfully Updated";
  header('Location: index.php');
 } else {
  $_SESSION['status'] = "Something Went Wrong.!";
  header('Location: index.php');
 }
}
?>