<?php 
  require 'vendor/autoload.php';
  $dotenv = Dotenv\Dotenv::create(__DIR__ . "/../");
  if(file_exists('.env')) {
    $dotenv->load();
  }

  function send_email($to, $text, $html){
    $key = getenv('SENDGRID_API');
    $sender = getenv('EMAIL_SENDER');
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom($sender, "Admin");
    $email->setSubject("Sending Sample Email");
    $email->addTo($to);
    $email->addContent('text/plain', $text);
    $email->addContent('text/html', $html);
    $sendgrid = new \SendGrid($key);
    $sendgrid->send($email);
  }

  function email_constructor($text, $option){
    if ($option === 'text') {
      return 'Hello, \n' . $text . '\n Sincerely, \n Smart Money Admin';
    } else {
      return '<h3>Smart Money Just Sent You A Email</h3>' . '<strong>' . $text . '</strong>';
    }
  }
?>