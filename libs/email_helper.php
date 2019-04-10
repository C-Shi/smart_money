<?php 
  require 'vendor/autoload.php';
  $dotenv = Dotenv\Dotenv::create(__DIR__ . "/../");
  if(file_exists('.env')) {
    $dotenv->load();
  }

  function send_email(){
    $key = getenv('SENDGRID_API');
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom('test@example.com', "Example User");
    $email->setSubject("Sending Sample Email");
    $email->addTo('kyleshi82@gmail.com', "Example User");
    $email->addContent('text/plain', 'this is a sample email');
    $email->addContent('text/html', "<strong>and easy to do anywhere, even with PHP</strong>");
    $sendgrid = new \SendGrid($key);
    $sendgrid->send($email);
  }
?>