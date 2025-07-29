<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

class generateKey {

    private $encryptionKey;

    public function __construct($stringUnchiffred = null) {

        if (!is_null($stringUnchiffred)) {
            $this->findEnvKey();
            $this->chiffredPageDev($stringUnchiffred);
        }
    }

    private function findEnvKey() {

        $dotenv = Dotenv::createImmutable(__DIR__ . "/env");
        $dotenv->safeLoad();
        $encryptionKey = $_ENV['APP_SECRET'] ?? throw new Exception("Clé manquante");
        $this->encryptionKey = $encryptionKey;
    }

    private function chiffredString($stringUnchiffred) {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

        $textChiffred = openssl_encrypt($stringUnchiffred, 'aes-256-cbc', $this->encryptionKey, 0, $iv);

        $textEncode = base64_encode($iv . $textChiffred);
        return $textEncode;
      
    }
    
    public function chiffredPageDev($stringUnchiffred) {
        $explodePath = explode("/", $stringUnchiffred);
        if (count($explodePath) === 2) {
            $arrayPath = explode(".", $explodePath[1]);
            if ($arrayPath[1] === "php" && count($arrayPath) === 2) {
                $stringChiffred = $this->chiffredString($stringUnchiffred);
                $pathNewNotFolder = $arrayPath[0].".".$stringChiffred.".php";
                $pathNew = $explodePath[0]."/".$pathNewNotFolder;
                
                
                $keyPossible = array_search($pathNew, scandir($explodePath[0]."/"));
                var_dump(($keyPossible));
                echo "class/".$explodePath[1]." ";
                echo "class/".$pathNewNotFolder;
                if ($keyPossible === false) {
                    rename("class/".$explodePath[1], "class/".$pathNewNotFolder);
                }
                var_dump($keyPossible);
                
            }
        }
    }
}
