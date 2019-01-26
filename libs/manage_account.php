<?php 
  class Manage_Account {
    public function __construct($pdo){
      $this->pdo = $pdo;
    }

    public function fetch_user_category($user_id){
      $q_user_cat = "SELECT name FROM user_category LEFT JOIN category ON user_category.category_id = category.id WHERE user_category.user_id = ?;";
      $stmt = $this->pdo->prepare($q_user_cat);
      $stmt->execute([$user_id]);
      $category_results = $stmt->fetchAll();
      return $category_results;
    }

  }
?>