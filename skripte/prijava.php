<?php
  include_once('../skripte/virtime.php');
  include_once('config.php');
  include_once('log.php');
  include_once('statistics.php');

  $engine = render_engine();

  session_start();

  if(isset($_POST)) {

      $f_user = $_POST['user_email'];
      $f_activated = 1;

      $user = R::findOne( 'hokorisnici', 'email = :varijabla_email and activated = :activated and blocked = :blocked', 
        array(":varijabla_email" => $f_user, ":activated" => $f_activated, ":blocked" => 0));

      $f_pass = $_POST['user_password'];
      
      $f_blocked = false;

      if (!$user) {
        echo $engine->render("post_prijava", array("title" => "Korisnik nije pronaden", "message" => "Moze biti da je korisnik blokiran ili ste zaboravili aktivirati svoj racun. Kontaktirajte administratora."));
      } else {
        if ($user->password != $f_pass) {
          // slucaj ako je korisnik ispravno unio email, a krivo je unio lozinku
          $user->wrong_attempt = intval($user->wrong_attempt) + 1;
          //$accesses = $user->wrong_attempt;

          dnevnik_poruka("info", $f_user. " se pokusava prijaviti. Prijava broj " . $accesses);

          $config = R::load( 'hokonfig', 1 );

          if (!$config->max_login_count)
            $config->max_login_count = 3; // po defaultu je zadano tako u zadatku

          if ($user->wrong_attempt > $config->max_login_count) {
            $user->blocked = true;
             R::store($user);
            dnevnik_poruka("info", "Korisnik " . $user->username . " je blokiran");
            echo $engine->render('post_prijava',
              array(
                "title" => "Neuspjena prijava, " . $user->wrong_attempt . ". puta. Vas racun je blokiran",
                "message" => "Kontaktirajte administratora. Nakon sto Vam administrator omoguci ponovo racun, pricekajte neko vrijeme da session istekne."
              )
            );
            
            spremi_statistiku_prijava($user, $_SESSION['session_id'], "failure");
          } else {
            R::store($user);
            dnevnik_poruka("info", "Korisnik " . $user->username . " se krivo prijavio");
            echo $engine->render('post_prijava', 
              array(
                "title" => "Neuspjesna prijava, " . $user->wrong_attempt . ". puta.",
                "message" => "Nakon " . $config->max_login_count . " vas racun ce biti blokiran"
              ));
          }
        } else {
          // Korisnik je sve podatke ispravno unio
          dnevnik_poruka("info", "Korisnik " . $user->username . " se uspjesno prijavio");
          $user->wrong_attempt = 0;
          R::store($user);
          if ($f_remember_me == "true") {
            unset($_COOKIE["remember_me"]);
            setcookie("remember_me", $user->email, time() + 3600, "/");

            dnevnik_poruka("info", "Korisnik" . $user->username . " uspjesno postavio kolacic");
          }

          unset($_COOKIE["user"]);
          setcookie("user", $user->email , time() + 3600, "/");

          $_SESSION['user'] = $user->id;
          $_SESSION['session_id'] = uniqid();
          spremi_statistiku_prijava($user, $_SESSION['session_id'], "success");

          if ($user->type == "user")
            header("Location: korisnici/etnograf/index.php");

          if ($user->type == "moderator")
            header("Location: korisnici/moderator/index.php");

          if ($user->type == "admin")
            header("Location: korisnici/admin/index.php");

        }

      }

  }
?>
