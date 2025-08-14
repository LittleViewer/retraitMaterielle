<?php
require_once 'class/membre_class.php';

$gestion_membre = new membre_class();
$listAgent = $gestion_membre->member_find();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gestion_membre->agentExist([
        htmlspecialchars($_POST["nomAgent"]),
        htmlspecialchars($_POST["prenomAgent"]),
        $_POST["roleAgent"]
    ]);
}

$title = 'Liste des Agents';
require 'partials/header.php';
?>
<ul class="agent-list card">
<?php
$numberAgent = count($listAgent[0]);
for ($i = 0; $i <= ($numberAgent - 1); $i++) {
    echo "<li><a href='historic_agent.php?value=" . urlencode($listAgent[0][$i] . "placeholder" . $listAgent[1][$i]) . "'>" . $listAgent[0][$i] . " " . $listAgent[1][$i] . "</a></li>";
}
?>
</ul>

<form method="POST" name="formNewAgent" class="form-agent mt-3 card">
    <p><strong>Vous n'y apparaissez pas ?(*)</strong></p>
    <p>Inscrivez-vous!</p>
    <label for="prenomAgent">Prenom:</label>
    <input type="text" id="prenomAgent" name="prenomAgent" placeholder="prenom"><br>
    <label for="nomAgent">Nom de famille:</label>
    <input type="text" id="nomAgent" name="nomAgent" placeholder="nom"><br>
    <label for="roleAgent">Role:</label>
    <?php $gestion_membre->selectRoleAgent(); ?><br>
    <button type="submit">Valider</button>
    <p><i>(*)Si vous souhaitez rentrer un appareil, il faut vous inscrire ici.</i></p>
</form>
<?php require 'partials/footer.php';
