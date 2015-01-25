<?php

include_once('../skripte/virtime.php');
include_once('config.php');
include_once('statistics.php');

session_start();

$user = R::load('hokorisnici', $_SESSION['user']);

save_stat_logout($user, $_SESSION['session_id']);

$_SESSION['user'] = NULL;

if ( isset($_COOKIE['user']) ) {
  unset($_COOKIE['user']);
}

if ( isset($_COOKIE['remember_me']) ) {
  unset($_COOKIE['remember_me']);
}

header("Location: ../index.php");
?>
