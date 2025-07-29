<?php
/**
 * Classe contenent un ensemble de fonction visant à simplifier le code de manière global
 * 
 * @author Mathys
 * @version 1.0.0
 * @see tFPDF
 */

class utilitary_class {
    /**
     * génération automatiser d'un header avec des mots exclus
     * 
     */
    private $exceptionExtend;
    
    public function __construct() {
        require_once 'exceptionExtend.php';
        $this->exceptionExtend = new exceptionExtend();
    }
    
    function header_generator_automatic() {

        echo "<header><center><h1>Retrait de Service</h1><br>";
        $arrayDir = scandir("./");

        foreach ($arrayDir as $document) {
            if ($document != "." AND $document != ".." AND $document != "class" AND $document != "historic_agent.php"
                    AND $document != "test.php" AND $document != "modify_entry.php" AND $document != "style"
                    AND $document != "latex" AND $document != "Doxyfile") {
                $arrayDocument = explode(".php", $document);
                if ($document != "index.php") {
                    echo "<a href='" . $document . "'>" . $arrayDocument[0] . "</a> ";
                } else {
                    echo "<a href='" . $document . "'>retrait_materielle</a>  ";
                }
            }
        }
        echo "</center></header>";
    }
    /**
     * Vérificateur via division
     * @param int $value c'est la valeur divisible
     * @param int $divisor c'est le diviseur
     * @return string
     * @deprecated Possible erreur dans certain cas d'utilisation
     */
    function divisor_check($value, $divisor) {
        $calculCheck = $value / $divisor;

        $arrayCalculCheck = explode(".", $calculCheck);

        if (count($arrayCalculCheck) >= 2) {
            return "true";
        } else {
            return "false";
        }
    }
    
    /**
     * A partir d'un texte fournit et de la variable objet FPDF construit un pdf de manière dynamique
     * /Part page: 52 lignes de 75 caractères
     * /Ne coupe pas les mots mais les gére dynamiquement
     * @param str $text Contient le texte à transformer en pdf
     * @param FPDF $pdf contient l'objet instancier FDPF
     * @return bool
     */
    function textCellFPDF($text, $pdf) {
        
        $arrayLine = null;
        if (gettype($text) === "string") {
            $arrayLine = [];
            $singleLine = null;
            $limitLine = 75;
            $textProper = iconv("UTF-8", "ASCII//TRANSLIT", htmlspecialchars(trim($text)));
            $number = strlen($textProper);

            $arrayWordCut = explode(" ", $textProper);
            $lastWordArray = $arrayWordCut[count($arrayWordCut) - 1] . " " . "finishtime";

            foreach ($arrayWordCut as $word) {
                if (!is_null($singleLine)) {
                    $numberCharacterSingleLine = strlen($singleLine);
                } else {
                    $numberCharacterSingleLine = 0;
                }
                $wordWithSpace = $word . " ";
                if (($numberCharacterSingleLine + strlen($wordWithSpace)) < 76 && $word . " " . "finishtime" != $wordWithSpace && $word != "(jumpLine)") {
                    $singleLine = $singleLine . $wordWithSpace;
                } elseif ($word === "(jumpLine)") {
                    array_push($arrayLine, $singleLine);

                    $singleLine = null;
                } elseif ($word . " " . "finishtime" === $lastWordArray) {
                    $lastWordArray = explode("finishtime", $lastWordArray);
                    array_push($arrayLine, $lastWordArray[0]);
                } else {
                    array_push($arrayLine, $singleLine);
                    $singleLine = null;
                }
            }
        } elseif (!is_null($arrayLine)) {
            echo "Mauvais Format";
            return false;
        }

        $linePerPage = 52;
        if (!is_null($arrayLine)) {
            $numberLine = (count($arrayLine));

            if ($numberLine <= 1) {
                $pdf->Cell(40, 5, ($arrayLine[0]));
                $pdf->ln();
            } else {
                for ($i = 0; $i <= ($numberLine - 1); $i++) {
                    $pdf->Cell(40, 5, ($arrayLine[$i]));
                    $pdf->ln();
                    if ($linePerPage === $i) {
                        $pdf->AddPage();
                        $pdf->SetFont('Arial', 'B', 12);
                        $linePerPage = $linePerPage + 53;
                    }
                }
            }
        } else {
            return false;
        }
    }

    /**
     * Automatise l'ouverture, et la lecture d'un document 
     * @param string $dir emplacement du fichier à lire
     * @return string
     */
    function readText($dir) {
        if (filesize($dir) != 0) {
            if (file_exists($dir) && is_readable($dir)) {
                $handle = fopen($dir, "r");
                $text = fread($handle, filesize($dir));
                fclose($handle);

                return htmlspecialchars($text);
            } else {
                return "false";
            }
        } else {
            echo "Il semblent n'y avoir eux aucun appareils retirer sur service!";
        }
    }
    
    /**
     * Permet de géré la récupération de potentielle vairable dans une urls sachant que la zone variable est ouverte avec "?value" et que chaque variable doivent être séparer part "placeholder"
     * @param string $urlEncode
     * @param integer $numberVar
     * @return array
     * @see errorExtend()
     */
    function decodeDefineVariable($urlEncode, $numberVar) {
                $arrayUrl = explode("?value=", $urlEncode);
                
                $arrayUrl = $this->exceptionExtend->variableNotDefineHistoricUser($arrayUrl,$numberVar);
                 return $arrayUrl;
                
    }
}
