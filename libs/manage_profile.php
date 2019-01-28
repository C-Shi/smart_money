<?php 
  class Manage_Profile {
    public function __construct($pdo){
      $this->pdo = $pdo;
    }

    public function sum_all_transaction($user_id){
      $q_sum = "SELECT SUM(transaction.amount) AS total_spent, 
                COUNT(transaction.amount) AS num_transaction, 
                DATEDIFF(CURRENT_TIMESTAMP, user.created_at) AS days 
                FROM transaction JOIN user ON user.id = transaction.user_id 
                WHERE user_id = ?;";
      $stmt = $this->pdo->prepare($q_sum);
      $stmt->execute([$user_id]);
      return $stmt->fetch();
    }

    public function spent_analytics($user_id){
      $q_analytics = "SELECT MAX(amount) AS 'max_spent',
            SUM(amount)/DATEDIFF(CURRENT_TIMESTAMP,MIN(date)) AS ave_daily_spent
            FROM transaction WHERE user_id = ?;";
      $stmt = $this->pdo->prepare($q_analytics);
      $stmt->execute([$user_id]);
      $analytics = $stmt->fetch();
      $q_this_month = "SELECT MAX(amount) AS 'max_spent_this_month' ,
                       SUM(amount)/DATEDIFF(CURRENT_TIMESTAMP,MIN(date)) AS ave_daily_spent_this_month
                       FROM transaction 
                       WHERE user_id = ? AND YEAR(date) = YEAR(CURRENT_DATE) AND MONTH(date) = MONTH(CURRENT_DATE);";
      $stmt = $this->pdo->prepare($q_this_month);
      $stmt->execute([$user_id]);
      $analytics = array_merge($analytics, $stmt->fetch());
      $q_largest_category = "SELECT name as category_name 
                             FROM transaction 
                             LEFT JOIN category ON transaction.category_id = category.id 
                             WHERE user_id = ? GROUP BY category_id ORDER BY SUM(amount) DESC LIMIT 1;";
      $stmt = $this->pdo->prepare($q_largest_category);
      $stmt->execute([$user_id]);    
      $analytics = array_merge($analytics, $stmt->fetch());
      return $analytics;
    }
  }

?>