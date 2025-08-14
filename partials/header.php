<?php
if (!isset($gestion_utilitary)) {
    require_once __DIR__ . '/../class/utilitary_class.php';
    $gestion_utilitary = new utilitary_class();
}
?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($title ?? 'Retrait de Service'); ?></title>
    <link rel="stylesheet" href="style/basic.css">
</head>
<body>
<?php $gestion_utilitary->header_generator_automatic(); ?>
<main class="container">
