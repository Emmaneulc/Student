<?php
include('includes/config.php');

$selectQuery = "SELECT * FROM department";
$result = $conn->query($selectQuery);

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$response = array('success' => false, 'message' => '');


if (isset($_POST['update'])) {
  $dep_id   = $_POST['dep_id'];
  $d_name = $_POST['d_name'];

    $updateQuery = "UPDATE department SET department = '$d_name' WHERE id='$dep_id' ";
      if ($conn->query($updateQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = 'Student Section Updated Successfully: ';
        
    } else {
        $response['message'] = 'Error: ' . $conn->error;
    }
}


if (isset($_POST['sub'])) {
    $department   = $_POST['department'];
  

    $insertQuery = "INSERT INTO department (department) VALUES ('$department')";
    
    if ($conn->query($insertQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = 'Student Department Added Successfully: ' . $section;
    } else {
        $response['message'] = 'Error: ' . $conn->error;
    }
}


?>

<!DOCTYPE html>
<html lang="en">
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
          <div class=" col-md-12">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="float:   right;margin-bottom:  10px;" >Add Department</button>
           
          </div>
        </div>
        <div class="row">
        <div class="col-12">
              <?php if ($response['success']): ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-check"></i> Success</h5>
                                <?php echo $response['message'];
                                 ?>
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
        <h3 class="card-title">Department Data Table</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Department</th>
                    <th>Date Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counter = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$counter}</td>";
                    echo "<td>{$row['department']}</td>";
                    echo "<td>{$row['date_created']}</td>";
           
               
           
                    $counter++;

                
                ?>
        <td><a href="#editproduct<?php echo $row['id']; ?>" data-toggle="modal" class="btn btn-success"><i class="fas fa-edit"></i> Update</a>
          <?php echo "<button class='btn btn-danger' onclick='deleteMembership({$row['id']})'><i class='fas fa-trash'></i> Delete</button>"; ?>
          <div class="modal fade" id="editproduct<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Update Department</h5>
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
                                          <label class="control-label">Department:</label>
                                      </div>
                                      <div class="col-md-9">
                                          <input type="hidden" name="dep_id" value="<?php echo $row['id']; ?>">
                                          <input type="text" class="form-control" value="<?php echo $row['department']; ?>" name="d_name" id="d_name">
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
                          <button type="submit" class="btn btn-success" name="update"><span class="glyphicon glyphicon-edit"></span> Update</button>
                          </form>
                      </div>
                  </div>
                  <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
          </div>
          </td>
            </tr>
               <?php
          }
            ?>
            </tbody>
         
        </table>
    </div>
    <!-- /.card-body -->
</div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

        </div>
        <!-- /.row -->

        
      </div><!--/. container-fluid -->

      <!-- Modal Start-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Department</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Department:</label>
            <input type="text" class="form-control" id="department" name="department" >
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="sub">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>
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

<script>
    function deleteMembership(id) {
        if (confirm("Are you sure you want to delete this data?")) {
            window.location.href = 'delete_department.php?id=' + id;
        }
    }
</script>

</body>
</html>