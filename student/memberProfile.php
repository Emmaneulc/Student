<?php
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$response = array('success' => false, 'message' => '');
if (isset($_GET['id'])) {
    $memberId = $_GET['id'];

$selectQuery = "SELECT members.*, membership_types.type AS membership_type_name
                    FROM members
                    JOIN membership_types ON members.membership_type = membership_types.id
                    WHERE members.id = $memberId";
$result = $conn->query($selectQuery);
if ($result->num_rows > 0) {
        $memberDetails = $result->fetch_assoc();  
} else {
        header("Location: members_list.php");
        exit();
}
} else {
    header("Location: members_list.php");
    exit();
}
$selectQuery1 = "SELECT violation.*
                    FROM violation
                    JOIN renew ON violation.id = renew.violation_id
                    WHERE renew.member_id = $memberId";
$result1 = $conn->query($selectQuery1);



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $violationid = $_POST['vio_id'];
    $memberid = $_POST['member_id'];
    $message1 = $_POST['message_info1'];



    $insertQuery = "INSERT INTO vio_message (member_id, violation_id, message_info) 
                    VALUES ('$memberid', '$violationid', '$message1'        )";

if ($conn->query($insertQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = 'Report Sent Successfully';
    } else {
        $response['message'] = 'Error: ' . $conn->error;
    }
}

?>




<?php include('includes/header.php');?>

<style>
    @media print {
        body {
            background: none;
            padding: 0;
        }

        .btn * {
            visibility: hidden;
        }

        .print-button {
            display: none;
        }

        .card-tools {
            display: none;
        }

        .card {
            border: 2px solid #000;
            border-radius: 10px;
            margin: 20px;
            padding: 20px;
            box-shadow: 2px 2px 5px #888888;
        }

        .card-body {
            padding: 20px;
        }

        .row {
            display: flex;
            justify-content: space-between;
        }

        .col-md-5,
        .col-md-2 {
            width: 45%;
        }

        .img-thumbnail {
            width: 100px;
            height: 100px;
        }

    }
</style>


<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <?php include('includes/nav.php');?>

        <?php include('includes/sidebar.php');?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <?php include('includes/pagetitle.php');?>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    
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

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Student Profile</h3>
                            <!-- Add Print Button -->
                            <div class="card-tools">
                            <!--Insert Card Subtitle -->
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <p><strong>Student Number:</strong> <?php echo $memberDetails['membership_number']; ?></p>
                                    <p><strong>Full Name:</strong> <?php echo $memberDetails['fullname']; ?></p>
                                    <p><strong>Date of Birth:</strong> <?php echo $memberDetails['dob']; ?></p>
                                    <p><strong>Gender:</strong> <?php echo $memberDetails['gender']; ?></p>
                                    <p><strong>Contact Number:</strong> <?php echo $memberDetails['contact_number']; ?></p>
                                    <p><strong>Email:</strong> <?php echo $memberDetails['email']; ?></p>
                                </div>
                                <div class="col-md-5">
                                    <p><strong>Address:</strong> <?php echo $memberDetails['address']; ?></p>
                                    <p><strong>Section:</strong> <?php echo $memberDetails['section']; ?></p>
                                    <p><strong>Department:</strong> <?php echo $memberDetails['department']; ?></p>
                                  
                                   
                                    
                                </div>
                                <div class="col-md-2">
                                <?php
                                if (!empty($memberDetails['photo'])) {
                                    $photoPath = 'uploads/member_photos/' . $memberDetails['photo'];
                                    echo '<img src="' . $photoPath . '" class="img-thumbnail" alt="Member Photo">';
                                } else {
                                    echo '<p>No photo available</p>';
                                }
                                ?>
                                </div>
                                

                            </div>
                        </div>

                    </div>
                    <!-- End Member Profile Card -->
                </div><!--/. container-fluid -->

                 <div class="container-fluid">
        <!-- Info boxes -->
        <!-- Visit codeastro.com for more projects -->
        <div class="row">
        
        <div class="col-12">

        <div class="card">
    <div class="card-header">
        <h3 class="card-title">Student Violation Report</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Type</th>
                <th>Violation</th>
                <th>Offense</th>
                <th>Sanction</th>
          
                     
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1;
            while ($row1 = $result1->fetch_assoc()) {
              


                echo "<tr>";
                echo "<td>{$row1['type_violation']}</td>";
                echo "<td>{$row1['violation']}</td>";
                echo "<td>{$row1['offense']}</td>";
                echo "<td>{$row1['sanction']}</td>";
               
       


       
                

                $counter++;
            
            ?>

<tr>
        <?php
        //end of while
         }
        ?>
        </tbody>
    </table>
</div>

    <!-- /.card-body -->
</div>
<!-- Visit codeastro.com for more projects -->
            <!-- /.card -->
          </div>
          <!-- /.col -->

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

    <?php include('includes/footer.php');?>
    <script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

    <!-- JavaScript to handle printing -->
    <script>
        function printMembershipCard() {
            window.print();
        }
    </script>

</body>
</html>
