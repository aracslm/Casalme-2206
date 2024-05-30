<?php
session_start();


if (!isset($_SESSION['usernameOrEmail'])) {
    header("location: ../2206 .php");
    exit();
}

$usernameOrEmail = $_SESSION['usernameOrEmail'];

if (isset($_POST['logout'])) {
    session_destroy();
    header("location:login.php");
    exit();
}
?>

<!-- tabledata -->
<?php
include("conn/Connection.php");

$query = "SELECT * FROM complain";
$result = mysqli_query($Connections, $query);

mysqli_close($Connections);

include("conn/Connection.php");
?>

<!-- delete -->
<?php
// Check if the form for deletion is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_ID'])) {
    // Get the ID of the record to be deleted
    $delete_ID = mysqli_real_escape_string($Connections, $_POST['delete_ID']);

    // Delete query
    $delete_query = "DELETE FROM complain WHERE id='$delete_ID'";

    // Execute the delete query
    if (mysqli_query($Connections, $delete_query)) {
        echo "Record deleted successfully";
        // Redirect back to the dashboard or any other page
        header("location: 2206 .php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($Connections);
    }
}
?>

<!-- edit -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_id'])) {
    // Retrieve data from the form
    $edit_id = mysqli_real_escape_string($Connections, $_POST['edit_id']);
    $edit_cid = mysqli_real_escape_string($Connections, $_POST['edit_cid']);
    $edit_fname = mysqli_real_escape_string($Connections, $_POST['edit_fname']);
    $edit_tc = mysqli_real_escape_string($Connections, $_POST['edit_tc']);
    $edit_rtc = mysqli_real_escape_string($Connections, $_POST['edit_rtc']);

    // Update query
    $query = "UPDATE complain SET cid='$edit_cid', fname='$edit_fname', tc='$edit_tc', rtc='$edit_rtc' WHERE id='$edit_id'";

    if (mysqli_query($Connections, $query)) {
        echo "Record updated successfully";
        header("location: 2206 .php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($Connections);
    }
}
?>

<!-- addnewmodal -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cid = mysqli_real_escape_string($Connections, $_POST['cid']);
    $fname = mysqli_real_escape_string($Connections, $_POST['fname']);
    $tc = mysqli_real_escape_string($Connections, $_POST['tc']);
    $rtc = mysqli_real_escape_string($Connections, $_POST['rtc']);

    $query = "INSERT INTO complain (cid,fname,tc,rtc) VALUES ('$cid', '$fname', '$tc','$rtc')";
    if (mysqli_query($Connections, $query)) {
        echo "Successfully Added";
        header("location: 2206 .php");
        exit();
    } else {
        echo "Error: " . mysqli_error($Connections);
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Module 1 | Legal Management </title>
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="boxicons-2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="fontawsome/css/all.min.css">
    <link rel="stylesheet" href="fontawsome/css/fontawesome.min.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body class="gray-background">
  <div class="sidebar">
    <div class="logo-details">
        <div class="logo_name">Legal Management </div>
        <i class='fas fa-bars' id="btn" ></i>
    </div>
    <ul class="nav-list p-0">
      <li>
        <i class='fas fa-search' ></i>
        <input type="text" placeholder="Search...">
            <span class="tooltip">Search</span>
      </li>
      <li>
        <a href="admin.php">
          <i class='fas fa-qrcode'></i>
          <span class="links_name">Dashboard</span>
        </a>
         <span class="tooltip">Dashboard</span>
      </li>
      <li>
       <a href="2206 .php">
       <i class='fas fa-folder' ></i>
         <span class="links_name">Module 1</span>
       </a>
       <span class="tooltip">Module 1</span>
     </li>
     <li>
       <a href="#">
       <i class='fas fa-folder' ></i>
         <span class="links_name">Module 2</span>
       </a>
       <span class="tooltip">Module 2</span>
     </li>
     <li>
       <a href="#">
       <i class='fas fa-folder' ></i>
         <span class="links_name">Module 3</span>
       </a>
       <span class="tooltip">Module 3</span>
     </li>
     <li>
       <a href="#">
         <i class='fas fa-folder' ></i>
         <span class="links_name">Module 4</span>
       </a>
       <span class="tooltip">Module 4</span>
     </li>
     <li>
       <a href="#">
       <i class='fas fa-folder' ></i>
         <span class="links_name">Module 5</span>
       </a>
       <span class="tooltip">Module 5</span>
     </li>
     <li class="profile">
           <div class="name_job text-center d-flex justify-content-center">
             <div class="name"><?php echo $usernameOrEmail?></div>
           </div>
         <form method="post" class="nav_link">
          <button type="submit" name="logout">
         <i class='fas fa-right-from-bracket' id="log_out" name="logout"></i>
         </button>
</form>
     </li>
    </ul>
  </div>

  <section class="home-section">
      <div class="text mb-2">Module 1</div><hr>

      <div class="height-fit m-3">
        <h4 class="mb-3">List of Complaints.</h4>
        <!-- addnewmodal -->
        <button type="button " data-mdb-button-init data-mdb-ripple-init class="btn btn-primary" data-mdb-modal-init data-mdb-target="#staticBackdrop2">Add New</button>
        <!-- addModal -->
        <div class="modal fade w-100 bg-transparent" id="staticBackdrop2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">Add New</h5>
                        <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" class="row g-2  mt-1" id="fillupForm">
            
                            <div class="col-md-4">
                                <label for="fname" class="form-label">ID</label>
                                <input type="number" name="cid" class="form-control" id="fname" required>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="fname" class="form-label">Name</label>
                                <input type="text" name="fname" class="form-control" id="lname" required>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="phone" class="form-label">Type of Complaint</label>
                                <select class="form-select" id="gender" name="tc" required>
                                        <option value="">Choose...</option>
                                        <option value="Quality and Safety">Quality and Safety</option>
                                        <option value="Incorrect Information">Incorrect Information</option>
                                        <option value="Error in Diagnosis">Error in Diagnosis</option>
                                        <option value="Neglection">Neglection</option>
                                        <option value="Environment">Environment</option>
                                        <option value="Service Issues">Service Issues</option>
                                    </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="streetname" class="form-label">Relation to the Complainant</label>
                                <input type="text" name="rtc" class="form-control" id="rtc" required>
                            </div>
                            
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit" id="submitBtn">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

<!-- Table content -->
<style>
    .btnn{
        width: 30px;
        height: 30px;
        border:0;
    }
</style>
        <div class="container container-fluid mt-4">
            <table class="table table-bordered table-light">
            <thead>
                <tr class="text-center">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type of Complaint</th>
                    <th >Relation to the Complainant</th> 
                    <th class="px-0" colspan="3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo $row['cid']; ?></td>
                        <td><?php echo $row['fname']; ?></td>
                        <td><?php echo $row['tc']; ?></td>
                        <td><?php echo $row['rtc']; ?></td>
                        <!-- viewbtn -->
                        <td class="text-center px-0">
                            <button type="button" class="btn btn-success rounded-2 view-btn">View</button>
                            <button type="button" class="btn btn-primary rounded-2 edit-btn" data-toggle="modal" data-target="#editModal" data-id="<?php echo $row['id']; ?>">Edit</button>
                            <button type="button" class="btn btn-danger rounded-2 delete-btn" data-id="<?php echo $row['id']; ?>">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
            </table>
        </div>
    </div>

<!-- viewmodal -->

<div class="modal fade w-100" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog w-75 d-flex justify-content-center">
                <div class="modal-content w-auto">
                    <div class="modal-header d-flex justify-content-between m-0">
                        <h5 class="modal-title" id="viewModalLabel">View Details</h5>
                        <button type="button" data-mdb-button-init data-mdb-ripple-init class="close rounded-1 btn btn-danger" data-mdb-dismiss="modal" aria-label="Close"><i class="bx bx-x "></i></button>
                    </div>
            <div class="modal-body">
                <!-- Display data in a table -->
                <table class="table table-bordered w-100">
                    <tbody>
                        <tr class=" text-nowrap">
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Type of Complaint</th>
                            <th scope="col">Relation to the Complainant</th>
                        </tr>
                        <tr >
                            <td id="view_cid"></td>
                            <td id="view_fname"></td>
                            <td id="view_tc"></td>
                            <td id="view_rtc"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- editmodal -->
<style>
      .modal-backdrop.show{
        opacity: 0;
      }
      .modal-backdrop{
        --bs-backdrop-zindex: 0;
      }
      /* Overlay background */
      .modal {
          backdrop-filter: blur(4px); /* Adjust the blur effect as needed */
      }
  </style>

<div class="modal fade w-100 bg-transparent" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header justify-content-between">
                <h5 class="modal-title" id="editModalLabel">Edit</h5>
                <button type="button" class="btn btn-danger close" data-dismiss="modal" aria-label="Close"><i class="bx bx-x"></i>
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="" class="row g-2 mt-1" id="editForm">
                    <div class="col-md-4">
                        <label for="edit_cid" class="form-label text-nowrap">ID</label>
                        <input type="number" name="edit_cid" class="form-control" id="edit_cid" required>
                    </div>

                    <div class="col-md-4">
                        <label for="edit_fname" class="form-label">Name</label>
                        <input type="text" name="edit_fname" class="form-control" id="edit_fname" required>
                    </div>

                    <div class="col-md-4">
                        <label for="edit_tc" class="form-label">Type of Complaint</label>
                        <select class="form-select" id="edit_tc" name="edit_tc" required>
                                <option value="">Choose...</option>
                                <option value="Quality and Safety">Quality and Safety</option>
                                <option value="Incorrect Information">Incorrect Information</option>
                                <option value="Error in Diagnosis">Error in Diagnosis</option>
                                <option value="Neglection">Neglection</option>
                                <option value="Environment">Environment</option>
                                <option value="Service Issues">Service Issues</option>
                            </select>
                    </div>

                    <div class="col-md-5">
                        <label for="edit_rtc" class="form-label">Relation to the Complainant</label>
                        <input type="text" name="edit_rtc" class="form-control" id="edit_rtc" required>
                        <div class="invalid-feedback">Please enter your Complain</div>
                    </div>
                    <input type="hidden" name="edit_id" id="edit_id">

                    <div class="col-12">
                        <button class="btn btn-primary" type="submit" id="editBtn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- deleteModal -->
<form method="post" id="deleteForm">
    <div class="modal fade w-100" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                    <button type="button" class="close btn btn-danger " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="bx bx-x"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this record?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <!-- This button triggers the actual deletion -->
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="delete_ID" id="delete_ID">
</form>
  </section>

  <script>
 let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".fa-search");
let body = document.querySelector("body"); 

closeBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("open");
  body.classList.toggle("gray-background"); 
  menuBtnChange();
});

searchBtn.addEventListener("click", ()=>{ 
  sidebar.classList.toggle("open");
  body.classList.toggle("gray-background"); 
  menuBtnChange(); 
});

function menuBtnChange() {
 if(sidebar.classList.contains("open")){
   closeBtn.classList.replace("fa-bars", "fa-arrow-right");
 } else {
   closeBtn.classList.replace("fa-arrow-right", "fa-bars"); 
 }
}


  </script>
  <!-- addnewModal -->
  <script>
    $(document).ready(function(){
        $('[data-mdb-target="#staticBackdrop2"]').click(function(){
            $('#staticBackdrop2').modal('show');
        });

        $('.btn-close').click(function(){
            $('#staticBackdrop2').modal('hide');
        });

        $(document).on('click', function(event) {
            if ($(event.target).hasClass('modal')) {
                $('#staticBackdrop2').modal('hide');
            }
        });
    });
</script>

<!-- editModal -->
<script>
$('.close').click(function() {
// Reload the page when the close button is clicked
location.reload();
});
$('.edit-btn').click(function(){
var edit_id = $(this).data('id');
// Fetch data from the table row
var cid = $(this).closest('tr').find('td:eq(0)').text(); // First name column
var fname = $(this).closest('tr').find('td:eq(1)').text(); // Last name column
var tc = $(this).closest('tr').find('td:eq(2)').text(); // Email column
var rtc = $(this).closest('tr').find('td:eq(3)').text(); // Phone colum

// Populate the edit modal fields with fetched data
$('#edit_id').val(edit_id);
$('#edit_cid').val(cid);
$('#edit_fname').val(fname);
$('#edit_tc').val(tc);
$('#edit_rtc').val(rtc);

// Show the edit modal
$('#editModal').modal('show');

// Show hidden columns
$('.hidden-column').hide();

});
</script>


<!-- view -->
<script>
$(document).ready(function(){
$('.view-btn').click(function(){
    var row = $(this).closest('tr'); // Get the closest table row
    var cid = row.find('td:eq(0)').text(); // Get the value of the first column
    var fname = row.find('td:eq(1)').text(); // Get the value of the second column
    var tc = row.find('td:eq(2)').text(); // Get the value of the third column
    var rtc = row.find('td:eq(3)').text(); // Get the value of the third column
    // Similarly, fetch other columns' values as needed

    // Populate the view modal fields with the fetched data
    $('#view_cid').text(cid);
    $('#view_fname').text(fname);
    $('#view_tc').text(tc);
    $('#view_rtc').text(rtc);
    // Similarly, populate other modal fields as needed

    // Show the view modal
    $('#viewModal').modal('show');

    $('.close').click(function() {
// Hide the modal when the close button is clicked
     $('#viewModal').modal('hide');
});
});
});
</script>
<!-- delete -->
<script>
$(document).ready(function(){
$('.close, .btn-secondary').click(function(){
    // Close the modal
    $('#confirmationModal').modal('hide');
});

$('.delete-btn').click(function(){
    var delete_ID = $(this).data('id'); // Get the ID of the record to be deleted
    $('#delete_ID').val(delete_ID); // Set the value of the hidden form field
    $('#confirmationModal').modal('show'); // Show the confirmation modal
});

$('#confirmDeleteBtn').click(function(){
    // Submit the form for deletion
    $('#deleteForm').submit();
});
});
</script>
</body>
<style>
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins" , sans-serif;
}
body.gray-background {
  background-color: gray;
}

.sidebar{
  position: fixed;
  left: 0;
  top: 0;
  height: 100%;
  width: 78px;
  background: #11295c;
  padding: 6px 14px;
  z-index: 100;
  transition: all 0.5s ease;
}
.sidebar.open{
  width: 250px;
}
.sidebar .logo-details{
  height: 60px;
  display: flex;
  align-items: center;
  position: relative;
}
.sidebar .logo-details img{
  width: 30px;
  height: 30px;
  border-radius: 50px;
  transition: all 0.5s ease;
}
.sidebar .logo-details .logo_name{
  color: #fff;
  font-size: 20px;
  font-weight: 600;
  opacity: 0;
  transition: all 0.5s ease;
}
.sidebar.open .logo-details .img,
.sidebar.open .logo-details .logo_name{
  opacity: 1;
}
.sidebar .logo-details #btn{
  position: absolute;
  top: 50%;
  right: 0;
  transform: translateY(-50%);
  font-size: 22px;
  transition: all 0.4s ease;
  font-size: 23px;
  text-align: center;
  cursor: pointer;
  transition: all 0.5s ease;
}
.sidebar.open .logo-details #btn{
  text-align: right;
}
.sidebar i{
  color: #fff;
  height: 60px;
  min-width: 50px;
  font-size: 28px;
  text-align: center;
  line-height: 60px;
}
.sidebar .nav-list{
  margin-top: 20px;
  height: 100%;
}
.sidebar li{
  position: relative;
  margin: 8px 0;
  list-style: none;
}
.sidebar li .tooltip{
  position: absolute;
  top: -20px;
  left: calc(100% + 15px);
  z-index: 3;
  background: white;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
  padding: 6px 12px;
  border-radius: 4px;
  font-size: 15px;
  font-weight: 400;
  opacity: 0;
  white-space: nowrap;
  pointer-events: none;
  transition: 0s;
}
.sidebar li:hover .tooltip{
  opacity: 1;
  pointer-events: auto;
  transition: all 0.4s ease;
  top: 50%;
  transform: translateY(-50%);
}
.sidebar.open li .tooltip{
  display: none;
}
.sidebar input{
  font-size: 15px;
  color: #FFF;
  font-weight: 400;
  outline: none;
  height: 50px;
  width: 100%;
  width: 50px;
  border: none;
  border-radius: 12px;
  transition: all 0.5s ease;
  background: #1d1b31;
}
.sidebar.open input{
  padding: 0 20px 0 50px;
  width: 100%;
}
.sidebar .fa-search{
  position: absolute;
  top: 50%;
  left: 0;
  transform: translateY(-50%);
  font-size: 22px;
  background: #1d1b31;
  color: #FFF;
}
.sidebar.open .fa-search:hover{
  background: #1d1b31;
  color: #FFF;
}
.sidebar .fa-search:hover{
  background: #FFF;
  color: #11101d;
}
.sidebar li a{
  display: flex;
  height: 100%;
  width: 100%;
  border-radius: 12px;
  align-items: center;
  text-decoration: none;
  transition: all 0.4s ease;
  background: #11101D;
}
.sidebar li a:hover{
  background: #FFF;
}
.sidebar li a .links_name{
  color: #fff;
  font-size: 15px;
  font-weight: 400;
  white-space: nowrap;
  opacity: 0;
  pointer-events: none;
  transition: 0.4s;
}
.sidebar.open li a .links_name{
  opacity: 1;
  pointer-events: auto;
}
.sidebar li a:hover .links_name,
.sidebar li a:hover i{
  transition: all 0.5s ease;
  color: #11101D;
}
.sidebar li i{
  height: 50px;
  line-height: 50px;
  font-size: 18px;
  border-radius: 12px;
}
.sidebar li.profile{
  position: fixed;
  height: 60px;
  width: 78px;
  left: 0;
  bottom: -8px;
  padding: 10px 14px;
  background:  #11101D;
  transition: all 0.5s ease;
  overflow: hidden;
}
.sidebar.open li.profile{
  width: 250px;
}
.sidebar li .profile-details{
  display: flex;
  align-items: center;
  flex-wrap: nowrap;
}
.sidebar li img{
  height: 45px;
  width: 45px;
  object-fit: cover;
  border-radius: 6px;
  margin-right: 10px;
}
.sidebar li.profile .name,
.sidebar li.profile .email{
  font-size: 15px;
  font-weight: 400;
  color: #fff;
  white-space: nowrap;
}
.sidebar li.profile .email{
  font-size: 12px;
}
.sidebar .profile #log_out{
  position: absolute;
  top: 50%;
  right: 0;
  transform: translateY(-50%);
  background: #1d1b31;
  width: 100%;
  height: 60px;
  line-height: 60px;
  border-radius: 0px;
  transition: all 0.5s ease;
}
.sidebar.open .profile #log_out{
  width: 50px;
  background: none;
}
.home-section{
  position: relative;
  background: lightgray;
  min-height: 100vh;
  top: 0;
  left: 78px;
  width: calc(100% - 78px);
  transition: all 0.5s ease;
  z-index: 2;
}
.sidebar.open ~ .home-section{
  left: 250px;
  width: calc(100% - 250px);
}
.home-section .text{
  display: inline-block;
  color: #11101d;
  font-size: 25px;
  font-weight: 500;
  margin: 18px
}
@media (max-width: 420px) {
  .sidebar li .tooltip{
    display: none;
  }
}</style>
</html>