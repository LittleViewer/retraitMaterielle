<?php
require_once 'class/utilitary_class.php';
require_once 'class/membre_class.php';

$gestion_utilitary = new utilitary_class();
$gestion_membre = new membre_class();

$urlEncode = htmlspecialchars($_SERVER["REQUEST_URI"]);
$arrayName = $gestion_utilitary->decodeDefineVariable($urlEncode, 2);

$title = 'Historique';
require 'partials/header.php';

echo "<div class='card'>";
$gestion_membre->find_historic($arrayName[0], $arrayName[1]);
echo "</div>";

echo "<br><a href='list_agent.php' class='btn-link'>Retour</a>";

require 'partials/footer.php';
