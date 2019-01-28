<?php 
  require "config/db.php";
  require "libs/user_auth.php";
  require "libs/manage_account.php";
  require "libs/manage_profile.php";
  # PDO query for prepare statment
  session_start();
  $user_auth = new User_Auth($pdo);
  $manager = new Manage_Account($pdo);
  $profile = new Manage_Profile($pdo);

  if (!isset($_SESSION['current_user_id'])){
    header('Location: /');
  }

  $user_id = $_SESSION['current_user_id'];
  $current_user = $user_auth->GET_USER($user_id);

  if(isset($_POST['update'])){
    $budget = $_POST['budget'];
    $avatar = $_POST['avatar'];
    $user_auth->update_user_budget($user_id, $budget);
    $user_auth->update_user_avatar($user_id, $avatar);
    header('Location: /account');
  }

  $user_sum = $profile->sum_all_transaction($user_id);
  $user_spent = $profile->spent_analytics($user_id);
  
?>

<?php include "inc/header.php" ?>
<div class="container-fluid bg-secondary" style="margin-bottom: 20px; padding: 10px;">
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <h3>User Profile</h3>
      </div>
    </div>
  </div>
</div>

<main class="container">

  <div class="row">
    <!-- profile picture -->
    <div class="col-md-4">
      <div class="card">
        <img src="<?php echo $current_user['avatar'];?>" class="card-img-top" alt="User Profile Image">
      </div>
    </div>
    <!-- profile info -->
    <div class="col-md-8">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link show active" data-toggle="tab" href="#profile">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link show" data-toggle="tab" href="#summary">Summary</a>
        </li>
      </ul>
    <!-- table area. -->
      <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active show" id="profile">
          <form action="" method="POST">
            <div class="alert alert-light" role="alert">
              Username: <?php echo $current_user['email']; ?>
            </div>
            <div class="form-group">
              <label>Monthly Budget</label>
              <input class="form-control" name="budget" type="number" value="<?php echo $current_user['budget']; ?>">
            </div>
            <div class="form-group">
              <label>Avatar URL</label>
                <input class="form-control" name="avatar" type="text" value="<?php echo $current_user['avatar']; ?>">
              </label>
            </div>
            <input type="submit" class="btn btn-success" name="update" value="Update" />
          </form>
        </div>
        <!-- summary detail block -->
        <div class="tab-pane fade" id="summary">
          <ul class="list-group">
            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
              Days You Have Been With Smart Money: 
              <span class="float-right"><?php echo $user_sum['days']?></span>
            </li>
            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
              Total Numbers of Transactions You Have Entered: 
              <span class="float-right"><?php echo $user_sum['num_transaction']?></span>
            </li>
            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
              Total Amount Spent Since Registered: 
              <span class="float-right"><?php echo '$'.round($user_sum['total_spent'])?></span>
            </li>
            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
              Average Daily Spent: 
              <span class="float-right"><?php echo '$'.round($user_spent['ave_daily_spent'])?></span>
            </li>
            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
              Average Daily Spent This Month: 
              <span class="float-right"><?php echo '$'.round($user_spent['ave_daily_spent_this_month'])?></span>
            </li>
            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
              Largest Single Transaction: 
              <span class="float-right"><?php echo '$'.round($user_spent['max_spent'])?></span>
            </li>
            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
              Largest Single Transaction This Month: 
              <span class="float-right"><?php echo '$'.round($user_spent['max_spent_this_month'])?></span>
            </li>
            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
              Largest Spending Category: 
              <span class="float-right"><?php echo $user_spent['category_name']?></span>
            </li>
          </ul>
        </div>
        <!-- end of summary detail block -->
      </div>
    </div>
  </div>
  <!-- end of row -->
</main>

