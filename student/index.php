<?php
include('includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
       
        $password = $_POST['password'];

        if (empty($password)) {
            $error_message = "Email and password are required!";
        } else {
            $hashed_password = $password;

            $sql = "SELECT * FROM members WHERE membership_number = '$hashed_password'";
            $result = $conn->query($sql);

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();

                 $_SESSION['user_id'] = $row['id'];
                 $id = $row['id'];
                header("Location: memberProfile.php?id='".$id."'");
                exit();
            } else {
                $error_message = "Invalid email or password!";
            }
        }
    }
}
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SVM System</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->

  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page" style="background-image: url('images/login_bg.jfif');background-size: cover;">
<div class="login-box">
  <div class="login-logo" style="background-color: rgba(0,0,0,0.7);">
    <a href="" style="color: #fff;"><b>Student Violation Management</b> System</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Log in to start your session as student</p>

      <?php
            if (isset($error_message)) {
            echo '<div class="alert alert-danger">' . $error_message . '</div>';
            }
        ?>

      <form action="" method="POST">
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" autofocus="true">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="login" class="btn btn-success btn-block">Log In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>

</html>