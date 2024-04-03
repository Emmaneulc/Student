<?php
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$response = array('success' => false, 'message' => '');

$membershipTypesQuery = "SELECT id, type, amount FROM membership_types";
$membershipTypesResult = $conn->query($membershipTypesQuery);

function generateUniqueFileName($originalName) {
    $timestamp = time();
    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
    $uniqueName = $timestamp . '_' . uniqid() . '.' . $extension;
    return $uniqueName;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $contactNumber = $_POST['contactNumber'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $section = $_POST['section'];
    $department = $_POST['department'];
    $membershipType = 1;
    $student_guard = $_POST['g_fullname'];

    $membershipNumber = $_POST['student_id'];

    if (!empty($_FILES['photo']['name'])) {
        $uploadedPhoto = $_FILES['photo'];
        $uniquePhotoName = generateUniqueFileName($uploadedPhoto['name']);

        move_uploaded_file($uploadedPhoto['tmp_name'], 'uploads/member_photos/' . $uniquePhotoName);
        } else {
            $uniquePhotoName = 'default.jpg';
        }

    $insertQuery = "INSERT INTO members (fullname, dob, gender, contact_number, email, address, section, department, 
                    membership_type, membership_number, photo, created_at, student_guard) 
                    VALUES ('$fullname', '$dob', '$gender', '$contactNumber', '$email', '$address', '$section', '$department', 
                            '$membershipType', '$membershipNumber', '$uniquePhotoName', NOW(), '$student_guard')";

    if ($conn->query($insertQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = 'Member added successfully! Student Number: ' . $membershipNumber;
    } else {
        $response['message'] = 'Error: ' . $conn->error;
    }
}
// Visit codeastro.com for more projects
?>



<?php include('includes/header.php');?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
    <?php include('includes/nav.php'); ?>

    <?php include('includes/sidebar.php'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <?php include('includes/pagetitle.php'); ?>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">

                        <?php if ($response['success']): ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-check"></i> Success</h5>
                                <?php echo $response['message']; ?>
                            </div>
                        <?php elseif (!empty($response['message'])): ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-ban"></i> Error</h5>
                                <?php echo $response['message']; ?>
                            </div>
                        <?php endif; ?>
                      
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-keyboard"></i> Add Students Form</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="fullname">Full Name</label>
                                            <input type="text" class="form-control" id="fullname" name="fullname"
                                                   placeholder="Enter full name" required>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="dob">Date of Birth</label>
                                            <input type="date" class="form-control" id="dob" name="dob" required>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="gender">Gender</label>
                                            <select class="form-control" id="gender" name="gender" required>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="row mt-3">
                                        <div class="col-sm-6">
                                            <label for="contactNumber">Contact Number</label>
                                            <input type="tel" class="form-control" id="contactNumber"
                                                   name="contactNumber" placeholder="Enter contact number" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                   placeholder="Enter email" required>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-sm-6">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control" id="address" name="address"
                                                   placeholder="Enter address" required>
                                        </div>
                                        <div class="col-sm-6">
                                             <label for="section">Section</label>
                                            <select class="form-control" id="section" name="section" required>
                                                <option value="">----Select----</option>
                                                <?php
                                                  
                                                    $sectionQuery = "SELECT * FROM section";
                                                    $sectionResult = $conn->query($sectionQuery);
                                                    while ($row2 = $sectionResult->fetch_assoc()) {
                                                      
                                                        echo "<option value='".$row2['section']."'>".$row2['section']."</option>";
                                              }
                                            ?> 
                                            </select>
                                        </div>
                                    </div>
                                

                                    <div class="row mt-3">
                                        <div class="col-sm-6">
                                             <label for="department">Department</label>
                                            <select class="form-control" id="department" name="department" required>
                                                <option value="">----Select----</option>
                                                <?php
                                            $departmentQuery = "SELECT * FROM department";
                                            $departmentResult = $conn->query($departmentQuery);
                                           
                                            while ($row3 = $departmentResult->fetch_assoc()) {
                                              
                                                echo "<option value='".$row3['department']."'>".$row3['department']."</option>";
                                              }
                                            ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="fullname">Student ID</label>
                                            <input type="text" class="form-control" id="student_id" name="student_id"
                                                   placeholder="Enter Student ID Number" required>
                                        </div>
                                       
                                    </div>

                                    <div class="row mt-3">
                                  

                                    <div class="col-sm-6">
                                        <label for="photo">Member Photo</label>
                                        <input type="file" class="form-control-file" id="photo" name="photo">
                                    </div>
                                          <div class="col-sm-6">
                                            <label for="fullname">Guardian Fullname</label>
                                            <input type="text" class="form-control" id="g_fullname" name="g_fullname"
                                                   placeholder="Enter Guardian full name" required>
                                        </div>
                                </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!--/.col (left) -->

                </div>
                <!-- /.row -->
               

            </div><!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
  <?php include('includes/main_footer.php');?>
</div>
<!-- ./wrapper -->

<?php include('includes/footer.php'); ?>
</body>
</html>
