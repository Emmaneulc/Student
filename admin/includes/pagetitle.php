<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <?php
                
                if (strpos($_SERVER['REQUEST_URI'], 'add_members.php') !== false) {
                    $pageTitle = 'Add Student Data';
                } elseif (strpos($_SERVER['REQUEST_URI'], 'view_violation.php') !== false) {
                    $pageTitle = 'Violation Data Management';
                }  elseif (strpos($_SERVER['REQUEST_URI'], 'student_violation.php') !== false) {
                    $pageTitle = 'Student Violation Report';
                } elseif (strpos($_SERVER['REQUEST_URI'], 'edit_member.php') !== false) {
                  $pageTitle = 'Edit Members';
                } elseif (strpos($_SERVER['REQUEST_URI'], 'edit_violation.php') !== false) {
                  $pageTitle = 'Edit Membership Type';
                } elseif (strpos($_SERVER['REQUEST_URI'], 'report_violation.php') !== false) {
                  $pageTitle = 'Violation Report';
                } elseif (strpos($_SERVER['REQUEST_URI'], 'manage_members.php') !== false) {
                  $pageTitle = 'Manage Students';
                } elseif (strpos($_SERVER['REQUEST_URI'], 'memberProfile.php') !== false) {
                  $pageTitle = 'Student Profile';
                } elseif (strpos($_SERVER['REQUEST_URI'], 'print_membership_card.php') !== false) {
                  $pageTitle = 'Print Membership';
                } elseif (strpos($_SERVER['REQUEST_URI'], 'student_vio_report.php') !== false) {
                  $pageTitle = 'Student Violation Report';
                }  elseif (strpos($_SERVER['REQUEST_URI'], 'vio_data_report.php') !== false) {
                  $pageTitle = 'Violation Data Report';
                }elseif (strpos($_SERVER['REQUEST_URI'], 'report.php') !== false) {
                  $pageTitle = 'Student Data Report';
                } elseif (strpos($_SERVER['REQUEST_URI'], 'settings.php') !== false) {
                  $pageTitle = 'Settings';
                } elseif (strpos($_SERVER['REQUEST_URI'], 'add_violation.php') !== false) {
                  $pageTitle = 'Add Violation Data';
                } elseif (strpos($_SERVER['REQUEST_URI'], 'dashboard.php') !== false) {
                  $pageTitle = 'Dashboard';
                }elseif (strpos($_SERVER['REQUEST_URI'], 'section.php') !== false) {
                  $pageTitle = 'Student Section';
                }elseif (strpos($_SERVER['REQUEST_URI'], 'department.php') !== false) {
                  $pageTitle = 'Student Department';
                }elseif (strpos($_SERVER['REQUEST_URI'], 'teacher.php') !== false) {
                  $pageTitle = 'Tearcher/Professor';
                }
                
                echo '<h1 class="m-0 text-dark">' . $pageTitle . '</h1>';
                ?>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active"><?php echo $pageTitle; ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
