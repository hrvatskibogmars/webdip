<?php
  include_once('../../config.php');

  session_start();


  $engine = render_engine();
  
  $user = R::load('hokorisnici', intval($_SESSION['user']));

  if ($user->type == "user" || $user->type == "moderator" || $user->type == "admin") {
    echo $engine->render('etnograf', 
      array(
        "username" => $user->username
      ));
  } else {
    echo $engine->render('401', array("title" => "Nemate prava pristupa.")); 
  }
?>
