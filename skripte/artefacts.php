<?php
  include_once('config.php');

  session_start();
  $user = R::load('hokorisnici', intval($_SESSION['user']));
  $engine = render_engine();

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $artefact = R::dispense('hoartefakti');


    //$postdata = file_get_contents("php://input");
    //$request = json_decode($postdata);

    $artefact->user_id = $user->id;
    $artefact->username = $user->username;
    $artefact->region = $_POST['region']; //$request->region;

    $artefact->place = $_POST['place']; //$request->place;
    $artefact->name = $_POST['name']; //$request->name;
    $artefact->content = $_POST['content']; //$request->content;
    $artefact->created = time();
    $artefact->approved = false;

    //echo $_POST['region'];
    //echo $_POST['place'];

    if ($artefact->region && $artefact->place ) {
      if ( !(!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) ) {

        $tempPath = $_FILES[ 'file' ][ 'tmp_name' ];
        $uploadPath = '../upload/' . $_FILES[ 'file' ][ 'name' ];

        $artefact->filename = $_FILES['file']['name'];
        $artefact->url_file = 'upload/' . $_FILES['file']['name'];

        move_uploaded_file( $tempPath, $uploadPath );
      } else {
        $artefact->url_file = 'img/128x128.gif';
      }

      $id = R::store($artefact);
      header('Location: korisnici/etnograf/index.php');
      die();
    }
    else {
      echo $engine->render('post_prijava', 
        array("title" => "Dogodila se pogreska", "message" => "Pokusajte ponovo kasnije."));
    }
  }

  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //$request = json_decode(file_get_contents("php://input"));
    $places = R::getAll('select * from hoartefakti where user_id = ' . $_SESSION['user'] .";");
    echo json_encode($places);
  }
?>
