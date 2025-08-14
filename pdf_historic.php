<?php
require_once 'class/membre_class.php';
require_once 'class/utilitary_class.php';

$gestion_membre = new membre_class();
$gestion_utilitary = new utilitary_class();

$title = 'Historique en PDF';
require 'partials/header.php';

echo "<div class='card'>";
try {
    $gestion_membre->formAndExecutePdfHistoricUser();
} catch (Exception $e) {
    echo "Il semblent y avoir un soucis!";
}
echo "</div>";

require 'partials/footer.php';
