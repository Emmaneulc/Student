<?php
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$response = array('success' => false, 'message' => '');

$membershipTypesQuery = "SELECT * FROM violation";
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $violationTypeId = $_POST['membershipType'];
    $reportDate = date('Y-m-d');


    $membershipTypesQuery2 = "SELECT * FROM renew WHERE member_id='$memberId' and violation_id='$violationTypeId' and date_created='$reportDate' ";
    $membershipTypesResult2 = $conn->query($membershipTypesQuery2);
    $line_row = $membershipTypesResult2->num_rows;

    if($line_row != 0){
        $response['success'] = false;
     $response['message'] = 'Report Already Exists: ';  
    }else{
    $insertRenewQuery = "INSERT INTO renew (member_id, violation_id ,date_created) VALUES ($memberId, $violationTypeId, '$reportDate')";
    $insertRenewResult = $conn->query($insertRenewQuery);

    if ($insertRenewResult) {
        $response['success'] = true;
        $response['message'] = 'Violation Reported successfully.';
    } else {
        $response['message'] = 'Error updating membership or renewing: ' . $conn->error;
    }

  
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
                                <h3 class="card-title"><i class="fas fa-keyboard"></i> Report Student Form</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- Visit codeastro.com for more projects -->
                            <!-- form start -->
                            <form method="post" action="">
                            <input type="hidden" name="member_id" value="<?php echo $id; ?>">
                                <div class="card-body">
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <label for="fullname">Full Name</label>
                                    <input type="text" class="form-control" id="fullname" name="fullname"
                                        placeholder="Enter full name" required value="<?php echo $memberDetails['fullname']; ?>" disabled>
                                </div>
                                        <div class="col-sm-6">
                                            <label for="dob">Student Number</label>
                                            <input type="text" class="form-control" id="mm" name="mm" value="<?php echo $memberDetails['membership_number']; ?>" disabled>
                                        </div>
                                        
                                    </div>


                                    <div class="row mt-3">
                                    <div class="col-sm-6">
                                    <label for="membershipType">Violation type</label>
                                    <select class="form-control" id="membershipType" name="membershipType" required>
                                        <?php
                                        if ($membershipTypesResult) {
                                            while ($row = $membershipTypesResult->fetch_assoc()) {
                                                echo "<option value='{$row['id']}'>{$row['violation']} - {$row['offense']}</option>";
                                            }
                                        } else {
                                            echo "Error: " . $conn->error;
                                        }
                                        ?>
                                    </select>
                                </div>
                                  
                                       
                                    </div>

                                    <div class="row mt-3">
                                    <div class="col-sm-6">
                                        <label for="totalAmount">Frequency</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                
                                            </div>
                                            <input type="text" class="form-control" id="totalAmount" name="totalAmount" placeholder="Total Amount" readonly>
                                        </div>
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
    <!-- Visit codeastro.com for more projects -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php include('includes/main_footer.php');?>
</div>
<!-- ./wrapper -->

<?php include('includes/footer.php'); ?>

<script>
    $(document).ready(function () {
        function updateTotalAmount() {
            var membershipTypeAmount = $('#membershipType option:selected').text().split('-').pop();


            var totalAmount = membershipTypeAmount;

            $('#totalAmount').val(totalAmount);
        }

        $('#membershipType, #extend').change(updateTotalAmount);

        updateTotalAmount();
    });
</script>







</body>
</html>
