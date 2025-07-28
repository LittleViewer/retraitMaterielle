<?php

class autoloading_include {
    
    private $instanceClass;
    
    
    /**
     * Permet d'initialiser l'ensemble de la fonction de la classe
     * @param string $dir
     * @see ScanDir()
     * @see requireAutomatic()
     */
    public function __construct($dir= null) {
        $foldClassArray  = $this->scandDir($dir);
        
        $this->instanceClass = $this->requireAutomatic($foldClassArray, $dir);
        
        $this->returnInstance();
            }

   /**
    * Trouve dynamiquement tout les fichier de classe php
    * @param string $dir
    */
    private function scandDir($dir) {
        if (isset($dir)) {

            $dirProper = [];
            $output = scandir($dir);

            foreach ($output as $fold) {

                if ($fold != "." AND $fold != ".." && $fold != "autoloading_include.php") {
                    $foldArray = explode(".", $fold);
                    if (count($foldArray) === 2 && $foldArray[1] === "php" && is_readable($dir.$fold)) {

                        array_push($dirProper, $fold);
                    }
                }
            }
        }
        return $dirProper;
    }
    
    /**
     * Permet traiter l'ensemble des nom de fichier pour construire des require
     * @param array $foldClassArray
     * @param stirng $dir
     * @return array
     */
    private function requireAutomatic($foldClassArray, $dir) {
        $instanceClass = [];
        $requireArray = [];
        $className = [];
        
        foreach ($foldClassArray as $class) {
            
            $arrayClass = explode(".", $class);
            array_push($className, $arrayClass[0]);
            if (is_null($dir)) {
              array_push($requireArray, "require_once $class;");
              array_push($instanceClass, '$'."$arrayClass[0]".'_gestion = new '."$arrayClass[0]".'();');
        } else {
            array_push($requireArray, "require_once '$dir$class';");
            array_push($instanceClass, '$'."$arrayClass[0]".'_gestion = new '."$arrayClass[0]".'();');
        }
        
    } 
    return [$instanceClass,$requireArray, $className];
    }
    

    
    /**
     * Returne tout les information de l'instanciaiton des classe
     * @return array
     */
    public function returnInstance() {
        return $this->instanceClass;
    }
    
    
    /**
     * Retourne l'ensemble des objet en array dont il faut selectionner les obj afin de les executer;
     * @return array
     */
    public function executeInstance() {
            $variableInstance = [];

            foreach ($this->instanceClass[1] as $require) {
                eval($require);
            }
            
            foreach ($this->instanceClass[0] as $instance) {
                array_push($variableInstance, eval("return $instance"));
            }
            return $variableInstance;
    }
    
}
