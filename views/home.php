<?php 
  require 'config/db.php';
  require 'libs/user_auth.php';

  $user_auth = new USER_AUTH($pdo);

  if (isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_auth->LOGIN($email, $password);
  }
  if (isset($_POST['register']) && filter_var($_POST['new_email'], FILTER_VALIDATE_EMAIL)){
    $new_email = $_POST['new_email'];
    $new_password = $_POST['new_password'];
    $register_state = $user_auth->REGISTER($new_email, $new_password);
    if (!$register_state){
      unset($_POST['new_email']);
      unset($_POST['new_password']);
    }
  }
?>


<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" href="https://bootswatch.com/4/minty/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</head>
<body>
  <!-- navigation bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="/">Smart Money</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav mr-auto">
      </ul>
      <form class="form-inline my-2 my-lg-0" method="POST" action="/">
        <label><strong>Email: &nbsp;</strong></label>
        <input class="form-control mr-sm-2" type="email" name="email" placeholder="Email">
        <label><strong>Password: &nbsp;</strong></label>
        <input class="form-control mr-sm-2" type="password" name="password" placeholder="******">
        <input class="btn btn-secondary my-2 my-sm-0" type="submit" value="Login" name="login">
      </form>
    </div>
  </nav>
  <!-- end of navigation bar -->
  <main class="container">
    <div class="row">
      <!-- left intro to app page -->
      <div class="col-md-6">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Id velit ut tortor pretium viverra suspendisse potenti nullam ac. Integer vitae justo eget magna fermentum iaculis. Sed felis eget velit aliquet sagittis. Elementum sagittis vitae et leo duis ut diam quam. Tristique sollicitudin nibh sit amet commodo nulla facilisi. Aliquam nulla facilisi cras fermentum odio eu. Curabitur gravida arcu ac tortor dignissim. Arcu non odio euismod lacinia at quis risus sed. Dui ut ornare lectus sit amet est placerat in egestas. Sed arcu non odio euismod lacinia at quis. Morbi tristique senectus et netus. Blandit cursus risus at ultrices mi tempus imperdiet nulla. Vel orci porta non pulvinar neque laoreet suspendisse interdum. Id semper risus in hendrerit gravida. Volutpat blandit aliquam etiam erat velit scelerisque. Massa sed elementum tempus egestas sed sed risus pretium quam. Egestas congue quisque egestas diam. Massa sapien faucibus et molestie ac.

      </div>
      <!-- right sign up or login form -->
      <div class="col-md-6">
        <form method="POST" action="/">
          <fieldset>
            <legend>Register</legend>
            <div class="form-group">
              <label>Email address</label>
              <input type="email" class="form-control" name="new_email" aria-describedby="emailHelp" placeholder="Enter email">
              <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" name="new_password" placeholder="Password">
            </div>
            <input type="submit" class="btn btn-primary" value="Register" name="register">
          </fieldset>
        </form>
        <!-- end of register form -->
      </div>
    </div>
  </main>
</body>
</html>