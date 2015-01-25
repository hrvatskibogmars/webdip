<?php
  include_once('config.php');

  session_start();
  $engine = render_engine();

  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $places = R::getAll('select * from hoartefakti');
    echo json_encode($places);
  }
?>
