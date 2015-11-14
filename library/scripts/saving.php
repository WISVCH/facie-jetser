<?php
  require_once("../../login/classes/Login.php");
  require_once("../../config.php");

  $login = new Login();
  // ... ask if we are logged in here:
  if ($login->isUserLoggedIn() == false) {
    header("Location: /faciejetser/login.php");
  }

  try {
    /*
     * Check if all the data has been transmitted.
     */
    $postItems = $_POST;
    if ( (!isset($_POST['id']) || empty($_POST['id'])) || (!isset($_POST['mode']) || empty($_POST['mode'])) || (!isset($_POST['type']) || empty($_POST['type'])) || (!isset($_POST['writter']) || empty($_POST['writter']))) {
      die ("Illegal access");
    }
    foreach ($postItems as $key => $value) {
      if (!isset($value) || empty($value)) {
        die ("EmptyInputExteption:".$key);
      }
    }

    /*
     * When mode isset (saving: creating a new slot in the database. update: updating an existing slot in the database)
     */
    if (isset($_POST['mode']) && !empty($_POST['mode'])) {
      /**
       *  Check if input is valid
       */
      try {
        foreach ($postItems as $key => $value) {
          $postItems[$key] = $mysqli->real_escape_string($value);
        }
      } catch (Exception $e) {
       die ("MySQLEscapeError");
      }

      if (isset($_POST['type']) && !empty($_POST['type'])) {

        /**
         *  When mode isset at saving
         */
        if ($_POST['mode'] == "saving") {

          /**
           *  When type isset at mentor, it will create a new slot in the database to save a mentor
           */
          if ($_POST['type'] == "mentor") {
            try {
              $mysqli->query("INSERT INTO facie_data_mentoren VALUES('".$postItems['id']."', '".$postItems['naam']."', '".$postItems['email']."', '".$postItems['woonplaats']."', '".$postItems['mobiel']."', '".$postItems['datum']."', '".$postItems['studie']."', '".$postItems['stukje']."', 'DSC0".$postItems['fotoNummer']."', '".$postItems['writter']."', '0', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."');") or die ("NOT SAVED");
              $mysqli->query("SELECT * FROM facie_data_mentoren WHERE 
                  id = '".$postItems['id']."' &&
                  mentor_naam = '".$postItems['naam']."' &&
                  mentor_email = '".$postItems['email']."' &&
                  mentor_woonplaats = '".$postItems['woonplaats']."' &&
                  mentor_telefoon = '".$postItems['mobiel']."' &&
                  mentor_datum = '".$postItems['datum']."' &&
                  mentor_studie ='".$postItems['studie']."' &&
                  mentor_stukje = '".$postItems['stukje']."' &&
                  mentor_foto = '".$postItems['fotoNummer']."' &&
                  mentor_writter = '".$postItems['writter']."';") or die ("NOT SAVED");
              die("Success");
            } catch (Exception $e) {
              die ("NOT SAVED");
            }

          /**
           *  When type isset at nul, it will create a new slot in the database to save a nul
           */
          } else if ($_POST['type'] == "nul") {
            try {
              $mysqli->query("INSERT INTO facie_data_nullen VALUES('".$postItems['id']."', '".$postItems['naam']."', '".$postItems['email']."', '".$postItems['woonplaats']."', '".$postItems['mobiel']."', '".$postItems['datum']."', '".$postItems['studie']."', '".$postItems['stukje']."', 'DSC0".$postItems['fotoNummer']."', '".$postItems['writter']."', '0', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."');") or die ("NOT SAVED");
              $mysqli->query("SELECT * FROM facie_data_nullen WHERE 
                  id = '".$postItems['id']."' &&
                  nul_naam = '".$postItems['naam']."' &&
                  nul_email = '".$postItems['email']."' &&
                  nul_woonplaats = '".$postItems['woonplaats']."' &&
                  nul_telefoon = '".$postItems['mobiel']."' &&
                  nul_datum = '".$postItems['datum']."' &&
                  nul_studie ='".$postItems['studie']."' &&
                  nul_stukje = '".$postItems['stukje']."' &&
                  nul_foto = '".$postItems['fotoNummer']."' &&
                  nul_writter = '".$postItems['writter']."';") or die ("NOT SAVED");
              die("Success");
            } catch (Exception $e) {
              die ("NOT SAVED");
            }
          } else {
            die ("Illegal access");
          }

        /**
         *  When mode isset at update
         */
        } else if ($_POST['mode'] == "update"){
          if ($_POST['type'] == "mentor") {
            $insertQuery = "UPDATE `facie_data_mentoren` SET `mentor_naam` = '".$postItems['naam']."', `mentor_email` = '".$postItems['email']."', `mentor_woonplaats` = '".$postItems['woonplaats']."', `mentor_telefoon` = '".$postItems['mobiel']."', `mentor_datum` = '".$postItems['datum']."', `mentor_studie` = '".$postItems['studie']."', `mentor_stukje` = '".$postItems['stukje']."', `mentor_foto` = '".$postItems['fotoNummer']."', ";
            $insertQuery .= ($postItems['writter'] == 2) ? "`checked` = '1', " : "";
            $insertQuery .= "`updated_at` = '".date('Y-m-d H:i:s')."' WHERE `id` = '".$postItems['id']."';";
            $mysqli->query($insertQuery) or die ("NOT SAVED");

            $mysqli->query("SELECT * FROM facie_data_mentoren WHERE 
                id = '".$postItems['id']."' &&
                mentor_naam = '".$postItems['naam']."' &&
                mentor_email = '".$postItems['email']."' &&
                mentor_woonplaats = '".$postItems['woonplaats']."' &&
                mentor_telefoon = '".$postItems['mobiel']."' &&
                mentor_datum = '".$postItems['datum']."' &&
                mentor_studie ='".$postItems['studie']."' &&
                mentor_stukje = '".$postItems['stukje']."' &&
                mentor_foto = '".$postItems['fotoNummer']."' &&
                mentor_writter = '".$postItems['writter']."';") or die ("NOT SAVED");

            die("Success");

          } else if ($_POST['type'] == "nul") {
            $insertQuery = "UPDATE `facie_data_nullen` SET `nul_naam` = '".$postItems['naam']."', `nul_email` = '".$postItems['email']."', `nul_woonplaats` = '".$postItems['woonplaats']."', `nul_telefoon` = '".$postItems['mobiel']."', `nul_datum` = '".$postItems['datum']."', `nul_studie` = '".$postItems['studie']."', `nul_stukje` = '".$postItems['stukje']."', `nul_foto` = '".$postItems['fotoNummer']."', ";
            $insertQuery .= ($postItems['writter'] == 2) ? "`checked` = '1', " : "";
            $insertQuery .= "`updated_at` = '".date('Y-m-d H:i:s')."' WHERE `id` = '".$postItems['id']."';";
            $mysqli->query($insertQuery) or die ("NOT SAVED");

            $mysqli->query("SELECT * FROM facie_data_nullen WHERE 
                id = '".$postItems['id']."' &&
                nul_naam = '".$postItems['naam']."' &&
                nul_email = '".$postItems['email']."' &&
                nul_woonplaats = '".$postItems['woonplaats']."' &&
                nul_telefoon = '".$postItems['mobiel']."' &&
                nul_datum = '".$postItems['datum']."' &&
                nul_studie ='".$postItems['studie']."' &&
                nul_stukje = '".$postItems['stukje']."' &&
                nul_foto = '".$postItems['fotoNummer']."' &&
                nul_writter = '".$postItems['writter']."';") or die ("NOT SAVED");

            die("Success");
          } else {
            die ("Illegal access");
          }
        } else {
          die ("Illegal access");
        }
      } else {
        die ("Illegal access");
      }
    } else {
      die ("Illegal access");
    }
  } catch (Expection $e) {
    die ("Unexpected error");
  }
?>