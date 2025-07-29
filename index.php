<!DOCTYPE html>
<?php
    try {
            date_default_timezone_set("Europe/Paris");
            include_once 'class/db_pdo.php';
            include_once 'class/utilitary_class.php';
            $gestion_pdo = new db_pdo();
            $gestion_utilitary = new utilitary_class();
            ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Nouvelle Entrée</title>
         <link rel="stylesheet" href="style/basic.css"> 
    </head>
    
   <?php
    $gestion_utilitary->header_generator_automatic();
   ?>
    
    <body>
        <form method="POST">
            Marque:
            <input type="text" name="marque" placeholder="Nom de Marque"><br>
            Modele:
            <input type="text" name="modele" placeholder="Nom de Modele"><br>
            Numéros de Serie: 
            <input name="serialNumber" type="text" required><br>
            Agent:
            <?php
                $gestion_pdo->selectFormAgent();
            ?>  
            <input type="submit"><br>
       
        
        
        <?php
            
            $nameAgentEncode = htmlspecialchars($_POST["agentSelect"]);
            $nameArrayDecode = explode("placeholder", $nameAgentEncode);
            $nomAgent = $nameArrayDecode[0];
            $prenomAgent = $nameArrayDecode[1];

            $idMarque = $gestion_pdo->marqueExist(htmlspecialchars($_POST["marque"]));
            $idModele = $gestion_pdo->modeleExist(htmlspecialchars($_POST["modele"]), $idMarque);
            $idAgent = $gestion_pdo->gestion_agent(htmlspecialchars($prenomAgent), htmlspecialchars($nomAgent));
            $today = date("Y-m-d H:i:s");
            $gestion_pdo->new_retrait_appareil([$idMarque, $idModele, htmlspecialchars($_POST["serialNumber"]), $idAgent, $today], "add");

            $gestion_pdo->footerNewEntryGenerator(htmlspecialchars($_POST["marque"]), htmlspecialchars($_POST["modele"]), htmlspecialchars($_POST["serialNumber"]), $today);
        } catch (Exception $ex) {
            echo "Il semblent y avoir eux une erreur  </form>";
        }
        ?>
    </body>
    
    
</html>