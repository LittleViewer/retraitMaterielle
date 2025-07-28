<head>
        <meta charset="UTF-8">
        <title>Historique</title>
         <link rel="stylesheet" href="style/basic.css"> 
</head>
<?php
require_once 'class/utilitary_class.php';
$gestion_utilitary = new utilitary_class();
$gestion_utilitary->header_generator_automatic();

require_once 'class/membre_class.php';

$gestion_membre = new membre_class();
$urlEncode = htmlspecialchars($_SERVER["REQUEST_URI"]);

$arrayName = $gestion_utilitary->decodeDefineVariable($urlEncode, 2);

$gestion_membre->find_historic($arrayName[0], $arrayName[1]);


echo "<br><a href='list_agent.php'>Retour</a>";