<?php
  header('Cache-Control: no-cache, must-revalidate'); //No-cache zorgt dat de JSON array elke keer opnieuw wordt geladen.
  header('Expires: Mon, 26 Jul 1990 05:00:00 GMT');
  header('Content-type: application/json'); //content type van de pagina wordt van PHP naar JSON veranderd.
  
  require_once("../../login/classes/Login.php");
  require_once("../../config.php");
  
  $login = new Login();
  // ... ask if we are logged in here:
  if ($login->isUserLoggedIn() == false) {
    if (isset($_GET['facebook']) && !empty($_GET['facebook']) && !isset($_GET['table'])) {
     
    } else if ($_SERVER['REMOTE_ADDR'] == $_SERVER['SERVER_ADDR']) {

    } else {
      die ("Access denied");
    }
  }

 function createQuery($table, $q, $starting, $add) {
    global $mysqli;

    $getTableFields = $mysqli->query("SELECT * FROM ".$table);
    $query = $starting;

    while ($fields = mysqli_fetch_field($getTableFields)) {
      $query .= $fields->name." LIKE '%".$q."%' OR ";
    }
    $query = substr($query, 0, -3);
    $query .= ($add) ? ")" : "";
    return $mysqli->query($query);
  }

  if ( isset($_GET['table']) && !empty($_GET['table']) ) {
    if (isset($_GET['written']) && !empty($_GET['written'])) {
      if ($_GET['written'] == "true") {
        if ( isset($_GET['query']) && !empty($_GET['query'])) {
          $tableQuery = createQuery($_GET['table'], $_GET['query'], "SELECT * FROM ".$_GET['table']." WHERE ", false);
        } else {
          $key = explode("_", $_GET['table']);
          $orderBy = ($key[2] == "nullen") ? "nul" : "mentor";
          $tableQuery = $mysqli->query("SELECT * FROM ".$_GET['table']." ORDER BY `".$orderBy."_naam`");
        }
      } 
      if ($_GET['written'] == "false") {
        if ( isset($_GET['query']) && !empty($_GET['query'])) {
          $key = explode("_", $_GET['table']);
          $tableQuery = createQuery($_GET['table'], $_GET['query'], "SELECT * FROM ".$_GET['table']." WHERE id NOT IN (SELECT id FROM `facie_data_".$key[2]."`) AND (", true);
        } else {
          $key = explode("_", $_GET['table']);
          $orderBy = ($key[2] == "nullen") ? "nul" : "mentor";
          $tableQuery = $mysqli->query("SELECT * FROM ".$_GET['table']." WHERE id NOT IN (SELECT id FROM `facie_data_".$key[2]."`) ORDER BY `export_".$orderBy."_naam`") or die($mysqli->error);
        }
      }
    }
    
    $json = '{ "result": [';
      while($result = $tableQuery->fetch_array(MYSQLI_ASSOC)) {
        $json .= '{';
          foreach ($result as $key => $value) {
            $key = explode("_", $key);
            $json .= '"'.$key[count($key) - 1].'" : "'.htmlentities($value, ENT_QUOTES).'",';
          }
          $json = substr($json, 0, -1);
        $json .= '},';
      }
      $json = ($json != '{ "result": [') ? $json = substr($json, 0, -1) : $json;
    $json .= '] }';
    

  } else if (isset($_GET['facebook']) && !empty($_GET['facebook'])) {

    $tableQuery = $mysqli->query("SELECT * FROM facie_leden WHERE lid_gebruikersnaam = '".$_GET['facebook']."'") or die ($mysqli->error);
    $json = '{ "result": "';
    while($result = $tableQuery->fetch_array(MYSQLI_ASSOC)) {
       $json .= $result['lid_facebook'];
    }
    $json .= '" }';
  }
  echo $json;
?>