<?php

include_once('config.php');
include_once('virtime.php');

$email = $_POST['email'];

$user = R::findOne( 'hokorisnici', 'email = :email ', array( ":email" => $email ));

if ($user) {
  echo 1;
}
else {
  echo 0;
}


?>
