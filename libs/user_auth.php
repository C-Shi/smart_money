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
        $password_validation_error = $this->check_password_strength($password);
        if ($password_validation_error) {
          return $password_validation_error;
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $q_add_user = "INSERT INTO user (email, password) VALUE (? , ?)";
        $stmt = $this->pdo->prepare($q_add_user);
        $stmt->execute([$email, $hash]);
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
  
      $hash = $found_user['password'];
      if(password_verify($password, $hash)){
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

    public function update_user_budget($user_id, $budget){
      $q_budget = "UPDATE user SET budget = ? WHERE id = ?;";
      $stmt = $this->pdo->prepare($q_budget);
      $stmt->execute([$budget, $user_id]);
      return True;
    }

    public function update_user_avatar($user_id, $avatar){
      $q_avatar = "UPDATE user SET avatar = ? WHERE id = ?;";
      $stmt = $this->pdo->prepare($q_avatar);
      $stmt->execute([$avatar, $user_id]);
      return True;
    }

    public function verify_password_reset($email, $token) {
      $q = "SELECT password_reset_token, password_reset_token_expiry FROM user WHERE email = ?";
      $stmt = $this->pdo->prepare($q);
      $stmt->execute([$email]);
      $user = $stmt->fetch();
      if ($token != $user['password_reset_token']) {
        return false;
      }
      $now = date("Y-m-d H:i:s", time());
      if (var_dump($now > $user['password_reset_token_expiry'])) {
        return false;
      }
      return true;
      
    }

    public function check_password_strength($password) {
      if (strlen($password) < 6) {
        return 'Password must be at least 6 character';
      }
      
      if (!preg_match("#[0-9]+#", $password)) {
        return 'Password must contain at least one number';
      }

      if (!preg_match("#[a-z]+#", $password)) {
        return 'Password must contain at least one lowercase letter';
      }

      if(!preg_match("#[A-Z]+#", $password)) {
        return 'Password must contain at least one uppercase letter';
      }

      return false;
    }

    public function generate_reset_token($email) {
      $token = bin2hex(random_bytes(48));
      $token_expiry = date("Y-m-d H:i:s", time() + 3600000);
      $q_create_token = "UPDATE user SET password_reset_token = ?, password_reset_token_expiry = ? WHERE email = ?;";
      $stmt = $this->pdo->prepare($q_create_token);
      $stmt->execute([$token, $token_expiry, $email]);
      return $token;
    }

    public function update_password($email, $password) {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $q_reset_password = "UPDATE user SET password = ?, password_reset_token = NULL, password_reset_token_expiry = NULL WHERE email = ?;";
      $stmt = $this->pdo->prepare($q_reset_password);
      $stmt->execute([$hash, $email]);
      $q_check = "SELECT * FROM user WHERE email = ?;";
      $stmt = $this->pdo->prepare($q_check);
      $stmt->execute([$email]);
      $user = $stmt->fetch();
      return $user;
    }

  }

?>