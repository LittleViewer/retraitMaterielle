<?php
require_once 'class/db_pdo.php';
$gestion_pdo = new db_pdo();

$urlEncode = htmlspecialchars($_SERVER["REQUEST_URI"]);
$arrayUrl = explode("value=", $urlEncode);

if ($arrayUrl[1]==="delete") {
    $gestion_pdo->removeEntrybySerialNumberAndDate($arrayUrl[2], $arrayUrl[3], $arrayUrl[4]);
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
}