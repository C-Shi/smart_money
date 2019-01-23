<?php 
  $host = '127.0.0.1';
  $user = 'root';
  $password = '';
  $dbname = 'smart_money';

  // set DSN
  $dsn = "mysql:host=$host;dbname=$dbname";

  // Create PDO instance
  $pdo = new PDO($dsn, $user, $password);
  // Set default fetching method
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
?>