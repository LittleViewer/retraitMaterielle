<html>
    <!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <title>Historique en PDF</title>
         <link rel="stylesheet" href="style/basic.css"> 
    </head>

<?php
    require_once 'class/membre_class.php';
    require_once 'class/utilitary_class.php';
    
    $gestion_membre = new membre_class();
    $gestion_utilitary = new utilitary_class();
    
try {
    $gestion_utilitary->header_generator_automatic();
    $gestion_membre->formAndExecutePdfHistoricUser();

} catch (Exception) {
    echo "Il semblent y avoir un soucis!";
}

