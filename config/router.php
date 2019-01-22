<?php 
  $router = array();

  $router['/'] = function(){
    echo 'Home page';
  };

  $router['/about'] = function(){
    echo 'About page';
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