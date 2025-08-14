<?php
require_once 'class/db_pdo.php';

date_default_timezone_set("Europe/Paris");
$gestion_pdo = new db_pdo();
$successMessage = '';

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    !empty($_POST['marque']) &&
    !empty($_POST['modele']) &&
    !empty($_POST['serialNumber'])
) {
    $nameAgentEncode = htmlspecialchars($_POST["agentSelect"]);
    $nameArrayDecode = explode("placeholder", $nameAgentEncode);
    $nomAgent = $nameArrayDecode[0];
    $prenomAgent = $nameArrayDecode[1];

    $idMarque = $gestion_pdo->marqueExist(htmlspecialchars($_POST["marque"]));
    $idModele = $gestion_pdo->modeleExist(htmlspecialchars($_POST["modele"]), $idMarque);
    $idAgent = $gestion_pdo->gestion_agent(htmlspecialchars($prenomAgent), htmlspecialchars($nomAgent));
    $today = date("Y-m-d H:i:s");
    $gestion_pdo->new_retrait_appareil([$idMarque, $idModele, htmlspecialchars($_POST["serialNumber"]), $idAgent, $today], "add");
    $successMessage = $gestion_pdo->footerNewEntryGenerator(
        htmlspecialchars($_POST["marque"]),
        htmlspecialchars($_POST["modele"]),
        htmlspecialchars($_POST["serialNumber"]),
        $today
    );
}

$title = 'Nouvelle Entrée';
require 'partials/header.php';
?>
<form method="POST" class="form-entry card">
    <label for="marque">Marque:</label>
    <input type="text" id="marque" name="marque" placeholder="Nom de Marque"><br>
    <label for="modele">Modele:</label>
    <input type="text" id="modele" name="modele" placeholder="Nom de Modele"><br>
    <label for="serialNumber">Numéros de Serie:</label>
    <input id="serialNumber" name="serialNumber" type="text" required><br>
    <label for="agentSelect">Agent:</label>
    <?php $gestion_pdo->selectFormAgent(); ?><br>
    <button type="submit">Enregistrer</button>
</form>
<?php
if ($successMessage) {
    echo $successMessage;
}
require 'partials/footer.php';
