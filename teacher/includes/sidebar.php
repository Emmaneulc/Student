<?php
// $pages = array(
//     'dashboard.php',
//     'members_list.php',
//     'add_type.php',
//     'view_type.php'
//     // Add other page names here
// );

$current_page = basename($_SERVER['PHP_SELF']);

$countQuery = "SELECT COUNT(*) as total_types FROM membership_types";
$countResult = $conn->query($countQuery);

if ($countResult && $countResult->num_rows > 0) {
    $totalCount = $countResult->fetch_assoc()['total_types'];
} else {
    $totalCount = 0;
}
?>
 
 
 <!-- Main Sidebar Container -->
 <aside class="main-sidebar  elevation-4" style="background-color: #CCCCCC;" >
    <!-- Brand Logo -->
    <a href="" class="brand-link">
    <img src="uploads\member_photos\logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">

    <span class="brand-text font-weight-heavy" style="color: #8B0000"> <?php echo getSystemName(); ?></span>
</a>

<?php
function getSystemName()
{
    global $conn;

    $systemNameQuery = "SELECT system_name FROM settings";
    $systemNameResult = $conn->query($systemNameQuery);

    if ($systemNameResult->num_rows > 0) {
        $systemNameRow = $systemNameResult->fetch_assoc();
        return $systemNameRow['system_name'];
    } else {
        return 'Trex';
    }
}

function getLogoUrl()
{
    global $conn;

    $logoQuery = "SELECT logo FROM settings";
    $logoResult = $conn->query($logoQuery);

    if ($logoResult->num_rows > 0) {
        $logoRow = $logoResult->fetch_assoc();
        return $logoRow['logo'];
    } else {
        return 'dist/img/AdminLTELogo.png';
    }
}
?>

    <!-- Sidebar -->
    <div class="sidebar" style="background-color:  #FFFFCC;  " >
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img src="dist/img/2382414.png" class="img-circle elevation-2" alt="User Image">        </div>
        <div class="info" style="color:#8B0000;">
          <p>CIC Teacher</p>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         
          <li class="nav-item">
            <a href="report_violation.php" class="nav-link <?php echo ($current_page == 'report_violation.php' || $current_page == 'student_violation.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-clipboard-list"></i>
              <p>Student Report Violation</p>
            </a>
          </li>

 
          <li class="nav-item">
            <a href="logout.php" class="nav-link <?php echo ($current_page == 'logout.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-power-off"></i>
              <p>Logout</p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>