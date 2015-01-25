<!DOCTYPE html>
<html lang="en">
    <head>
        <title>eETNO</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/main.css" rel ="stylesheet" type="text/css"/>

        <script src="js/jquery-2.1.1.min.js"></script>
        <script src='js/bootstrap.js' type='text/javascript' charset='utf-8'></script>
        <script src="js/angular.js" type="text/javascript" charset="utf-8"></script>
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

        <script src='js/index.js' type='text/javascript' charset='utf-8'></script>
    </head>

    <body data-ng-app='app'>
        <div class="modal fade" id="forgot">
          <div class="modal-dialog">
            <form action="skripte/reset.php" method="post">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Resetiraj lozinku</h4>
                  </div>
                  <div class="modal-body">
                    <p>
                        <input type="text" name="email" value="" placeholder="Email" class="form-control">   
                    </p>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Resetiraj lozinku</button>
                  </div>
                </div>
            </form>
          </div>
        </div><!-- /.modal -->

        <nav class="navbar navbar-default" role="navigation">
            <div class="container">
                <ul class="nav navbar-nav">

                </ul>
                 <form class="navbar-form navbar-right" role="search" method="post" action="skripte/prijava.php">
                    <div class="form-group">
                        <input type="email" name="user_email" class="form-control" id="user_email_login" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input type="password" name="user_password" class="form-control" id="user_password_login" placeholder="Lozinka">
                    </div>
                    <button type="submit" class="btn btn-default btn-sm">Prijavi me</button>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#forgot">Resetiraj lozinku</button>
                </form>
            </div>
        </nav>

        <section>
            <div class="container" data-ng-controller='main'>
                    
                 <div id="myCarousel" class="carousel slide" data-ride="carousel">
    
                      <!-- Wrapper for slides -->
                      <div class="carousel-inner">
                      
                        <div class="item active">
                          <img src="http://ballroomblissdance.com/wp-content/uploads/2011/10/dizzy_halloween_face_hd_widescreen_wallpapers_1920x12001-1200x400.jpg" width="1200" height="400">
                        </div><!-- End Item -->
                 
                         <div class="item">
                          <img src="https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQkoGcDrvm9HQj6R81g8N3X0ldZrxFa0p9XibGEW_Q56L1Qw7krUQ" width='1200' height='400'>

                        </div><!-- End Item -->
                        
                        <div class="item">
                          <img src="http://www.wallsave.com/wallpapers/1200x400/white-minimalist/117643/white-minimalist-fir-tree-olive-p-ographs-shop-117643.jpg" width="1200" height="400">
                        </div><!-- End Item -->
                      </div><!-- End Carousel Inner -->


                        <ul class="nav nav-pills nav-justified">
                          <li data-target="#myCarousel" data-slide-to="0" class="active"><a href="#">Običaji</a></li>
                          <li data-target="#myCarousel" data-slide-to="1"><a href="#">Arhaične riječi</a></li>
                          <li data-target="#myCarousel" data-slide-to="2"><a href="#">Dijalekti</a></li>
                        </ul>


                    </div><!-- End Carousel -->

                <hr>
                <div class="row">
                    <div class="col-lg-11 col-md-5 col-sm-8 col-xs-9 bhoechie-tab-container">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
                          <div class="list-group">
                            <a href="#" class="list-group-item active text-center">
                              <h4 class="glyphicon glyphicon-hand-right"></h4><br/>Što je ?
                            </a>
                            <a href="#" class="list-group-item text-center">
                              <h4 class="glyphicon glyphicon-pencil"></h4><br/>Čemu sluzi?
                            </a>
                            <a href="#" class="list-group-item text-center">
                              <h4 class="glyphicon glyphicon-user"></h4><br/>Registracija
                            </a>
                            <a href="#" class="list-group-item text-center">
                              <h4 class="glyphicon glyphicon-list-alt"></h4><br/>Regije
                            </a>
                            <a href="#" class="list-group-item text-center">
                              <h4 class="glyphicon glyphicon-credit-card"></h4><br/>Artefakti
                            </a>
                          </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                            <!-- sto je eetno -->
                            <div class="bhoechie-tab-content active">
                                <center>
                                  <h1>Sto je eEtno</h1>
                                  <hr>
                                  <h3 style="margin-top: 0;color:#55518a">Web aplikacija za katalogizaciju i kreiranje repozitorija o dijalektima, arhaičnim rječima i tracionalnim običajaima nekog kraja...</h3>
                                </center>
                            </div>

                            <!-- cemu sluzi -->
                            <div class="bhoechie-tab-content">
                                <div class="center">
                                  <h1>Cemu sluzi?</h1>
                                  <hr>
                                  <h3 style="margin-top: 0;color:#55518a">Omogućuje korisnicima da dodavaju, mijenjaju i brišu sadržaj u suradnji s ostalim korisnicima sustava. Korisnici mogu sustav obogaćivati sadržajem putem tekstualnih unosa, video unosa, slika...</h3>
                                </div>
                            </div>
                
                            <!-- registracija -->
                            <div class="bhoechie-tab-content">
                                <form name="register" id="register" method="post" action='skripte/registracija.php' enctype="multipart/form-data">
                                    <div class="row">
                                        <h3>Registriraj me</h3>
                                        <div class="col-md-6">
                                            <div class="form-group" id="name">
                                                <label for="user_name">Ime</label>
                                                <input type="text" class="form-control" name="ime" id="user_name" placeholder="Ime" required>
                                                <span class="glyphicon glyphicon-remove form-control-feedback" id="error_name"></span>
                                                <div class="alert alert-danger" id="alert_name"></div>
                                            </div>

                                            <div class="form-group" id="surname">
                                                <label for="user_surname">Prezime</label>
                                                <input type="text" class="form-control" name="prezime" id="user_surname" placeholder="Prezime" required>
                                                <span class="glyphicon glyphicon-remove form-control-feedback" id="error_surname"></span>
                                                <div class="alert alert-danger" id="alert_surname"></div>
                                            </div>

                                            <div class="form-group">
                                                <label for="user_city">Grad</label>
                                                <input type="text" class="form-control" id="user_city" name="city" placeholder="Naziv grada" required>
                                            </div>

                                            <div class="row">
                                                      <div class="col-md-6">
                                                          <label for="user_image">Vlastita slika</label>
                                                          <input type="file" name="file" id="file">
                                                      </div>

                                                      <div class="col-md-6 center-block">
                                                          <h5><strong>Spol </strong></h5>
                                                          <div class="radio" id="radio_z">
                                                              <label><input type="radio" name="spol" id="user_z" value="z">Žensko</label>
                                                          </div>
                                                          <div class="radio" if="radiom_m">
                                                              <label><input type="radio" name="spol" id="user_m" value="m"> Muško</label>
                                                          </div>
                                                      </div>
                                                  </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" id="email">
                                                <label for="user_email">E-mail adresa</label>
                                                <input type="email" class="form-control" id="user_email" name="email" placeholder="Email adresa" required>
                                                <span class="glyphicon glyphicon-remove form-control-feedback" id="glyph_email"></span>
                                                <div class="alert alert-danger" id="alert_email"></div>
                                            </div>

                                            <div class="form-group" id="username">
                                                <label for="user_username">Korisničko ime</label>
                                                <input type="text" class="form-control" id="user_username" name="username" placeholder="Korisnicko ime" required>
                                                <span class="glyphicon glyphicon-remove form-control-feedback" id="glyph_username"></span>
                                                <div class="alert alert-danger" id="alert_username"></div>
                                            </div>

                                            <div class="form-group" id="password">
                                                <label for="user_password">Password</label>
                                                <input type="password" class="form-control" id="user_password" name="password" placeholder="Lozinka" required>
                                                <span class="glyphicon glyphicon-remove form-control-feedback" id="glyph_password"></span>
                                                <div class="alert alert-danger" id="alert_password"></div>
                                            </div>

                                            <div class="form-group" id="password2">
                                                <label for="user_password">Retype - Password</label>
                                                <input type="password" class="form-control" id="user_password2" name="password_repeat" placeholder="Ponovo lozinka" required>
                                                <span class="glyphicon glyphicon-remove form-control-feedback" id="glyph_password2"></span>
                                                <div class="alert alert-danger" id="alert_password2"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4 center-block">
                                                    <?php
                                                        require_once('skripte/biblioteke/recaptchalib.php');
                                                        $publickey = "6LfpF_MSAAAAALzn8SVEi5vy-fPn3e3pp5sn-5yT"; // you got this from the signup page
                                                        echo recaptcha_get_html($publickey);
                                                    ?>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-offset-5">
                                                <button id="regis_btn" type="submit" class="btn btn-primary">Registriraj se</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <!-- regije -->
                            <div class="bhoechie-tab-content">
                                <div class="center">
                                  <h3>Regije</h3>
                                  <hr>
                                  <a href="" data-ng-repeat="region in regions">
                                    <div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                      <div class="offer offer-default">
                                        <div class="shape">
                                          <div class="shape-text">
                                            Regija
                                          </div>
                                        </div>
                                        <div class="offer-content">
                                          <h3 class="lead">
                                            {{ region.name }}
                                          </h3>
                                          <!--<p>
                                            And a little description.
                                            <br> and so one
                                          </p>-->
                                        </div>
                                      </div>
                                    </div>
                                  </a>
                                </div>
                            </div>

                            
                            <!-- artefakti -->
                            <div class="bhoechie-tab-content">
                                <div class="center">
                                  <h3>Artefakt</h3>
                                  <hr>
                                  <div data-ng-repeat="artefact in artefacts">
                                    <div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                      <div class="offer offer-default">
                                        <div class="shape">
                                          <div class="shape-text">
                                            Artefakt
                                          </div>
                                        </div>
                                        <div class="offer-content">
                                          <h3 class="lead">
                                            &#123;&#123; artefact.name &#125;&#125;
                                          </h3>
                                          <p data-ng-bind-html='render_region(artefact.region)'></p>
                                          <p>&#123;&#123; artefact.content  &#125;&#125;</p>
                                          <!--<p>
                                            And a little description.
                                            <br> and so one
                                          </p>
                                        </div>-->
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                
                <hr>
                <div></div>
            </div>
        </section>

        <footer>
            <div id="footer">
                <div class="container">
                        <address>
                            <strong>Hrvoje Orejaš</strong><br>
                            Kontaktirajte me: <a href="mailto:hrorejas@foi.hr" >hrorejas@foi.hr</a>
                        </address>
                        <p> Sva prava pridržana, Web dizajn i programiranje, 2014 </p>
                        <a href="">
                            <img width="88" height="31" class="validator" src="img/validator.png" alt="validator"/>
                        </a>
                        <a href="http://jigsaw.w3.org/css-validator/check/referer">
                            <img width="88" height="31" class="validator" src="http://jigsaw.w3.org/css-validator/images/vcss-blue"      alt="Valid CSS!" />
                        </a>
                </div>
            </div>
        </footer>
        <script src="js/registracija.js"></script>
    </body>
</html>
