<?php
require_once 'mardukCore/autoloading_include.php';


$autloading = new autoloading_include("class/");
$output = $autloading->executeInstance();

var_dump($output[0]->test_connect());