
-- Table Utilisateur
CREATE TABLE Utilisateur (
         UserID INT PRIMARY KEY auto_increment,
         NomUtilisateur VARCHAR(255),
         MotDePasse VARCHAR(255),
         Email VARCHAR(255),
         Role  enum('admin','condidat') NOT NULL-- Admin, Candidat
);

-- Table OffreEmploi
CREATE TABLE OffreEmploi (
         OffreID INT PRIMARY KEY auto_increment,
         TitreOffre VARCHAR(255),
         DescriptionOffre TEXT,
         Entreprise VARCHAR(255),
         Localisation VARCHAR(255),
         Statut VARCHAR(10), -- (Actif, Inactif)
         DatePublication DATE,
         Image VARCHAR(255) -- Lien vers l'image
);

-- Table Candidature
CREATE TABLE Candidature (
         CandidatureID INT PRIMARY KEY auto_increment,
         UserID INT,
         OffreID INT,
         Visibilite VARCHAR(10), -- (Approuvé, En attente)
         DateSoumission DATE,
         FOREIGN KEY (UserID) REFERENCES Utilisateur(UserID),
         FOREIGN KEY (OffreID) REFERENCES OffreEmploi(OffreID)
);

INSERT INTO `OffreEmploi` (`OffreID`, `titreOffre`, `DescriptionOffre`, `Entreprise`, `Localisation`, `Statut`, `DatePublication`, `Image`) VALUES
(1, 'Web Developer', 'Description of the job...', 'Tech Co', 'City A', 'Open', '2009-02-17', '/path/to/web_developer_image.jpg'),
(2, 'Graphic Designer', 'Another job description...', 'Tech Co', 'City A', 'Open', '2009-02-17', 'path/to/graphic_designer_image.jpg');

