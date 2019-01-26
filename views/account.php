<?php 
  require "config/db.php";
  require "libs/user_auth.php";
  require "libs/manage_account.php";
  # PDO query for prepare statment
  session_start();

  if(isset($_SESSION['current_user_id'])){
    // fetch all user information
    $user_id = $_SESSION['current_user_id'];
    $q = 'SELECT * FROM transaction WHERE user_id = ? ORDER BY date DESC';
    $stmt = $pdo->prepare($q);
    $stmt->execute([$user_id]);
    $results = $stmt->fetchAll();

    // fetch all user category
    $manager = new Manage_Account($pdo);
    $categories = $manager->fetch_user_category($user_id);

    // listen to add transaction request
    if(isset($_POST['add'])){
      // add new category if exist
      $amount = $_POST['amount'];
      if(isset($_POST['newCategory'])){
        $category = strtolower($_POST['newCategory']);
        $manager->add_new_category($user_id, $category);
      } else {
        $category = strtolower($_POST['category']);
      };
      $manager->add_transaction($user_id, $category, $amount);
      header('Location: /account');
    }
    // listen to delete transaction request
    if(isset($_POST['delete'])){
      $transaction_id = $_POST['transaction_id'];
      $manager->delete_transaction($user_id, $transaction_id);
      header('Location: /account');
    }
  } else {
    // no current user cannot access account page;
    header('Location: /');
  }

  $user_auth = new User_Auth($pdo);
  $user_auth->LOGOUT();
?>

<?php include "inc/header.php" ?>

<div class="container-fluid bg-secondary" style="margin-bottom: 20px; padding: 10px;">
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <h3>Dashboard</h3>
      </div>
      <div class="col-md-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#add-transaction">
        <i class="fas fa-plus"></i> New Transaction
        </button>
      </div>
    </div>
  </div>

</div>

<main class="container">
  <div class="row">
  <!-- dashboard section -->
    <section class="col-md-3">
    <div class="card mb-3">
      <h5 class="card-header bg-primary text-white">Dash Board</h5>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">Profile</li>
        <li class="list-group-item">Category <span class="badge badge-dark"><i class="fas fa-angle-double-down"></i></span></li>
        <li class="list-group-item">
          Monthly Spend
          <div class="progress">
            <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </li>
      </ul>
    </div>
    </section>
  <!-- end of dashboard section -->

  <!-- Recent transction section -->
    <section class="col-md-9">
      <div class="card mb-3">
        <h5 class="card-header bg-primary text-white">Recent Transaction</h5>
        <table class="table table-hover">
          <colgroup>
            <col span="1" style="width: 20%;" />
            <col span="1" style="width: 50%;" />
            <col span="1" style="width: 20%;" />
            <col span="1" style="width: 10%;" />
          </colgroup>
          <thead>
            <tr>
              <th scope="col">Date</th>
              <th scope="col">Category</th>
              <th scope="col">Amount</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($results as $result): ?>
              <tr>
                <td scope="row"><?php echo explode(' ', $result['date'])[0]?></td>
                <td>
                  <?php
                    $cat_q = 'SELECT name FROM category WHERE id = ' . $result['category_id'];
                    $stmt_cat = $pdo->query($cat_q);
                    $cat_name = $stmt_cat->fetch();
                    echo $cat_name['name'];
                  ?>
                </td>
                <td><?php echo $result['amount'] ?></td>
                <td>
                  <form action="/account" method="post">
                    <input type="hidden" name="transaction_id" value="<?php echo $result['id']; ?>" readonly>
                    <input type="submit" name="delete" value="Delete" class="btn btn-sm btn-danger">
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>
  <!-- end of recent transaction section -->
  </div>
</main>

<!-- Modal -->
<div class="modal fade" id="add-transaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Transaction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
          <div id="new-form"> 
            <div class="form-group">
              <label>Category</label>
              <select class="form-control" name="category" id="new-transaction-option">
                <?php foreach($categories as $category): ?>
                  <option><?php echo $category['name'] ?></option>
                <?php endforeach ?>
                <option>New</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label>Amount ($)</label>
            <input type="number" class="form-control" min="0.01" step="0.01" name="amount">
          </div>
          <input type="submit" name="add" value="Add Transaction" class="btn btn-sm btn-success">
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  var select = document.getElementById("new-transaction-option");
  select.addEventListener('change', function(e){
    if(e.target.value === 'New'){
      var div = document.createElement('div');
      div.setAttribute('class', 'form-group');
      div.setAttribute('id', 'newCategoryDiv')
      var label = document.createElement('label');
      label.textContent = 'New Category';
      var input = document.createElement('input');
      input.setAttribute('type', 'text');
      input.setAttribute('class', 'form-control');
      input.setAttribute('name', 'newCategory');
      input.setAttribute('placeholder', 'New Category');
      div.appendChild(label);
      div.appendChild(input);
      document.getElementById('new-form').appendChild(div);
    } else {
      var newCatDiv = document.getElementById('newCategoryDiv');
      document.getElementById('new-form').removeChild(newCatDiv);
    }
  })
</script>