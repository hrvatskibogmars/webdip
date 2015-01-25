<?php
  include_once('../../config.php');

  session_start();

  $id = intval($_SESSION['user']);
  $user = R::load('hokorisnici', $id);

  $engine = render_engine();

  if ($user->type == "admin") {
    $data = array(
        "username" => $user->username
    );
    echo $engine->render('admin', $data);
  } else {
    echo $engine->render('401', array("title" => "Nemate prava pristupa."));
  }
?>
