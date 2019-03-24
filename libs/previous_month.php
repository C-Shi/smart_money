<?php 
  require "../config/db.php";

  $minus_month = $_REQUEST['minus'];
  $user_id = $_REQUEST['userId'];
  $last_year = $_REQUEST['lastYear'];
  $year_diff = $last_year == 'true' ? 1 : 0;
 

  $q_sum = "SELECT category.name, transaction.id, transaction.amount, transaction.date FROM transaction INNER JOIN category ON transaction.category_id = category.id 
  WHERE MONTH(NOW() - INTERVAL ? MONTH) = MONTH(transaction.date)
  AND YEAR(transaction.date) = YEAR(NOW()) - ?
  AND transaction.user_id = ?";

  // $q_sum = "SELECT * FROM transaction WHERE NOW() - INTERVAL 1 MONTH > transaction.date";


  $stmt = $pdo->prepare($q_sum);
  $stmt->execute([$minus_month, $year_diff, $user_id]);

  $result = $stmt->fetchAll();

  echo json_encode($result)


?>