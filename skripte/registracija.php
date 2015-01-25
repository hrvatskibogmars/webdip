<?php

  include_once('config.php');
  include_once('virtime.php');
  require_once('biblioteke/recaptchalib.php');

  session_start();
  
  //$engine = use Handlebars\Handlebars;

  $engine = render_engine();


  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $privatekey = "6LfpF_MSAAAAAE39gFRJVOztTi3-e9OXdSAfdCgK";
    $resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

    if ($resp->is_valid) {

        $user = R::dispense('hokorisnici');

        $user->name = $_POST['ime'];
        $user->surname = $_POST['prezime'];
        $user->email = $_POST['email'];
        $user->wrong_attempt = 0;
        $user->blocked = 0;
        // Server side validacija
        $exists = R::findOne( 'hokorisnici', 'email = :email ', array( ":email" => $user->email ));
        if ($exists) {
          echo "Ovaj korisnik vec postoji";
          exit(0);
        }

        $user->username = $_POST['username'];
        // Server side validacija
        $exists = R::findOne( 'hokorisnici', 'username = :username', array( ":username" => $user->username));
        if ($exists) {
          echo "Ovaj korisnik vec postoji";
          exit(0);
        }

        $user->user_status = 'I';
        $user->password = $_POST['password'];

        $password_repeat = $_POST['password_repeat'];

        $user->activated = false;
        $user->type = "user";
        $user->spol = $_POST['spol'];
        $user->city = $_POST['city'];
        $user->last_update = time();


        if(file_exists($_FILES['file']['tmp_name']) || is_uploaded_file($_FILES['file']['tmp_name'])) {
          if ($_FILES["file"]["error"] > 0) {
            echo "Doslo je do pogreske.<br>";
            echo "RCode: " . $_FILES["file"]["error"] . "<br>";
          } else {
            if (file_exists("../upload/" . $_FILES["file"]["name"])) {
              //echo $_FILES["file"]["name"] . " already exists. ";
            } else {

              move_uploaded_file($_FILES["file"]["tmp_name"],
                "../upload/" . $_FILES["file"]["name"]);

            }

            //$user->folder = "/upload/";
            //$user->photo_name = $_FILES["file"]["name"];
            $user->url_file = "upload/" . $_FILES["file"]["name"];
          } 
        } else {
          $user->url_file = 'img/128x128.gif';
        }

        $id = R::store($user);

        $to = $user->email;
  	    $subject = "eEtno verifikacijski email";
  	    $message = "Hello, hvala sto ste se registrirali na e-etno.com. Molimo Vas da verificirate svoj email klikom na sljedeci link: http://arka.foi.hr/WebDiP/2013_projekti/WebDiP2013_057/skripte/aktivacija.php?id=" . $id;
  	    $from = "admin@eetno.hr";
  	    $headers = "From: " . $from;
  	    mail($to, $subject, $message, $headers);

        echo $engine->render('post_registracija', 
            array("title" => "Hvala na registraciji", "message" => "Email za verifikaciju poslan"));
  } else {
    die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
         "(reCAPTCHA said: " . $resp->error . ")");
  }
}

?>
