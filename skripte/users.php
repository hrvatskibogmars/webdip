<?php
  include_once('config.php');


  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $region = R::dispense('horegije');


    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    $region->name = $request->name; //$_POST['name'];
    $region->created = time();


    if ($region->name) {
      $id = R::store($region);
      echo $id;
    }
    else {
      echo "null";
    }
  }

  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $users = R::getAll('select * from hokorisnici;');
    echo json_encode($users);
  }
?>
