<?php

function getInstanceByClass(array $instances, string $className) {
    foreach ($instances as $obj) {
        if ($obj instanceof $className) {
            return $obj;
        }
    }
    return null; // Si aucun objet trouvé
}

require_once 'class/autoloading_include.php';


$autoRequire = new autoloading_include("class/");
$code = $autoRequire->returnCode();
$instance = $autoRequire->returnInstance();
$output = $code($instance[0], $instance[1], $instance[2]);

$pdo_gestion = getInstanceByClass($output, "db_pdo");

$pdo_gestion->connect_static;

