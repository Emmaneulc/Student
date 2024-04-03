<?php
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fromDate = $_POST['fromDate'];
    $toDate = $_POST['toDate'];

    $reportQuery = "SELECT * from renew WHERE date_created BETWEEN '$fromDate' and '$toDate'  ";
    $reportResult = $conn->query($reportQuery);
}

?>

<?php include('includes/header.php');?>
<style>
    @media print {
        form {
            display: none;
        }

        .print-button {
            display: none;
        }
    }
</style>


<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <?php include('includes/nav.php');?>
  <?php include('includes/sidebar.php');?>
  
  <div class="content-wrapper">
    <?php include('includes/pagetitle.php');?>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-keyboard"></i> Student Violation Report</h3>
              </div>
              
              <form method="post" action="">
                <div class="card-body">
                  <div class="form-group">
                    <label for="fromDate">From Date:</label>
                    <input type="date" id="fromDate" name="fromDate" class="form-control" required>
                  </div>

                  <div class="form-group">
                    <label for="toDate">To Date:</label>
                    <input type="date" id="toDate" name="toDate" class="form-control" required>
                  </div>

                  <button type="submit" class="btn btn-success">Generate Report</button>
                </div>
              </form>
              
              <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                  if ($reportResult->num_rows > 0) {
                    echo '<div class="card-body">';
                    echo '<table class="table table-bordered table-striped">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>Student Number</th>';
                    echo '<th>Full Name</th>';
                    echo '<th>Violation</th>';
                    echo '<th>Offense</th>';
                    echo '<th>Sanction</th>';
                
                 
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    
                    while ($row = $reportResult->fetch_assoc()) {

                          $reportQuery1 = "SELECT * from members WHERE id = '".$row['member_id']."' ";
                          $reportResult1 = $conn->query($reportQuery1);

                    while ($row1 = $reportResult1->fetch_assoc()) {

                          $reportQuery2 = "SELECT * from violation WHERE id = '".$row['violation_id']."' ";
                          $reportResult2 = $conn->query($reportQuery2);

                    while ($row2 = $reportResult2->fetch_assoc()) {                    
                      echo '<tr>';
                      echo '<td>' . $row1['membership_number'] . '</td>';
                      echo '<td>' . $row1['fullname'] . '</td>';
                      echo '<td>' . $row2['violation'] . '</td>';
                      echo '<td>' . $row2['offense'] . '</td>';
                      echo '<td>' . $row2['sanction'] . '</td>';
                      echo '</tr>';
                        }
                     }

                  }

                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';

                    echo '<div class="card-footer">';
                    echo '<button type="button" class="btn btn-primary print-button" onclick="printReport()"><i class="fas fa-print"></i> Print Report</button>';
                    echo '</div>';
                  } else {
                    echo '<div class="card-body">';
                    echo '<p>No Data Found.</p>';
                    echo '</div>';
              

                  
                }
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <aside class="control-sidebar control-sidebar-dark">
  </aside>

   <?php include('includes/main_footer.php');?>
</div>

<?php include('includes/footer.php');?>

<script>
function printReport() {
    window.print();
}
</script>

</body>
</html>
