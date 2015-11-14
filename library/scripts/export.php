<?php
  require_once("../../login/classes/Login.php");
  require_once("../../config.php");

  $login = new Login();
  // ... ask if we are logged in here:
  if ($login->isUserLoggedIn() == false) {
    header("Location: /faciejetser/login.php");
  }

  header('Content-Type: application/excel');
  header('Content-Disposition: attachment;filename="sample.csv"');

  $fileData = array();

  $data = file_get_contents("http://".$_SERVER['SERVER_ADDR']."/faciejetser/library/scripts/api.php?table=".$_GET['table']."&written=true");
  $jsonDecode = json_decode($data, true);

  $chunkArray = array_chunk($jsonDecode['result'], $_GET['size']);

  $firstRow = "";
  for ($i = 1; $i <= $_GET['size'] ; $i++) { 
    $firstRow .= "naam".$i.";email".$i.";woonplaats".$i.";telefoon".$i.";datum".$i.";studie".$i.";stukje".$i.";@foto".$i.";";
  }
  array_push($fileData, $firstRow);
  foreach ($chunkArray as $row) {
    $rowData = "";
    foreach($row as $item) {
      $rowData .= html_entity_decode($item['naam'], ENT_QUOTES).";".html_entity_decode($item['email'], ENT_QUOTES).";".html_entity_decode($item['woonplaats'], ENT_QUOTES).";".html_entity_decode($item['telefoon'], ENT_QUOTES).";".html_entity_decode($item['datum'], ENT_QUOTES).";".html_entity_decode($item['studie'], ENT_QUOTES).";".html_entity_decode($item['stukje'], ENT_QUOTES).";H:\\Desktop\\export\\".html_entity_decode($item['foto'], ENT_QUOTES).".png;";
    }
    array_push($fileData, $rowData);
  }

  $fp = fopen("php://output", "w");
  foreach ($fileData as $line) {
    $val = explode(";", $line);
    fputcsv($fp, $val, ";");
  }
  fclose($fp);