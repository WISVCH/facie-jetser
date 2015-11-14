<?php
  header('Cache-Control: no-cache, must-revalidate'); //No-cache zorgt dat de JSON array elke keer opnieuw wordt geladen.
  header('Expires: Mon, 26 Jul 1990 05:00:00 GMT');
  header('Content-type: application/json'); //content type van de pagina wordt van PHP naar JSON veranderd.
  
  require_once("../../login/classes/Login.php");
  require_once("../../config.php");

  $login = new Login();
  // ... ask if we are logged in here:
  if ($login->isUserLoggedIn() == false) {
      header("Location: /faciejetser/login.php");
  }  
  $sql_nullen = $mysqli->query("SELECT * FROM facie_export_nullen") or die($mysqli->error);
  $sql_mentoren = $mysqli->query("SELECT * FROM facie_export_mentoren") or die($mysqli->error);

  $sql_written_nullen = $mysqli->query("SELECT * FROM facie_data_nullen") or die($mysqli->error);
  $sql_written_mentoren = $mysqli->query("SELECT * FROM facie_data_mentoren") or die($mysqli->error);


  $sql_leden = $mysqli->query("SELECT * FROM facie_leden ORDER BY id ASC") or die($mysqli->error);
  while($result = $sql_leden->fetch_array(MYSQLI_ASSOC)) {
    $array_leden[] = $result['lid_naam'];
  }
  $json = '{"result": {
    "total_nullen" : '.$sql_written_nullen->num_rows.',
    "total_mentoren" : '.$sql_written_mentoren->num_rows.',
    "togo_nullen" : '.$sql_nullen->num_rows.',
    "togo_mentoren" : '.$sql_mentoren->num_rows.',
    "leden" : [';
        foreach($array_leden as $key => $value) {
          $sql_lid_nullen = $mysqli->query("SELECT * FROM facie_data_nullen WHERE nul_writter = '".($key + 1)."'") or die($mysqli->error);
          $sql_lid_mentoren = $mysqli->query("SELECT * FROM facie_data_mentoren WHERE mentor_writter = '".($key + 1)."'") or die($mysqli->error);
          $json .= "{";
            $json .= '"naam": "'.$value.'",';
            $json .= '"aantal": "'.($sql_lid_nullen->num_rows + $sql_lid_mentoren->num_rows).'"';
          $json .= "},";
        }
        $json = substr($json, 0, -1);
    $json .= ']}}';

  echo $json;

