<?php

/**
 * Classe contenent un ensemble de fonction visant à la gestion de tous qui résulte de manière non générique des usage du PDO
 * 
 * @author Mathys
 * @version 1.0.0
 * @see membre_class()
 */
class db_pdo {

    private $dbh;
    private $gestionMembreClass;

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

        $this->dbh = new PDO("mysql:host=localhost;dbname=retrait", "retrait", base64_decode($value));

        return $this->dbh;
    }

    /**
     * Permet de vérifier si la base de donnée existe bien avec la function connect_static()
     * @return array
     * @see connect_static
     */
    function test_connect() {

        $this->connect_static();

        $query = "SELECT * FROM role_agent;";

        $sth = $this->dbh->prepare($query);

        $sth->execute();

        $output = $sth->fetchAll();

        return $output;
    }

    /**
     * Appel la class membre_class() et l'instancie pour l'utiliser dans toute la fonction avec $this->
     * @see membre_class()
     */
    function gestion_membre_connect_static() {
        include_once "membre_class.php";

        $gestion_membre = new membre_class();

        $this->gestionMembreClass = $gestion_membre;
    }

    /**
     * Enregistre sur la base de données du projet le retrait d'un appareil
     * @param array $data Comprend id de la marque, id du mode, le numéros de série, id unique de l'agent et la date de l'enregistrement
     * @see connect_static()
     */
    function new_retrait_appareil($data, $mode) {
        require_once 'log_journal.php';
        $log_gestion = new log_journal();

        $this->connect_static();

        $query = "INSERT appareil(idMarque, idModele, serialNumber, idAgent, dateRecord) VALUES (?,?,?,?,?)";

        $sth = $this->dbh->prepare($query);
        $sth->execute($data);
        if ($mode === "add") {
            $log_gestion->addEntryLog("add", $data[3]);
        } else {
            $log_gestion->addEntryLog("modify", $data[3]);
        }
    }

    /**
     * Permet de retrouver sur la base de données du projet dans la table agent tout les appareilles retirer part l'agent
     * @param string $prenomAgent prenom de l'agent
     * @param string $nameAgent nom de l'agent
     * @return array
     * @see connect_static()
     */
    function gestion_agent($prenomAgent, $nameAgent) {

        try {
            $this->connect_static();

            $query = "SELECT ID FROM agent WHERE prenom='" . $prenomAgent . "' AND nom='" . $nameAgent . "';";

            $sth = $this->dbh->prepare($query);

            $sth->execute();

            $output = $sth->fetchAll();

            return $output[0][0];
        } catch (Exception $ex) {
            echo "Il semblent y avoir eux une erreur </form>";
        }
    }

    /**
     * Permet de retrouver sur la base de donnée du projet dans la table marque le nom d'une marque à partir de sont idée
     * @param Integer $idMarque
     * @return string
     * @see connect_static()
     */
    function find_marque($idMarque) {

        $this->connect_static();

        $query = "SELECT nom FROM marque WHERE ID='" . $idMarque . "';";

        $sth = $this->dbh->prepare($query);

        $sth->execute();

        $output = $sth->fetchAll();

        foreach ($output as $sub) {

            foreach ($sub as $value) {

                $result = $value;
            }
        }



        return $result;
    }

    /**
     * Permet de retrouver à partir d'un id dans la base de donnée du projet à la table modele un modele spécifique
     * @param integer $idModele
     * @return string
     * @see connect_static()
     */
    function find_modele($idModele) {

        $this->connect_static();

        $query = "SELECT nom FROM modele WHERE ID='" . $idModele . "';";

        $sth = $this->dbh->prepare($query);

        $sth->execute();

        $output = $sth->fetchAll();

        foreach ($output as $sub) {

            foreach ($sub as $value) {

                $result = $value;
            }
        }



        return $result;
    }

    /**
     * Verifie si le numéros de série est déjà présent dans la table appareil de la base données du projet
     * @param string $presentSerialNumber
     * @return bool
     * @see connect_static()
     */
    function verify_serialNumber($presentSerialNumber) {

        $output = null;

        $validate = false;

        $this->connect_static();

        $query = "SELECT ID FROM appareil WHERE serialNumber = '" . $presentSerialNumber . "';";

        $sth = $this->dbh->prepare($query);

        $sth->execute();

        $output = $sth->fetchAll();

        foreach ($output as $sub) {

            foreach ($sub as $value) {

                $result = $value;
            }
        }





        if (isset($result)) {

            $validate = true;
        }

        return $validate;
    }

    /**
     * Verifie si une marque entrée existe déjà dans la table marque de la base de données du projet: si oui retourne l'id de la marque, sinon inséré une nouvelle ligne et retourne sont id
     * @param string $nomMarque
     * @return integer
     * @see connect_static()
     */
    function marqueExist($nomMarque) {

        $arrayMarqueExist = [];

        $this->connect_static();

        $query = "SELECT nom FROM marque";

        $sth = $this->dbh->prepare($query);

        $sth->execute();

        $output = $sth->fetchAll();

        $numberArray = count($output);

        for ($i = 0; $i <= ($numberArray - 1); $i++) {

            array_push($arrayMarqueExist, $output[$i][0]);
        }



        if (in_array($nomMarque, $arrayMarqueExist)) {

            $query = "SELECT ID FROM marque WHERE nom='$nomMarque';";

            $sth = $this->dbh->prepare($query);

            $sth->execute();

            $outputNameExist = $sth->fetch();

            $idNameExist = $outputNameExist[0];
        } else {

            $query = "INSERT marque (nom) VALUES (?);";

            $sth = $this->dbh->prepare($query);

            $sth->execute([$nomMarque]);

            $query = "SELECT ID FROM marque WHERE nom='$nomMarque';";

            $sth = $this->dbh->prepare($query);

            $sth->execute();

            $outputNameExist = $sth->fetch();

            $idNameExist = $outputNameExist[0];
        }

        return $idNameExist;
    }

    /**
     * Verifie si un modele existe chez tels marque dans la table modele de la base de donnée du projet: si oui retourne id du modele, sinon insére le modele dans le table et retourne id
     * @param string $nomModele
     * @param integer $idMarque
     * @return integer
     * @see connect_static()
     * @see marqueExist()
     */
    function modeleExist($nomModele, $idMarque) {

        $arrayMarqueExist = [];

        $this->connect_static();

        $query = "SELECT nom FROM modele";

        $sth = $this->dbh->prepare($query);

        $sth->execute();

        $output = $sth->fetchAll();

        $numberArray = count($output);

        for ($i = 0; $i <= ($numberArray - 1); $i++) {

            array_push($arrayMarqueExist, $output[$i][0]);
        }



        if (in_array($nomModele, $arrayMarqueExist)) {

            $query = "SELECT ID FROM modele WHERE nom='$nomModele';";

            $sth = $this->dbh->prepare($query);

            $sth->execute();

            $outputNameExist = $sth->fetch();

            $idNameExist = $outputNameExist[0];
        } else {

            $query = "INSERT modele (nom, idMarque) VALUES (?,?);";

            $sth = $this->dbh->prepare($query);

            $sth->execute([$nomModele, $idMarque]);

            $query = "SELECT ID FROM modele WHERE nom='$nomModele';";

            $sth = $this->dbh->prepare($query);

            $sth->execute();

            $outputNameExist = $sth->fetch();

            $idNameExist = $outputNameExist[0];
        }

        return $idNameExist;
    }

    /**
     * Permet de récupéré tout les ID, nom et prénon de la table agent
     * @see connect_static()
     * @deprecated Ne renvoie rien et/ou n'exploite pas le résultat de la requête en somme ne fait rien
     */
    function listAgent() {

        $this->connect_static();

        $query = "SELECT ID, nom, prenom FROM agent;";

        $sth = $this->dbh->prepare($query);

        $sth->execute();

        $output = $sth->fetchAll(PDO::FETCH_NUM);
    }

    /**
     * Permet de généré un footer qui prévient l'utilisateur dans index.php (new_entry) que sont retrait et bien enregistrer dans la base de données
     * @param string $marque
     * @param string $modele
     * @param string $serialNumber
     * @param string $date
     */
    function footerNewEntryGenerator($marque, $modele, $serialNumber, $date) {
        if (!isset($marque) OR !isset($modele) OR !isset($serialNumber)) {
            echo "<footer>Il semblent y a voir des erreur</footer>";
        } else {
            echo "<footer> L'appareil au numéro de série " . $serialNumber .
            " de marque " . $marque . " dont le modele est " .
            $modele . " est retirer du service à date du " . $date . "</footer>";
            ;
        }
    }

    /**
     * Permet de crée une un formulaire pour selectionnait un seule agent
     * @return html
     * @see gestion_membre_connect_static()
     */
    function selectFormAgent() {
        $this->gestion_membre_connect_static();

        $output = $this->gestionMembreClass->member_find();
        $numberAgent = count($output[0]);
        echo "<select name='agentSelect'>";
        for ($i = 0; $i <= ($numberAgent - 1); $i++) {
            echo "<option value='" . $output[0][$i] . "placeholder" . $output[1][$i] . "'>" . $output[0][$i] . " " . $output[1][$i] . "</option>";
        }
        echo "</select>";
    }

    /**
     * Permet de trouver l'id d'un utilisateur part rapport à un retrait qu'il a effectuer dans la table appareil de la base de données du projet
     * @param string $serialNumber
     * @param string $date
     * @return string
     * @see connect_static()
     */
    function findUserbySerialNumberAndDate($serialNumber, $date) {
        $this->connect_static();

        $query = "SELECT idAgent FROM appareil WHERE serialNumber = '$serialNumber' AND dateRecord = '$date'";

        $sth = $this->dbh->prepare($query);
        $sth->execute();
        $output = $sth->fetch();

        return $output[0];
    }

    /**
     * Permet de supprimer une entrée dans la table appareil de la base de données du projet 
     * @param string $serialNumber
     * @param string $date
     * @see connect_static()
     */
    function removeEntrybySerialNumberAndDate($serialNumber, $date, $idAgent) {
        require_once 'log_journal.php';
        $log_gestion = new log_journal();
        $this->connect_static();
        $query = "DELETE FROM appareil WHERE serialNumber = '$serialNumber' AND dateRecord = '$date'";
        $sth = $this->dbh->prepare($query);
        $sth->execute();
        $log_gestion->addEntryLog("delete", $idAgent);
    }
}
