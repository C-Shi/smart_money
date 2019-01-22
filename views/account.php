<?php 
  include "inc/header.php"
?>

<div class="container-fluid bg-secondary" style="margin-bottom: 20px; padding: 10px;">
  <div class="container">
    <div class="row">
      <div class="col-md-10">
        <h3>Dashboard</h3>
      </div>
      <div class="col-md-2">
        <button type="button" class="btn btn-warning">Add Tranaction</button>
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
            <col span="1" style="width: 60%;" />
            <col span="1" style="width: 20%;" />
          </colgroup>
          <thead>
            <tr>
              <th scope="col">Date</th>
              <th scope="col">Category</th>
              <th scope="col">Amount</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td scope="row">Active</td>
              <td>Column content</td>
              <td>Column content</td>
            </tr>
            <tr>
              <td scope="row">Active</td>
              <td>Column content</td>
              <td>Column content</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  <!-- end of recent transaction section -->
  </div>
</main>