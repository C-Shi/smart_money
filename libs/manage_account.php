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

    public function get_recent_transaction($user_id){
      $q_transaction = 'SELECT * FROM transaction 
                        WHERE user_id = ? AND YEAR(date) = YEAR(CURRENT_DATE) AND 
                        MONTH(date) = MONTH(CURRENT_DATE) ORDER BY date DESC LIMIT 15';
      $stmt = $this->pdo->prepare($q_transaction);
      $stmt->execute([$user_id]);
      return $stmt->fetchAll();
    }

    public function count_transaction_by_category($user_id){
      $q_get_count = "SELECT category.name, COUNT(*) AS count FROM transaction 
                      LEFT JOIN category ON category.id = transaction.category_id 
                      WHERE user_id = ? GROUP BY category_id;";
      $stmt = $this->pdo->prepare($q_get_count);
      $stmt->execute([$user_id]);
      return $stmt->fetchAll();
    }

    public function add_new_category($user_id, $category){
      $q_check_cat_exist = "SELECT * FROM category WHERE name = ?;";
      $stmt = $this->pdo->prepare($q_check_cat_exist);
      $stmt->execute([$category]);
      $found_cat = $stmt->fetch();
      // if do not find, meaning this is new category for all people
      
      if (!isset($found_cat['name'])){
        $add_new_cat = "INSERT INTO category (name) VALUES (?);";
        $stmt = $this->pdo->prepare($add_new_cat);
        $stmt->execute([$category]);
      }
      // get cat id
      $q_get_cat_id = "SELECT * FROM category WHERE name = ?;";
      $stmt = $this->pdo->prepare($q_get_cat_id);
      $stmt->execute([$category]);
      $found_category = $stmt->fetch();
      $category_id = $found_category['id'];
      $q_add_user_cat_link = "INSERT INTO user_category (user_id, category_id) VALUES (?, ?);";
      $stmt = $this->pdo->prepare($q_add_user_cat_link);
      $stmt->execute([$user_id, $category_id]);

      return True;
    }

    public function add_transaction($user_id, $category, $amount){
      $q_get_cat_id = "SELECT * FROM category WHERE name = ?;";
      $stmt = $this->pdo->prepare($q_get_cat_id);
      $stmt->execute([$category]);
      $found_category = $stmt->fetch();
      $category_id = $found_category['id'];

      $q_add_transaction = "INSERT INTO transaction (user_id, category_id, amount) VALUES (?, ?, ?);";
      $stmt = $this->pdo->prepare($q_add_transaction);
      $stmt->execute([$user_id, $category_id, $amount]);
      return True;
    }

    public function delete_transaction($user_id, $transaction_id){
      $q = "DELETE FROM transaction WHERE id = ? AND user_id = ?;";
      $stmt = $this->pdo->prepare($q);
      $stmt->execute([$transaction_id, $user_id]);
      return True;
    }

    public function get_this_month_spent($user_id){
      $q_total = "SELECT SUM(amount) AS total FROM transaction 
                  WHERE user_id = ? AND 
                  YEAR(date) = YEAR(CURRENT_DATE) AND 
                  MONTH(date) = MONTH(CURRENT_DATE);";
      $stmt = $this->pdo->prepare($q_total);
      $stmt->execute([$user_id]);
      return $stmt->fetch();
    }
  }
?>