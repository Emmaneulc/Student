<?php
include('includes/config.php');

$selectQuery = "SELECT * FROM section";
$result = $conn->query($selectQuery);

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$response = array('success' => false, 'message' => '');


if (isset($_POST['update'])) {
  $s_id   = $_POST['sec_id'];
  $s_name = $_POST['s_name'];

    $updateQuery = "UPDATE section SET section = '$s_name' WHERE id='$s_id' ";
      if ($conn->query($updateQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = 'Student Section Updated Successfully: ';
        
    } else {
        $response['message'] = 'Error: ' . $conn->error;
    }
}


if (isset($_POST['sub'])) {
    $section   = $_POST['section'];
  

    $insertQuery = "INSERT INTO section (section) VALUES ('$section')";
    
    if ($conn->query($insertQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = 'Student Section Added Successfully: ' . $section;
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

            <div class="row">
          <div class=" col-md-12">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="float:   right;margin-bottom:  10px;" >Add Section</button>
           
          </div>
        </div>
        <!-- Info boxes -->
        <div class="row">
        
        <div class="col-12">

        <div class="card">
    <div class="card-header">
        <h3 class="card-title">Section DataTable</h3>
    </div>

    <!-- /.card-header -->
    <div class="card-body">
 <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Section</th>
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
                    echo "<td>{$row['section']}</td>";
                    echo "<td>{$row['date_created']}</td>";
           
               
           
                    $counter++;

                
                ?>
        <td><a href="#editproduct<?php echo $row['id']; ?>" data-toggle="modal" class="btn btn-success"><i class="fas fa-edit"></i> Update</a>
           <?php echo "<button class='btn btn-danger' onclick='deleteMember({$row['id']})'><i class='fas fa-trash'></i> Delete</button>"; ?>
          <div class="modal fade" id="editproduct<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Update Section</h5>
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
                                          <label class="control-label">Section:</label>
                                      </div>
                                      <div class="col-md-9">
                                          <input type="hidden" name="sec_id" value="<?php echo $row['id']; ?>">
                                          <input type="text" class="form-control" value="<?php echo $row['section']; ?>" name="s_name" id="s_name">
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
        <h5 class="modal-title" id="exampleModalLabel">Add New Section</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Section:</label>
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
    function deleteMember(id) {
        if (confirm("Are you sure you want to delete this data?")) {
            window.location.href = 'delete_section.php?id=' + id;
        }
    }
</script>

</body>
</html>