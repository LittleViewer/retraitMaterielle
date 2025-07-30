<?php

class exceptionExtend {

    private $dbh;
    private $gestion_pdo;
    private $gestion_membre;
    private $genericMessageForUser;

    public function __construct() {
        $this->recoverConnectDatabase();
        $this->connectWithMembreClass();
        $this->genericMessageForUser = "Une erreur est survenue, veuillez contacter le gestionnnaire d'application.";
    }

    /**
     * Récupération d'une fonction de connection à la base de données du projet déjà établis
     * @see db_pdo()
     */
    function recoverConnectDatabase() {
        require_once 'db_pdo.php';
        $gestion_pdo = new db_pdo();
        $this->dbh = $gestion_pdo->connect_static();
        $this->gestion_pdo = $gestion_pdo;
    }

    /**
     * Connection avec la classe membre
     * @return \membre_class
     * @see membre_class()
     */
    function connectWithMembreClass() {
        require_once 'membre_class.php';
        $gestion_membre = new membre_class();
        $this->gestion_membre = $gestion_membre;
        return $gestion_membre;
    }

    /**
     * Enregistrement dans la table logCode de la base de données du projet de l'erreur avec les informations de contextualisation
     * @param string $message Message spécifique de l'erreur
     * @param integer $idAgent Id de l'agent ayant subit l'erreur
     * @param string $traceString Suivi des actions du code ayant provoqué l'erreur
     */
    function errorLogging($message, $idAgent, $traceString) {
        $query = "INSERT INTO logCode (code, description, idAgent, isErrorTrace) VALUES (?,?,?,?);";
        $sth = $this->dbh->prepare($query);
        $sth->execute([5, $message, $idAgent, $traceString]);
    }

    /**
     * Fonction qui permet la vérification d'une division part zéros
     * @param integer $numerator
     * @param integer $denominator
     * @param integer $idAgent
     * @return obj
     * @throws divideByZero
     * @see divideByZero()
     */
    function runDivideByZero($numerator, $denominator, $idAgent) {
        $divideByZero = new divideByZero();

        try {
            if ($denominator != 0 AND $numerator != 0) {
                return $numerator / $denominator;
            } else {
                throw $divideByZero;
            }
        } catch (Exception $ex) {
            $this->errorLogging($divideByZero->getMessage(), $idAgent, $divideByZero->getTraceAsString());
            echo $this->genericMessageForUser;
        }
    }

    /**
     * Fonction vérifiant la possibilité de recherche d'un agent s'il existe ou non dans la base de données du projet
     * @param integer $idAgent
     * @param function $codeNotVerify
     * @return array
     * @throws agentNotExistinDatabase
     * @see agentNotExistinDatabase()
     */
    function runAgentNotExistingDatabase($idAgent, $codeNotVerify) {
        $agentNotExistinDatabase = new agentNotExistinDatabase();
        $allId = $this->connectWithMembreClass()->allIdAgent();
        $idExist = false;

        $numberIdExist = count($allId);

        for ($i = 0; $i <= ($numberIdExist - 1); $i++) {
            if ($idAgent === $allId[$i]) {
                $idExist = true;
                break;
            }
        }
        if ($idExist === true) {
            return $codeNotVerify($idAgent, $this->dbh);
        } else {
            try {
                throw $agentNotExistinDatabase;
            } catch (Exception $ex) {
                $this->errorLogging($agentNotExistinDatabase->getMessage(), null, $agentNotExistinDatabase->getTraceAsString());
                echo $this->genericMessageForUser;
                exit();
            }
        }
    }
    
    
    /**
     * Function vérifiant si des variables sont strictement défini dans une url (et non sont contenue) sachant que placeholder permet de séparer deux variables
     * @param array $arrayUrl
     * @param integer $numberVariable
     * @return array
     * @throws variableHistoricNotDefine
     */
    function variableNotDefineHistoricUser($arrayUrl, $numberVariable) {
        $variableNotDefineHistoric = new variableHistoricNotDefine();
        $isExist = false;
        if (count($arrayUrl)>1) {
            $isExist = true;
        }

        if ($isExist === true) {
            $nameEncode = $arrayUrl[1];
            $arrayName = explode("placeholder", $nameEncode);
            if (count($arrayName) === ($numberVariable)) {
                return $arrayName;
            } else {
                try {
                    throw $variableNotDefineHistoric;
                } catch (Exception $ex) {
                    $this->errorLogging($variableNotDefineHistoric->getMessage(), null, $variableNotDefineHistoric->getTraceAsString());
                    echo $this->genericMessageForUser;
                    exit();
                }
            }
        } else {
            try {
                throw $variableNotDefineHistoric;
            } catch (Exception $ex) {

                $this->errorLogging($variableNotDefineHistoric->getMessage(), null, $variableNotDefineHistoric->getTraceAsString());
                echo $this->genericMessageForUser;
                exit();
            }
        }
    }
}

class divideByZero extends \RuntimeException {

    /**
     * Exeception personaliser visant à géré les cas de division part zéro
     * @param string $message
     * @param string $code
     * @param \Throwable $previous
     */
    public function __construct($message = "Une tentative de division part zéro à était effectuer résultant d'une erreur fatale ayant stopper le code.", $code = 0, \Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

class agentNotExistinDatabase extends \RuntimeException {

    /**
     * Exeception personaliser visant à géré les cas de recherche dans la table agent de la base de données du projet d'agent n'existant pas
     * @param string $message
     * @param string $code
     * @param \Throwable $previous
     */
    public function __construct(string $message = "Une tentative de recherche d'un utilisateur dans la base de données semblent n'avoir pas fonctionner, l'utilisateur ne semblent pas exister.", int $code = 0, ?\Throwable $previous = null) {
        return parent::__construct($message, $code, $previous);
    }
}



class variableHistoricNotDefine extends \RuntimeException {
    /**
     * Exeception personaliser visant à géré la définition des variables au sein des url
     * @param string $message
     * @param string $code
     * @param \Throwable $previous
     */
    public function __construct(string $message = "Une tentative de visionnage d'un historique utilisateur à était effectuer mais celui-ci n'as pas fonction en raison de la non définition des variables au travers de l'URL.", int $code = 0, ?\Throwable $previous = null) {
        return parent::__construct($message, $code, $previous);
    }
}
