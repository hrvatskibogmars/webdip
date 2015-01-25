<?php
  include_once('config.php');


  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    if ($request->action == "edit_moderators") {

        //$region_moderators->region =
        $region_moderators = R::getAll('select * from homoderatoriregija where region_id =' . $request->region_id . ';');
        echo json_encode($region_moderators);
    }

    if ($request->action == "save_moderators") {
      $stored = 0;
      foreach ($request->data as $key => $value) {
        $region_moderators = R::dispense('homoderatoriregija');
        $region_moderators->region_id = $request->region_id;
        $region_moderators->user_id = $key;

        if ($value == true) {
            R::store($region_moderators);
            $stored++;
        }

        if ($value == false) {
            $region_mod = R::findOne( 'homoderatoriregija', 'user_id = :id ', array( ":id" => $key ));
            if ($region_mod) {
              R::trash($region_mod);
            }
        }
      }
      echo $stored;
    }

    if ($request->action == "add") {

      $region = R::dispense('horegije');
      $region->name = $request->data;
      $region->created = time();


      if ($region->name) {
        $id = R::store($region);
        echo $id;
      }
      else {
        echo "null";
      }
    }

    if ($request->action == "delete") {
      $region = R::load( 'horegije', $request->data);
      R::trash($region);
    }
  }

  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $regions = R::getAll('select * from horegije;');
    echo json_encode($regions);
  }
?>
