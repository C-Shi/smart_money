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

  }
?>