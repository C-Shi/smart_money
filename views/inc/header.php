<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" href="https://bootswatch.com/4/minty/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

  <style>
    .nav-link-unchanged::after {
      content: '';
      width: 100%; 
      height: 3px;
      display: block;
      visibility: hidden;
    }

    .nav-link-hover::after{
      content: '';
      width: 0; 
      height: 3px;
      display: block;
      background: #fff;
      transition: width .2s ease;
      -webkit-transition: width .2s ease;
    }
    
    .nav-link-hover:hover::after{
      width: 100%;
      left: 0;
      background: #fff;
    }
  </style>

</head>
<body>
  <!-- navigation bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand nav-link-unchanged" href="#">Smart Money</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link nav-link-hover" href="/account">Account</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link nav-link-hover" href="/profile">Profile</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link nav-link-hover" href="/support">Support</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0" method="POST" action="/account">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item"id="user" data-user-id="<?php echo $_SESSION['current_user_id'] ?>">Welcome! <?php echo $_SESSION['current_user_email']?></li>
        </ul>
        &nbsp;
        <input class="btn btn-secondary my-2 my-sm-0" type="submit" value="Logout" name="logout">
      </form>
    </div>
  </nav>
  <!-- end of navigation bar -->