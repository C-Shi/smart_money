<?php 
    require 'config/db.php';
    require 'libs/user_auth.php';
  
    $user_auth = new USER_AUTH($pdo);

    session_start();
    if($_SESSION['current_user_id']){
      header('Location: /account');
    }

    if (isset($_POST['newpassword'])) {
      $pasword = $_POST['newpassword'];
      // check if password confirmation is completed
      if ($_POST['newpassword'] != $_POST['newpassword2']) {
        header("HTTP/1.1 500 Internal Server Error");
        echo "Password Does Not Match";
        exit(0);
      } 
      // check if passwor strength valid
      if (!$user_auth->check_password_length($password)) {
        header('HTTP/1.1 500 Internal Server Error');
        echo $user_auth->check_password_length($password);
        exit(0);
      }

      
    }
?>

<html>
  <head>
    <link rel="stylesheet" href="https://bootswatch.com/4/minty/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script
    src="https://code.jquery.com/jquery-3.3.1.js"
    integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  </head>

  <body>
    <div class="container">
      <div class="col-lg-8 mx-auto">
        <form method="POST" action="/reset">
          <div class="form-group">
            <label>Email: </label>
            <input type="email" name="email" class="form-control" placeholder="your email">
          </div>
          <div class="form-group">
            <label>Reset Token: </label>
            <input type="text" class="form-control" name="token" placeholder="Enter 48 digits password reset token">
          </div>
          <div class="form-group">
            <label>New Password: </label>
            <input type="password" name="newpassword" placeholder="*******" class="form-control">
            <label>Confirm New Password: </label>
            <input type="password" name="newpassword2" placeholder="*******" class="form-control">
          </div>
          <button class="btn btn-sm btn-success">Change Password</button>
          <a href="/" class="btn btn-sm btn-secondary">Go Back</a>
        </form>
      </div>
    </div>
  </body>
</html>