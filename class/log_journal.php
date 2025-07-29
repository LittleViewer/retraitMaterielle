<?php

require_once 'db_pdo.php';

class log_journal EXTENDS db_pdo {
    /**
     * Permet la journalisation de chaque intervention d'un agent sur la base de donnée
     * @param string $mode
     * @param integer $idAgent
     * @see connect_static()
     * @see findUserbyId()
     */
    function addEntryLog($mode, $idAgent, $isError = false) {
        require_once 'class/membre_class.php';
        $gestion_membre = new membre_class();
        $nameAgent = $gestion_membre->findUserbyId($idAgent);

        try {
            $dbh = $this->connect_static();

            $query = "INSERT INTO logCode(code, description,idAgent) VALUES (?,?,?);";

            $sth = $dbh->prepare($query);
            if ($mode === "add") {

            $sth->execute([1, "Un agent à rentrer une nouvelle ligne dans la table 'appareil'", $idAgent]);
            } elseif ($mode === "modify") {
             $sth->execute([2, "Un agent à modifier une ligne dans la table 'appareil'", $idAgent]);   
            } elseif ($mode === "delete") {
            $sth->execute([3, "Un agent à supprimer une ligne dans la table 'appareil'", $idAgent]);
        }
        } catch (Exception) {
            echo "Une erreur est survenue durent la journalisation de l'action!";
        }
    }
}
