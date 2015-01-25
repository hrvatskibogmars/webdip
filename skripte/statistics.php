<?php

  include_once('config.php');
  include_once('log.php');

  function spremi_statistiku_prijava($user, $session_id, $status) {

    $statistics = R::dispense( 'hostatistika' );
    $statistics->user_id = $user->id;
    $statistics->session_id = $session_id;
    $statistics->username = $user->username;
    $statistics->status = $status;
    $statistics->login = time();
    R::store($statistics);

  }

  function save_stat_logout($user, $session_id) {
    $stat = R::findOne( 'hostatistika', 'user_id = :user_id and session_id = :session_id',
      array(
        ":user_id" => $user->id,
        ":session_id" => $session_id
      ));

    $stat->logout = time();
    R::store($stat);
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    if ($request->action == "get_statistics") {
      dnevnik_poruka("info", "Administrator dohvatio statistiku");
      $config = R::getAll("select * from hostatistika");
      echo json_encode($config);
    }

  }

?>
