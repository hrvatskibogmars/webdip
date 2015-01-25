<?php
  include_once('config.php');


  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo "hehe";
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    
    $unblocking_user = R::load('hokorisnici', intval($request->id));
    if ($unblocking_user) {
      $unblocking_user->wrong_attempt = 0;
      $unblocking_user->blocked = 0;
      R::store($unblocking_user);
      
      $unblocking_user->msg = "ok";

      echo json_encode($unblocking_user);
    } else {
      echo json_encode(array( "msg" => "null" ));
    }
  }
?>
