<?php
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$response = array('success' => false, 'message' => '');
if (isset($_GET['id'])) {
    $memberId = $_GET['id'];

$selectQuery = "SELECT * FROM   members WHERE   id = '$memberId' ";
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

$selectQuery2 = "SELECT * FROM renew WHERE  member_id = '$memberId' ";
$result2 = $conn->query($selectQuery2);







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
                <th>#</th>
                <th>Type</th>
                <th>Violation</th>
                <th>Offense</th>
                <th>Sanction</th>
                <th>Action</th>
                     
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1;
            while($row_vio = $result2->fetch_assoc()){
$renewid = $row_vio['id'];
$vio_id = $row_vio['violation_id'];
$selectQuery1 = "SELECT DISTINCT * FROM violation WHERE id = '$vio_id' ";
$result1 = $conn->query($selectQuery1);

            while ($row1 = $result1->fetch_assoc()) {
              


                echo "<tr>";
                echo "<td>{$counter}</td>";
                echo "<td>{$row1['type_violation']}</td>";
                echo "<td>{$row1['violation']}</td>";
                echo "<td>{$row1['offense']}</td>";
                echo "<td>{$row1['sanction']}</td>";
               
       


       
                

                $counter++;
            
            ?>
<td><a href="#editproduct<?php echo $row1['id']; ?>" data-toggle="modal" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span> Send Report</a>
    <a href="print\cellmerging.php?ID=<?php echo $renewid; ?>" class="btn btn-info btn-sm"><i class="fas fa-file-pdf"></i> Print</a>
<div class="modal fade" id="editproduct<?php echo $row1['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
            <div class="modal-body">
                <div class="container-fluid">
                <form action="" method="POST">
                    <div class="form-group" style="margin-top:10px;">
                        <div class="row">
                            <div class="col-md-3" style="margin-top:7px;">
                                <label class="control-label">Student Name:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="hidden" name="vio_id" value="<?php echo $row1['id']; ?>">
                                <input type="hidden" name="member_id" value="<?php echo $memberDetails['id']; ?>">
                                <input type="text" class="form-control" value="<?php echo $memberDetails['fullname']; ?>" name="s_name" readonly>
                            </div>
                        </div>
                    </div>
                       <div class="form-group">
                        <div class="row">
                            <div class="col-md-3" style="margin-top:7px;">
                                <label class="control-label">Contact:</label>
                            </div>
                            <div class="col-md-9">
                             <select class="form-control" name="contact_info">
                                 <option value="<?php echo $memberDetails['email']; ?>"><?php echo $memberDetails['email']; ?></option>
                                 <option value="<?php echo $memberDetails['contact_number']; ?>"><?php echo $memberDetails['contact_number']; ?></option>
                             </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3" style="margin-top:7px;">
                                <label class="control-label">Violation:</label>
                            </div>
                            <div class="col-md-9">
                             <input type="text" class="form-control" value="<?php echo $row1['violation']; ?>" name="vio" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3" style="margin-top:7px;">
                                <label class="control-label">Frequency:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" value="<?php echo $row1['offense']; ?>" name="offe" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3" style="margin-top:7px;">
                                <label class="control-label">Message</label>
                            </div>
                            <div class="col-md-9">
                                     
                                    <textarea name="message_info1" class="form-control" id="message_info1" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
                <button type="submit" class="btn btn-success" ><span class="glyphicon glyphicon-edit"></span> Sent</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</td>
<tr>
        <?php
        //end of while
    }
         }
        ?>
        </tbody>
    </table>
</div>

    <!-- /.card-body -->
    <div class="card-header">
        <h3 class="card-title">Vilation Breakdown</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>id#</th>
                
                <th>Type</th>
                <th>Violation</th>
             
                <th>Frequency</th>
                     
            </tr>
        </thead>
        <tbody>
<?php

$sql = "SELECT * FROM renew where member_id = '$memberId'";
$result = $conn->query($sql);

// Check if data was retrieved successfully
if ($result->num_rows > 0) {
    // Array to store frequencies
    $frequencies = array();

    // Loop through data and count frequencies
    while ($row = $result->fetch_assoc()) {
        $value = $row['violation_id'];
        if (isset($frequencies[$value])) {
            $frequencies[$value]++;
        } else {
            $frequencies[$value] = 1;
        }
    }

    // Display or use frequencies as needed
    foreach ($frequencies as $value => $frequency) {
        $sql1 = "SELECT * FROM violation where id = '$value'";
        $result1 = $conn->query($sql1);
        $row13 = $result1->fetch_assoc();
        echo "<tr>";
         echo "<td>{$value}</td>";
         echo "<td>{$row13['type_violation']}</td>";
         echo "<td>{$row13['violation']}</td>";
                echo "<td>{$frequency}</td>";
        echo "</tr>";
    }
} else {
    echo "No data found.";
}

// Close connection
$conn->close();


?>

<tr>
        <?php
        //end of while
    
         
        ?>
        </tbody>
    </table>
</div>
</div>

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
