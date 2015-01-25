<?php
  include_once('log.php');
  include_once('biblioteke/handlebars.php/src/Handlebars/Autoloader.php');
  include_once('biblioteke/rb/rb.php');
  
  R::setup('mysql:host=localhost;dbname=WebDiP2013_057', 'WebDiP2013_057','admin_CFq8');
  Handlebars\Autoloader::register();
  use Handlebars\Handlebars;


  function render_engine() {
    $engine = new Handlebars(array(
      'loader' => new \Handlebars\Loader\FilesystemLoader(__DIR__ . '/predlosci/'),
      'partials_loader' => new \Handlebars\Loader\FilesystemLoader(__DIR__ . '/predlosci/', array('prefix' => '_'))
      )
    );
    return $engine;
  }
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    if ($request->action == "get_config") {
      dnevnik_poruka("info", "Administrator dohvatio konfiguracijske podatke");
      $config = R::getAll("select * from hokonfig");
      echo json_encode($config[0]);
    }

    if ($request->action == "reset_config") {

      dnevnik_poruka("info", "Administrator resetirao konfiguraciju sustava");
      $config = R::load('hokonfig', 1);
      $config->max_login_count = 3;
      R::store($config);

      $config = R::getAll("select * from hokonfig");
      echo json_encode($config[0]);
    }
    if ($request->action == "save_config") {
      dnevnik_poruka("info", "Administrator azurirao podatke");
      $config = R::load( 'hokonfig', 1 );
      $config->max_login_count = $request->data->max_login_count;
      echo R::store($config);
    }
  }

?>
