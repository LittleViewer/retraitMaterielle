<?php
require_once 'class/membre_class.php';
require_once 'class/db_pdo.php';
require_once 'class/utilitary_class.php';

$gestion_membre = new membre_class();
$gestion_pdo = new db_pdo();
$gestion_utilitary = new utilitary_class();

$urlEncode = urldecode(htmlspecialchars($_SERVER["REQUEST_URI"]));
$arrayUrl = explode("?value=", $urlEncode);
$arrayValue = explode("/d8dz8zdpp@", $arrayUrl[1]);

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    !empty(trim($_POST["nameMarque"])) &&
    !empty(trim($_POST["nameModele"])) &&
    !empty(trim($_POST["serialNumber"]))
) {
    $nomMarque = htmlspecialchars($_POST["nameMarque"]);
    $nomModele = htmlspecialchars($_POST["nameModele"]);
    $serialNumber = htmlspecialchars($_POST["serialNumber"]);

    $idAgent = $gestion_pdo->findUserbySerialNumberAndDate($arrayValue[2], $arrayValue[3]);
    $gestion_pdo->removeEntrybySerialNumberAndDate($arrayValue[2], $arrayValue[3], $idAgent);
    $idMarque = $gestion_pdo->marqueExist($nomMarque);
    $idModele = $gestion_pdo->modeleExist($nomModele, $idMarque);
    $gestion_pdo->new_retrait_appareil([$idMarque, $idModele, $serialNumber, $idAgent, $arrayValue[3]], "modify");

    header("Location: modify_entry.php?value=" . urlencode($nomMarque . "/d8dz8zdpp@" . $nomModele . "/d8dz8zdpp@" . $serialNumber . "/d8dz8zdpp@" . $arrayValue[3]));
    exit;
}

$title = 'Modification de l\'entrée';
require 'partials/header.php';
?>
<form method="POST" class="form-entry card">
    <label for="nameMarque">Marque:</label>
    <input type="text" id="nameMarque" value="<?php echo htmlspecialchars($arrayValue[0]); ?>" name="nameMarque"><br>
    <label for="nameModele">Modele:</label>
    <input type="text" id="nameModele" value="<?php echo htmlspecialchars($arrayValue[1]); ?>" name="nameModele"><br>
    <label for="serialNumber">Numéro de Serie:</label>
    <input type="text" id="serialNumber" value="<?php echo htmlspecialchars($arrayValue[2]); ?>" name="serialNumber"><br>
    <button type="submit">Enregistrer</button>
</form>
<?php require 'partials/footer.php';
