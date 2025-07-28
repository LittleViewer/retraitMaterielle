

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";




CREATE TABLE `agent` (
  `ID` int(4) NOT NULL,
  `nom` varchar(64) NOT NULL,
  `prenom` varchar(64) NOT NULL,
  `idRoleAgent` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;





CREATE TABLE `appareil` (
  `ID` int(5) NOT NULL,
  `idMarque` int(4) NOT NULL,
  `idModele` int(4) NOT NULL,
  `serialNumber` varchar(128) NOT NULL,
  `idAgent` int(4) NOT NULL,
  `dateRecord` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `code` (
  `ID` int(3) NOT NULL,
  `nom` varchar(256) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `code` (`ID`, `nom`, `description`) VALUES
(1, 'Ajout d\'un retrait appareil', 'Un utilisateur à rajouter une ligne de la table \'appareil\''),
(2, 'Modification d\'un retrait appareil', 'Un utilisateur à modifier une ligne de la table \'appareil\''),
(3, 'Suppression d\'un retrait appareil', 'Un utilisateur à supprimer une ligne de la table \'appareil\''),
(4, 'Un nouvelle agent de créée', 'Un nouvelle agent vient d\'être ajouter à la table \'agent\''),
(5, 'Erreur durent l\'execution du code', 'Une erreur est survenue veuillez vous renseigner auprès de la description du log pour le connaitre le motif de l\'erreur dans la table logCode');



CREATE TABLE `logCode` (
  `ID` int(20) NOT NULL,
  `code` int(3) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `recordLog` timestamp NOT NULL DEFAULT current_timestamp(),
  `idAgent` int(4) DEFAULT NULL,
  `isErrorTrace` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `marque` (
  `ID` int(4) NOT NULL,
  `nom` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `modele` (
  `ID` int(4) NOT NULL,
  `nom` varchar(64) NOT NULL,
  `idMarque` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `role_agent` (
  `ID` int(2) NOT NULL,
  `nom` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;






ALTER TABLE `agent`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Fk_idRoleAgent` (`idRoleAgent`);


ALTER TABLE `appareil`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `serialNumber` (`serialNumber`),
  ADD KEY `Fk_idAgent` (`idAgent`),
  ADD KEY `Fk_idMarqueVerifyIntegrity` (`idMarque`),
  ADD KEY `Fk_idModelVerifyIntegrity` (`idModele`);

ALTER TABLE `code`
  ADD PRIMARY KEY (`ID`);


ALTER TABLE `logCode`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_errorCOde` (`code`),
  ADD KEY `FK_idAgentLpg` (`idAgent`);


ALTER TABLE `marque`
  ADD PRIMARY KEY (`ID`);


ALTER TABLE `modele`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Fk_idMarque` (`idMarque`);


ALTER TABLE `role_agent`
  ADD PRIMARY KEY (`ID`);


ALTER TABLE `agent`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;


ALTER TABLE `appareil`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;


ALTER TABLE `code`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


ALTER TABLE `logCode`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;


ALTER TABLE `marque`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;


ALTER TABLE `modele`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;


ALTER TABLE `role_agent`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


ALTER TABLE `agent`
  ADD CONSTRAINT `Fk_idRoleAgent` FOREIGN KEY (`idRoleAgent`) REFERENCES `role_agent` (`ID`);


ALTER TABLE `appareil`
  ADD CONSTRAINT `FK_idModeleAppareil` FOREIGN KEY (`idModele`) REFERENCES `modele` (`ID`),
  ADD CONSTRAINT `Fk_idAgent` FOREIGN KEY (`idAgent`) REFERENCES `agent` (`ID`),
  ADD CONSTRAINT `Fk_idMarqueAppareil` FOREIGN KEY (`idMarque`) REFERENCES `marque` (`ID`),
  ADD CONSTRAINT `Fk_idMarqueVerifyIntegrity` FOREIGN KEY (`idMarque`) REFERENCES `marque` (`ID`),
  ADD CONSTRAINT `Fk_idModelVerifyIntegrity` FOREIGN KEY (`idModele`) REFERENCES `modele` (`ID`);


ALTER TABLE `logCode`
  ADD CONSTRAINT `FK_errorCOde` FOREIGN KEY (`code`) REFERENCES `code` (`ID`),
  ADD CONSTRAINT `FK_idAgentLpg` FOREIGN KEY (`idAgent`) REFERENCES `agent` (`ID`);

ALTER TABLE `modele`
  ADD CONSTRAINT `Fk_idMarque` FOREIGN KEY (`idMarque`) REFERENCES `marque` (`ID`);
COMMIT;

