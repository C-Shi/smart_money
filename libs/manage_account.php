<?php 
  class Manage_Account {
    public function __construct($pdo){
      $this->pdo = $pdo;
    }

    public function delete_transaction($user_id, $transaction_id){
      $q = "DELETE FROM transaction WHERE id = ? AND user_id = ?;";
      $stmt = $this->pdo->prepare($q);
      $stmt->execute([$transaction_id, $user_id]);
      return True;
    }
  }
?>