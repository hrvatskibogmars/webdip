<?php
  include_once('config.php');

  session_start();
  //$user = R::load('hokorisnici', intval($_SESSION['user']));
  $engine = render_engine();

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    $artefact = R::load('hoartefakti', intval($request->data->id));
      
    if ($artefact) {
      $artefact->approved = $request->data->approved;
      R::store($artefact);
      echo json_encode($artefact);
    } else {
      echo "shsahsdda";
    }

  }

  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo NULL;
  }
?>
