<?php 
  class User_Auth {
    public function __construct($pdo){
      $this->pdo = $pdo;
    }

    public function REGISTER($email, $password){
      $q_validate = "SELECT * FROM user WHERE email = ?";
      $stmt = $this->pdo->prepare($q_validate);
      $stmt->execute([$email]);
      $found_user = $stmt->fetch();
      if (isset($found_user['id'])){
        echo "<script>alert('user exist! Please login')</script>";
        return FALSE;
      } else {
        $q_add_user = "INSERT INTO user (email, password) VALUE (? , ?)";
        $stmt = $this->pdo->prepare($q_add_user);
        $stmt->execute([$email, $password]);
        $this->LOGIN($email, $password);
        return TRUE;
      }
    }

    public function LOGIN($email, $password){
      // check if there is a user
      $q_login = "SELECT * FROM user WHERE email = ?";
        $stmt = $this->pdo->prepare($q_login);
        $stmt->execute([$email]);
        $found_user = $stmt->fetch();
  
      if ($password === $found_user['password']){
        session_start();
        $_SESSION['current_user_id'] = htmlentities($found_user['id']);
        $_SESSION['current_user_email'] = htmlentities($found_user['email']);
      }
      header('Location: /account');
    }

    public function GET_USER($user_id){
      $q_user = "SELECT * FROM user WHERE id = ?;";
      $stmt = $this->pdo->prepare($q_user);
      $stmt->execute([$user_id]);
      return $stmt->fetch();
    }

    public function LOGOUT(){
      if(isset($_POST['logout'])){
        session_destroy();
        header('Location: /');
      }
    }
  }

?>