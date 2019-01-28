<?php 
  $router = array();

  $router['/'] = function(){
    include 'views/home.php';
  };

  $router['/account'] = function(){
    include 'views/account.php';
  };

  $router['/profile'] = function(){
    include 'views/profile.php';
  };

  if(isset($_SERVER['REQUEST_URI'])){
    $uri = $_SERVER['REQUEST_URI'];
    if ($router[$uri]){
      $router[$uri]();
    }else{
      echo '404';
    }
  }
?>