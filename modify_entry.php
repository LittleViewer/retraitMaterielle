<head>
        <meta charset="UTF-8">
        <title>Modification de l'entrée</title>
         <link rel="stylesheet" href="style/basic.css"> 
</head>
<?php
require_once 'class/utilitary_class.php';
$gestion_utilitary = new utilitary_class();
$gestion_utilitary->header_generator_automatic();
echo "<form method='Post'>";
require_once 'class/membre_class.php';
require_once 'class/db_pdo.php';

$gestion_membre = new membre_class();
$gestion_pdo = new db_pdo();

$urlEncode = urldecode(htmlspecialchars($_SERVER["REQUEST_URI"]));
$arrayUrl = explode("?value=", $urlEncode);

$arrayValue = explode("/d8dz8zdpp@", $arrayUrl[1]);
echo "Marque: <input type='text' value='$arrayValue[0]' name='nameMarque'><br>";
echo "Modele: <input type='text' value='$arrayValue[1]' name='nameModele'><br>";
echo "Numéro de Serie: <input type='text' value='$arrayValue[2]' name='serialNumber'><br>";
echo "<input type='submit'>";

if (empty(trim($_POST["nameMarque"])) || empty(trim($_POST["nameModele"])) || empty(trim($_POST["serialNumber"]))) {
    echo "<footer>Il semblent y a voir des erreur</footer></form>";
} else {
    echo "</form>";
    $nomMarque = htmlspecialchars($_POST["nameMarque"]);
    $nomModele = htmlspecialchars($_POST["nameModele"]);
    $serialNumber = htmlspecialchars($_POST["serialNumber"]);

    $idAgent = $gestion_pdo->findUserbySerialNumberAndDate($arrayValue[2], $arrayValue[3]);
    $gestion_pdo->removeEntrybySerialNumberAndDate($arrayValue[2], $arrayValue[3], $idAgent);
    $idMarque = $gestion_pdo->marqueExist(htmlspecialchars($nomMarque));
    $idModele = $gestion_pdo->modeleExist(htmlspecialchars($nomModele), $idMarque);
    $gestion_pdo->new_retrait_appareil([$idMarque, $idModele, $serialNumber, $idAgent, $arrayValue[3]], "modify");

    header("Location: modify_entry.php?value=" . urlencode($nomMarque . "/d8dz8zdpp@" . $nomModele .
                    "/d8dz8zdpp@" . $serialNumber . "/d8dz8zdpp@" . $arrayValue[3]) . ".php");
}
