<?php

/**
 * Classe contenent un ensemble de fonction visant à la gestion de tous qui résulte de manière non générique des membres
 * 
 * @author Mathys
 * @version 1.0.0
 * @see tFPDF
 * @see utilitary_class.php
 * @see db_pdo.php
 */
class membre_class {

    private $dbh;

    /**
     * Ouvre une connection statique vers la base de données du projet
     * 
     * @return obj
     */
    function connect_static() {

        $path = "class/mdpstatic";

        $handle = fopen($path, "r");

        $value = fread($handle, filesize($path));

        fclose($handle);

        $this->dbh = new PDO("mysql:host=localhost;dbname=retrait", "user", base64_decode($value));

        return $this->dbh;
    }
    
    function connectToClassExpendException() {
        require_once 'class/exceptionExtend.php';
        $exceptionExtend = new errorExtend();
        return $exceptionExtend;
    }

    /**
     * Vas chercher l'ensemble des utilisateurs de la table agent
     * @see connect_static()
     * @return array
     */
    function member_find() {

        include_once 'class/db_pdo.php';

        $this->connect_static();

        $query = "SELECT nom, prenom FROM agent";

        $sth = $this->dbh->prepare($query);

        for ($i = 0; $i <= 1; $i++) {

            $sth->execute();

            $result = $sth->fetchAll(PDO::FETCH_COLUMN, $i);

            if ($i == 0) {

                $listArrayPrenomAgent = $result;
            } else {

                $listArrayNomAgent = $result;
            }
        }

        return [$listArrayPrenomAgent, $listArrayNomAgent];
    }

    /**
     * Trouve l'ensemble des appareils retirer part ub agent
     * 
     * @see connect_static()
     * @see db_pdo
     * @param string $prenomAgent prenom de l'agent
     * @param string $nomAgent nom de l'agebt
     */
    function find_historic($prenomAgent, $nomAgent) {

        require_once 'db_pdo.php';
        $numfmt = numfmt_create('fr_FR', NumberFormatter::SPELLOUT);

        $gestion_pdo = new db_pdo();

        $this->connect_static();

        $query = "SELECT ID FROM agent WHERE prenom='" . htmlspecialchars($nomAgent) . "' AND nom='" . htmlspecialchars($prenomAgent) . "';";

        $sth = $this->dbh->prepare($query);

        $sth->execute();

        $output = $sth->fetchAll();

        $idAgent = $output[0][0];

        $sth = null;

        $query = "SELECT * FROM appareil WHERE idAgent=" . $idAgent . ";";

        $sth = $this->dbh->prepare($query);

        $appareilArray = [];

        $sth->execute();

        $output = $sth->fetchAll(PDO::FETCH_NUM);

        $numberArray = count($output);

        $compteur = 0;

        for ($i = 0; $i <= ($numberArray - 1); $i++) {

            echo "<li><a href='modify_entry.php?value=" . urlencode($gestion_pdo->find_marque($output[$i][1]) . "/d8dz8zdpp@" . $gestion_pdo->find_modele($output[$i][2]) .
                    "/d8dz8zdpp@" . $output[$i][3] . "/d8dz8zdpp@" . $output[$i][5]) . "'>L'appareil de marque " . $gestion_pdo->find_marque($output[$i][1]) . "  ";

            echo " de modele " . $gestion_pdo->find_modele($output[$i][2]) .
            " dont le numéro de serie est " . $output[$i][3] .
            " entrer à la date du " . $output[$i][5] . "</a> <a href=tmpFold.php?value=deletevalue=" . $output[$i][3] . "value=" . $output[$i][5] . "value=" . $idAgent . ">Supprimer!</a><br>";

            $compteur++;
        }

        if ($compteur === 0) {

            echo "<b>l'Agent n'as pour l'instant retirer aucun appareil du service</b>";
        } else {
            $compteurSpellOut = numfmt_format($numfmt, $compteur);
            echo "<b>Au total l'agent à retirer du service $compteurSpellOut appareils</b>";
        }
    }

    /**
     * Une classe qui récupére toutes lignes de la classe role_agent afin que durent l'ajout d'un utilisateur ils puissent donner définir sont role
     * A partir d'un <select> dynamique
     * @see connect_static()
     * @return HTML  
     */
    function selectRoleAgent() {
        $this->connect_static();
        $query = "SELECT * FROM role_agent;";

        $sth = $this->dbh->prepare($query);

        $sth->execute();

        $output = $sth->fetchAll();

        $numberArray = count($output);

        echo "<select name='roleAgent'>";
        for ($i = 0; $i <= ($numberArray - 1); $i++) {
            echo "<option value='" . $output[$i][0] . "'> " . $output[$i][1] . "</option>";
        }
        echo "</select><br>";
    }

    /**
     * Rajoute une ligne dans la table agent de la base du donnée du projet avec les attribut nom,prénom,idRole passer en array
     * @param array $valueInsert array comprenant nom, prénom et id du rôle de l'agent
     * @throws Exception en cas d'erreur durent l'insertion de la requête
     * @see connect_static()
     */
    function agentExist($valueInsert) {
        try {
            $this->connect_static();
            $query = "INSERT agent VALUE (null,?,?,?);";
            $sth = $this->dbh->prepare($query);
            $sth->execute($valueInsert);
        } catch (Exception $ex) {
            echo "Une erreur semblent s'être produite!<br>";
        }
    }

    /**
     * Permet de récuperais l'ensemble du matérielle retirer part une ou plusieurs personne qui sont enregistrer sur la base de données du projet et de l'envoyer sur text.txt
     * @param string/array $mode contient soit "*", "jane doe" ou ["jane doea", "jean doe" ..] 
     * @see db_pdo()
     * @see connect_static()
     */
    function automaticWriteHistoric($mode) {
        include_once 'db_pdo.php';
        $gestion_pdo = new db_pdo();

        $dir = "class/text.txt";
        $this->connect_static();

        unlink($dir);
        if ($mode === "*") {
            $query = "SELECT * FROM appareil;";
        } else {
            $query = "SELECT * FROM appareil WHERE";
            if (is_array($mode)) {
                $numberAgent = (count($mode) - 1);
                $lastAgent = $mode[$numberAgent];
                foreach ($mode as $agent) {
                    $agentArrray = explode(" ", $agent);
                    $idAgent = $gestion_pdo->gestion_agent($agentArrray[0], $agentArrray[1]);
                    if ($lastAgent != $agent) {
                        $query = $query . " idAgent = '$idAgent' OR ";
                    } else {
                        $query = $query . " idAgent = '$idAgent';";
                    }
                }
            } else {
                $agentArrray = explode(" ", $mode);

                $idAgent = $gestion_pdo->gestion_agent($agentArrray[0], $agentArrray[1]);
                $query = $query . " idAgent = '$idAgent';";
            }
        }

        $sth = $this->dbh->prepare($query);
        $sth->execute();
        $output = $sth->fetchAll();

        touch($dir);
        $handle = fopen($dir, "w");

        foreach ($output as $sub) {
            $text = "- L Appareil de marque " . $gestion_pdo->find_marque($sub[1]) . " de modele " . $gestion_pdo->find_modele($sub[2]) . " dont le numéro de serie est $sub[3] entrer à la date du $sub[5]";
            fwrite($handle, iconv("UTF-8", "ASCII//TRANSLIT", htmlspecialchars(html_entity_decode($text . " (jumpLine) "), ENT_QUOTES, 'UTF-8') . PHP_EOL));
        }

        fclose($handle);

        /**
         * Vise à récupérée l'ensemble des utilisateur dans la table agents de la base de données du serveur, de venir créée un select multiple de voir qu'est ce qu'il choisisent de lancer la function pour écrire dans text.txt avant en fin d'appeler la function d'écrirture dans le pdf qui vient récupéré dans txt.txt l'historique du ou des agents avant de dynamiquement généré le pdf avec tFPDF
         * @see extend_fpdf()
         * @see utilitary_class()
         * @see membre_class() 
         * @see automaticWriteHistoric()
         * @see textCellFPDF()
         * @see tFPDF
         */
        function formAndExecutePdfHistoricUser() {
            $query = "SELECT * FROM agent;";

            require 'class/extend_fpdf.php';
            include_once 'class/utilitary_class.php';
            $gestion_utilitaire = new utilitary_class();
            include_once "class/membre_class.php";
            $gestion_membre = new membre_class();

            $this->connect_static();
            $sth = $this->dbh->prepare($query);
            $sth->execute();
            $output = $sth->fetchAll();

            $numberAgent = count($output);

            echo "<br><form method='POST'>l'Agent: (maintenir CLTR pour choisir plusieurs)<br><select name='choice[]' multiple size='4'>";
            foreach ($output as $agent) {
                echo "<option value='$agent[2] $agent[1]'>$agent[2] $agent[1]</option>";
            }
            echo "</select><br><input type='submit'></form>";
            if (isset($_POST["choice"])) {
                $arraySelectAgent = $_POST["choice"];
                $numberSelectAGent = count($arraySelectAgent);
                if ($numberAgent === $numberSelectAGent) {
                    $parameter = "*";
                } elseif ($numberSelectAGent != 1) {
                    $parameter = [];
                    foreach ($arraySelectAgent as $agentSelect) {
                        array_push($parameter, $agentSelect);
                    }
                } else {
                    $parameter = strval($arraySelectAgent[0]);
                }
            }
            $gestion_membre->automaticWriteHistoric($parameter);

            $verify = null;
            $outputText = $gestion_utilitaire->readText("/var/www/html/retrait/class/text.txt");
            if ($outputText != "false") {
                $pdf = new extend_fpdf();
                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 12);
                $verify = $gestion_utilitaire->textCellFPDF($outputText, $pdf);
                $dateUnix = time();
                $namePDF = 'class/pdf/pdfHistoric' . $dateUnix . '.pdf';
                $pdf->Output('F', $namePDF);

                if ($verify === null) {
                    echo "<a href='$namePDF'>Lire l'historique en PDF!</a>";
                }
            } else {
                echo "Le fichier n'existe pas!";
            }
        }

    }

/**
     * Permet dans la table agent de la base de données du projet de retrouver un agent via une ID
     * @param integer $idAgent
     * @return array
     * @see connect_static()
     */

    function findUserbyId($idAgent) {
            $code = function($idAgent, $connectDatabase) {
            $query = "SELECT prenom, nom FROM agent WHERE ID = '$idAgent';";
            $sth = $connectDatabase->prepare($query);

            $sth->execute();
            $output = $sth->fetchAll();
            return $output;
        };
        
        $output = $this->connectToClassExpendException()->runAgentNotExistingDatabase($idAgent, $code);
        if (!(count($output) <= 0)) {
            return [$output[0][0], $output[0][1]];
        }
    }
    
    function allIdAgent(){
        $query = "SELECT ID FROM agent;";
        $idSingle = [];
        $sth = $this->connect_static()->prepare($query);
        $sth->execute();
        $output  = $sth->fetchAll();
        
        foreach ($output as $id) {
            array_push($idSingle, $id[0]);
        }
        return $idSingle;
    }
    
    
}
