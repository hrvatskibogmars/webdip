<?php
  include_once('config.php');

  function dnevnik_poruka($type, $message) {
      $log = R::dispense('hologovi');
      $log->type = $type;
      $log->message = $message;
      $log->time = time();
      R::store($log);
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    if ($request->action == "get_log") {
      dnevnik_poruka("info", "Administrator dohvatio log podatke");
      $config = R::getAll("select * from hologovi");
      echo json_encode($config);
    }
  }
?>
