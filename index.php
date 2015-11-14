<?php
  require_once("login/classes/Login.php");
  require_once("config.php");

  $login = new Login();
  // ... ask if we are logged in here:
  if ($login->isUserLoggedIn() == false) {
      header("Location: /faciejetser/login.php");

  }

  // create a login object. when this object is created, it will do all login/logout stuff automatically
  // so this single line handles the entire login process. in consequence, you can simply ...
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FaCie - Jetser</title>

  <link rel="stylesheet" href="library/style/bootstrap.min.css">
  <link rel="stylesheet" href="library/style/main.css">

  <script type="text/javascript" src="library/js/jquery-2.1.1.min.js"></script>
  <script type="text/javascript" src="library/js/main.js"></script>
  <script type="text/javascript" src="library/js/marquee.js"></script>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 orange-info-bar">
        <div class="row">
          <marquee behavior="scroll" direction="" scrollamount="2" width="" height="50" ><ul class="stats"></ul></marquee>   
          <a href="login/index.php?logout" class="btn btn-default btn-logout" style="float: right; margin: 8px 20px; position: absolute; top: 0px; right: 20px;">Log uit</a>   
        </div>
      </div>
    </div>
    <div class="row content">
      <div class="col-md-6 info">
        <div class="parent">
          <div class="saving-image" id="image-saving">
            <i class="glyphicon glyphicon-refresh"></i>
            <p>Opslaan</p>
          </div>
          <div class="saving-image" id="image-done">
            <i class="glyphicon glyphicon-ok"></i>
            <p>Opgeslagen</p>
          </div>
          <div class="saving-image" id="image-error">
            <i class="glyphicon glyphicon-remove"></i>
            <p id="error-message"></p>
          </div>
        </div>
        <div id="form">
          <form role="form">
            <div class="row">
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="control-label" for="naam">Naam nul:</label> 
                  <input type="text" class="form-control delete" id="naam" placeholder="Voornaam Achternaam">
                </div>
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="control-label" for="fotoNummer">Foto nummer:</label> 
                  <input type="text" class="form-control delete" id="fotoNummer" placeholder="Fotonummer">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="control-label" for="email">E-mail adress:</label>
                  <input type="text" class="form-control delete" id="email" placeholder="Email-adres">
                </div>
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="control-label" for="woonplaats">Woonplaats:</label>
                  <input type="text" class="form-control delete" id="woonplaats" placeholder="Woonplaats">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="control-label" for="mobiel">Mobiel:</label>
                  <input type="text" class="form-control delete" id="mobiel" placeholder="Mobielnummer">
                </div>
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="control-label" for="datum">Geboren op:</label>
                  <input type="text" class="form-control delete" id="datum" placeholder="Geboortedag">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="control-label" for="studie">Studie:</label>
                  <input type="text" class="form-control delete" id="studie" placeholder="Studie">
                </div>
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <input type="hidden" class="form-control delete" id="id" placeholder="ID" disabled>
                  <input type="hidden" class="form-control" id="mode" placeholder="ID" disabled>
                  <input type="hidden" class="form-control" id="type" placeholder="ID" disabled>
                  <input type="hidden" class="form-control" id="writter" value="<?= $_SESSION['user_id']; ?>" disabled>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label" for="stukje">Stukje</label>
              <textarea name="stukje" class="form-control" id="stukje" cols="30" rows="10"></textarea>
              <p class="stukjeCharaters"><span class="number">0</span> characters</p>
            </div>
            <a type="submit" id="submitStukje" class="btn btn-default btn-lg btn-block">BAM! Weer een stukje!</a>
          </form>
        </div>
      </div>
      <div class="col-md-6">
        <ul class="nav nav-pills nav-justified" role="tablist">
          <li id="nav-listOfNullen" data-type="nul" data-mode="saving" class="active"><a href="#">Nullen</a></li>
          <li id="nav-spellNullen" data-type="nul" data-mode="update" class=""><a href="#">Nullen DONE</a></li>
          <li id="nav-listOfMentoren" data-type="mentor" data-mode="saving" class=""><a href="#">Mentoren</a></li>
          <li id="nav-spellMentoren" data-type="mentor" data-mode="update" class=""><a href="#">Mentoren DONE</a></li>
          <li id="nav-fotoScreen" class="nav-tab-item"><a href="#">Foto</a></li>
        </ul>
        <div id="listOfNullen" class="screens">
          <table class="table table-hover tableOfMentoren">
            <thead>
              <tr>
                <th colspan="2">
                  <div class="input-group">
                    <input class="form-control input-sm" id="searchNul" type="text" placeholder="Zoek naar een nul...">
                  </div>
                </th> 
              </tr>
            </thead>
            <tbody id="contentOfNullen"></tbody>
          </table>
        </div>
        <div id="listOfMentoren" class="screens">
          <table class="table table-hover tableOfMentoren">
            <thead>
              <tr>
                <th colspan="2">
                  <div class="input-group">
                    <input class="form-control input-sm" id="searchMentor" type="text" placeholder="Zoek naar een mentoren...">
                  </div>
                </th> 
              </tr>
            </thead>
            <tbody id="contentOfMentoren"></tbody>
          </table>
        </div>
        <div id="spellNullen" class="screens">
          <table class="table table-hover tableOfMentoren">
            <thead>
              <tr>
                <th colspan="3">
                  <div class="input-group">
                    <input class="form-control input-sm" id="searchSpellNul" type="text" placeholder="Zoek naar een nul...">
                  </div>
                </th> 
              </tr>
            </thead>
            <tbody id="contentOfSpellNullen"></tbody>
          </table>
        </div>
        <div id="spellMentoren" class="screens">
          <table class="table table-hover tableOfMentoren">
            <thead>
              <tr>
                <th colspan="3">
                  <div class="input-group">
                    <input class="form-control input-sm" id="searchSpellMentor" type="text" placeholder="Zoek naar een mentor...">
                  </div>
                </th> 
              </tr>
            </thead>
            <tbody id="contentOfSpellMentoren"></tbody>
          </table>
        </div>
        <div id="fotoScreen" class="screens">
          <img id="foto" src="library/pics/DSC01878.JPG" width="100%" alt="" />
        </div>
      </div>
    </div>
  </div>
</body>
</html>