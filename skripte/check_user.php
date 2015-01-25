<?php

include_once('config.php');
include_once('virtime.php');

$username = $_POST['username'];

$user = R::findOne( 'hokorisnici', 'username = :username ', array( ":username" => $username ));

if ($user) {
  echo 1;
}
else {
  echo 0;
}

?>
