<?php

class autoloading_include {
    
    private $instanceClass;
    private $code;
    private $arrayClass;
    
    public function __construct($dir= null) {
        $foldClassArray  = $this->scandDir($dir);
        
        $this->instanceClass = $this->requireAutomatic($foldClassArray, $dir);
        
        
        $this->code = function ($instanceClass, $requireClass) {
            $variableInstance = [];
            foreach ($requireClass as $require) {
                eval($require);
            }
            
            foreach ($instanceClass as $instance) {
                array_push($variableInstance, eval("return $instance"));
            }
            return $variableInstance;
        };
        
        
    }

    private function scandDir($dir) {
        if (isset($dir)) {

            $dirProper = [];
            $output = scandir($dir);

            foreach ($output as $fold) {

                if ($fold != "." AND $fold != ".." && $fold != "autoloading_include.php") {
                    $foldArray = explode(".", $fold);
                    if (count($foldArray) === 2 && $foldArray[1] === "php" && is_readable($fold)) {

                        array_push($dirProper, $fold);
                    }
                }
            }
        }
        return $dirProper;
    }
    
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
    
    public function returnCode() {
        return $this->code;
    }
    public function returnInstance() {
        return $this->instanceClass;
    }
}
