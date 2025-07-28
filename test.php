<?php
require_once 'class/autoloading_include.php';


$autoRequire = new autoloading_include("class/"); //
$code = $autoRequire->returnCode();
$instance = $autoRequire->returnInstance();
$output = $code($instance[0], $instance[1], $instance[2]);
var_dump($output[0]);
var_dump($output[0]->test_connect());