<?php

  include_once('config.php');
  include_once("virtime.php");

  $current_time = VirtualTime::get_time();

  $user = R::load('hokorisnici', $_GET['id']);


  $vrijeme_proteklo = (intval($current_time) - intval($user->last_update)) / 60 / 60;


  $engine = render_engine();
  
  if ($vrijeme_proteklo > floatval(24)) {
    echo $engine->render('post_aktivacija', 
      array(
        "title" => "Aktivacija je istekla",
        "message" => "Proslo je " . intval($vrijeme_proteklo) . " sata od registracije."
        ));
  
  } else {
  
    $user->activated = true;
    R::store($user);

    echo $engine->render("post_aktivacija",
      array(
        "title" => "Uspjesna aktivacija",
        "message" => "Hvala Vam sto ste aktivirali svoj racun. " . "Proslo je " . intval($vrijeme_proteklo) . " sata od registracije."
        ));
  
  }

?>
