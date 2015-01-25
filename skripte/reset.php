<?php

  include_once('virtime.php');
  include_once('config.php');
  include_once('log.php');
  include_once('statistics.php');

  $engine = render_engine();

  session_start();

  if(isset($_POST)) {

      $user = R::findOne('hokorisnici', 'email = :email', array(":email" => $_POST['email']));

      if ($user) {
        $length = 12;
        $user->password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);;
        R::store($user);

        $to = $user->email;
        $subject = "eEtno reset";
        $message = "Lozinka je resetirana. Nova lozinka: " . $user->password;
        $from = "admin@eetno.hr";
        $headers = "From: " . $from;
        mail($to, $subject, $message, $headers);

        echo $engine->render('post_prijava', 
          array("title"=> "Uspjesno ste resetirali lozinku"));
        
      } else {
        echo $engine->render('post_prijava', 
          array("title"=> "Niste resetirali lozinku. Pokusajte sa drugim mailom ili kasnije."));
      }
  }
?>
