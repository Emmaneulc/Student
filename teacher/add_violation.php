<?php
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$response = array('success' => false, 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $offense = $_POST['offense'];
    $violation = $_POST['violation'];
    $offense_fre = $_POST['offense_fre'];
    $sanction = $_POST['sanction'];

    $insertQuery = "INSERT INTO violation (type_violation, violation, offense, sanction) VALUES ('$offense','$violation','$offense_fre','$sanction')";
    
    if ($conn->query($insertQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = 'Student violation added successfully!';
    } else {
        $response['message'] = 'Error: ' . $conn->error;
    }
}


?>

<?php include('includes/header.php');?>

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
        <!-- Info boxes -->
        <div class="row">
        
        <!-- left column --><!-- Visit codeastro.com for more projects -->
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
                <h3 class="card-title"><i class="fas fa-keyboard"></i> &nbsp Add Violation Data form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="">
                <div class="card-body">
                <div class="row">
                <div class="col-sm-6">
                                  <label for="department">Type of Offense</label>
                                            <select class="form-control" id="offense" name="offense" required>
                                                <option value="">----Select----</option>
                                                <option value="Minor Offense">Minor Offense</option>
                                                <option value="Major Offense">Major Offense</option>
                                                <option value="Grave Offense">Grave Offense</option>
                                            </select>
                                        </div>
                                  </div>
                <div class="row">
                                <div class="col-sm-6">
                                    <label for="membershipAmount">Violation</label>
                                    <textarea name="violation" class="form-control" id="violation" rows="5"></textarea>
                                </div>
                </div>
                  <div class="row">
                                <div class="col-sm-6">
                                   <label for="department">Fequency of Offense</label>
                                     <select class="form-control" id="offense_fre" name="offense_fre" required>
                                                <option value="">----Select----</option>
                                                <option value="First Offense">First Offense</option>
                                                <option value="Second Offense">Second Offense</option>
                                                <option value="Third Offense">Third Offense</option>
                                            </select>
                                </div>
                </div>
                   <div class="row">
                                <div class="col-sm-6">
                                   <label for="membershipAmount">Sanction</label>
                                    <textarea name="sanction" class="form-control" id="sanction" rows="5"></textarea> 
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
        <!-- Visit codeastro.com for more projects -->
        
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
</body>
</html>