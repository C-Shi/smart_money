<?php 
  require 'config/db.php';
  require 'libs/user_auth.php';

  session_start();
  if($_SESSION['current_user_id']) {
    header['Location: /account'];
  }

  // handle reset post request
  if(isset($_POST['email'])) {
    echo 'Hi';
    unset($_POST['email']);
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
        <form action="/forget" method="POST" id="form">
          <div class="form-group">
            <div class="alert alert-info" role="alert">Password is reset through reset token. A password reset link will be sent to your email. Please complete the reset process within an hour. Otherwise your reset token will expire</div>
          </div>
          <div class="form-group">
            <label>Email:</label>
            <input type="text" class="form-control" placeholder="Your Email" name="email">
          </div>
          <button class="btn btn-block btn-primary">Reset Password</button>
        </form>
      </div>
    </div>

    <script>
      $('#form').on('submit', function(e){
        e.preventDefault();
        var email = $("#form input[name='email']").val();
        $.post({
          url: '/forget',
          data: {email: email}
        })
        .done(function(response){
          console.log('hi')
        })
        .fail(function(respnose, status, xhr){

        })
      })
    </script>
  </body>
</html>
