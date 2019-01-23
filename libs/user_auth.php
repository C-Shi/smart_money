<?php 
  class User_Auth {
    function __construct($pdo){
      $this->pdo = $pdo;
    }
    public function LOGIN(){
      // check if there is a user
      if (isset($_POST['login'])) {
        $q_login = "SELECT * FROM user WHERE email = ?";
        $stmt = $this->pdo->prepare($q_login);
        $stmt->execute([$_POST['email']]);
        $found_user = $stmt->fetch();
  
        if ($_POST['password'] === $found_user['password']){
          session_start();
          $_SESSION['current_user_id'] = htmlentities($found_user['id']);
          $_SESSION['current_user_email'] = htmlentities($found_user['email']);
        }
        header('Location: /account');
      }
    }

    public function LOGOUT(){
      if(isset($_POST['logout'])){
        session_destroy();
        header('Location: /');
      }
    }
  }

?>