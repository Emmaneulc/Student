<?php
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$response = array('success' => false, 'message' => '');

$membershipTypesQuery = "SELECT id, type, amount FROM membership_types";
$membershipTypesResult = $conn->query($membershipTypesQuery);

if (isset($_GET['id'])) {
    $memberId = $_GET['id'];

    $fetchMemberQuery = "SELECT * FROM members WHERE id = $memberId";
    $fetchMemberResult = $conn->query($fetchMemberQuery);

    if ($fetchMemberResult->num_rows > 0) {
        $memberDetails = $fetchMemberResult->fetch_assoc();
    } else {
        header("Location: members_list.php");
        exit();
    }
}

function generateUniqueFileName($filename)
{
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $basename = pathinfo($filename, PATHINFO_FILENAME);
    $uniqueName = $basename . '_' . time() . '.' . $ext;
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
    $student_guard = $_POST['g_fullname'];


    $photoUpdate = "";
    $uploadedPhoto = $_FILES['photo'];

    if (!empty($uploadedPhoto['name'])) {
        $uniquePhotoName = generateUniqueFileName($uploadedPhoto['name']);
        move_uploaded_file($uploadedPhoto['tmp_name'], 'uploads/member_photos/' . $uniquePhotoName);
        $photoUpdate = ", photo='$uniquePhotoName'";
    }

    $updateQuery = "UPDATE members SET fullname='$fullname', dob='$dob', gender='$gender', 
                    contact_number='$contactNumber', email='$email', address='$address', student_guard='$student_guard', section='$section', 
                    department='$department' $photoUpdate
                    WHERE id = $memberId";

    if ($conn->query($updateQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = 'Member updated successfully!';
        
        header("Location: manage_members.php");
        exit();
    } else {
        $response['message'] = 'Error: ' . $conn->error;
    }
}
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
                                <h3 class="card-title"><i class="fas fa-keyboard"></i> Edit Member Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="post" action="" enctype="multipart/form-data">
                            <input type="hidden" name="member_id" value="<?php echo $id; ?>">
                                <div class="card-body">
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <label for="fullname">Full Name</label>
                                    <input type="text" class="form-control" id="fullname" name="fullname"
                                        placeholder="Enter full name" required value="<?php echo $memberDetails['fullname']; ?>">
                                </div>
                                        <div class="col-sm-3">
                                            <label for="dob">Date of Birth</label>
                                            <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $memberDetails['dob']; ?>" required>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <label for="gender">Gender</label>
                                        <select class="form-control" id="gender" name="gender" required>
                                            <option value="Male" <?php echo ($memberDetails['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                            <option value="Female" <?php echo ($memberDetails['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                            <option value="Other" <?php echo ($memberDetails['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                                        </select>
                                    </div>

                                    </div>


                                    <div class="row mt-3">
                                        <div class="col-sm-6">
                                            <label for="contactNumber">Contact Number</label>
                                            <input type="tel" class="form-control" id="contactNumber"
                                                   name="contactNumber" placeholder="Enter contact number" value="<?php echo $memberDetails['contact_number']; ?>" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                   placeholder="Enter email" value="<?php echo $memberDetails['email']; ?>" required>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                         <div class="col-sm-6">
                                        <label for="fullname">Guardian Full Name</label>
                                        <input type="text" class="form-control" id="g_fullname" name="g_fullname"
                                        placeholder="Enter Guardian full name" required value="<?php echo $memberDetails['student_guard']; ?>">
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-sm-6">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control" id="address" name="address"
                                                   placeholder="Enter address" value="<?php echo $memberDetails['address']; ?>" required>
                                        </div>
                                        <div class="col-sm-6">
                                           <label for="section">Section</label>
                                            <select class="form-control" id="section" value="" name="section" required>
                                                <option value="<?php echo $memberDetails['section']; ?>"><?php echo $memberDetails['section']; ?></option>
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
                                                 <option value="<?php echo $memberDetails['department']; ?>"><?php echo $memberDetails['department']; ?></option>
                                                   <?php
                                            $departmentQuery = "SELECT * FROM department";
                                            $departmentResult = $conn->query($departmentQuery);
                                           
                                            while ($row3 = $departmentResult->fetch_assoc()) {
                                              
                                                echo "<option value='".$row3['department']."'>".$row3['department']."</option>";
                                              }
                                            ?>
                                            </select>
                                        </div>
                                      
                                    </div>
                                    
                                    <div class="row mt-3">
                                    <div class="col-sm-6">
                                        <label for="photo">Member Photo</label>
                                        <input type="file" class="form-control" id="photo" name="photo">
                                        <small class="text-muted">Leave it blank if you don't want to change the photo.</small>
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
