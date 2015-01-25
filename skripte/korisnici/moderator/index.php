<?php

  include_once('../../config.php');

  session_start();

  $engine = render_engine();


  $id = intval($_SESSION['user']);
  $user = R::load( 'hokorisnici', $id );


  if ($user->type == "moderator" || $user->type == "admin") {
    echo $engine->render('moderator', 
      array(
        "username" => $user->username
      ));
  } else {
    echo $engine->render('401', array("title" => "Nemate prava pristupa"));
  }
?>
