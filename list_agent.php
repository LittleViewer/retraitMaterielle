<head>
        <meta charset="UTF-8">
        <title>Liste des Agents</title>
         <link rel="stylesheet" href="style/basic.css"> 
</head>
<?php
include_once 'class/utilitary_class.php';
include_once 'class/membre_class.php';

$gestion_utilitary = new utilitary_class();
$gestion_membre = new membre_class();

$gestion_utilitary->header_generator_automatic();

$listAgent = $gestion_membre->member_find();
$numberAgent =  count($listAgent[0]);
echo "<ul>";
for($i=0; $i <= ($numberAgent-1); $i++) {
    echo "<li><a href='historic_agent.php?value=". urlencode($listAgent[0][$i]."placeholder".$listAgent[1][$i])."'>".$listAgent[0][$i]." ".$listAgent[1][$i]."</a><br>";
}

?>
</li>
</ul>

<form method="POST" name="formNewAgent">
    <b>Vous n'y apparaisser pas ?(*)</b><br>
    Inscriver vous!<br>
    Prenom:
    <input type="text" name="prenomAgent" placeholder="prenom"><br>
    Nom de famille:
    <input type="text" name="nomAgent" placeholder="nom"><br>
    Role:
<?php
    $gestion_membre->selectRoleAgent();
?>
    <input type="submit">
<br><i>(*)Si vous souhaitez rentrer un appareil, il faut vous inscrire ici. </form>
<?php
$gestion_membre->agentExist([htmlspecialchars($_POST["nomAgent"]), htmlspecialchars($_POST["prenomAgent"]), $_POST["roleAgent"]]);



