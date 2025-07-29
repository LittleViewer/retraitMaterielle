<?php

class verifyClass {

    private $autoLoading;
    private $reconstructPath;
    private $contentClass;
    private $arraySecure;

    public function __construct($dir = "class/") {
        require_once 'autoloading_include.php';
        $this->autoLoading = new autoloading_include();
        $this->reconstructFold($dir);
        $this->recoverContentClass();
        $this->searchSpecificValue();
    }

    private function reconstructFold($dir) {
        $reconstructPath = [];

        $nameClass = $this->autoLoading->viewInstance(2);

        foreach ($nameClass as $class) {
            array_push($reconstructPath, $dir . $class . ".php");
        }
        $this->reconstructPath = $reconstructPath;
    }

    private function recoverContentClass() {
            
    }

    private function searchSpecificValue() {

        }
}
