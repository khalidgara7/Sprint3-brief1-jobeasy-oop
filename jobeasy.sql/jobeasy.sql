
-- Table Utilisateur
CREATE TABLE Utilisateur (
         UserID INT PRIMARY KEY,
         NomUtilisateur VARCHAR(255),
         MotDePasse VARCHAR(255),
         Email VARCHAR(255),
         Role VARCHAR(20) -- Admin, Candidat
);

-- Table OffreEmploi
CREATE TABLE OffreEmploi (
         OffreID INT PRIMARY KEY,
         TitreOffre VARCHAR(255),
         DescriptionOffre TEXT,
         Entreprise VARCHAR(255),
         Localisation VARCHAR(255),
         Statut VARCHAR(10), -- (Actif, Inactif)
         Visibilite VARCHAR(10), -- (Approuvé, En attente)
         DatePublication DATE,
         Image VARCHAR(255) -- Lien vers l'image
);

-- Table Candidature
CREATE TABLE Candidature (
         CandidatureID INT PRIMARY KEY,
         UserID INT,
         OffreID INT,
         StatutCandidature VARCHAR(20), -- En attente, Approuvé, Rejeté, etc.
         DateSoumission DATE,
         FOREIGN KEY (UserID) REFERENCES Utilisateur(UserID),
         FOREIGN KEY (OffreID) REFERENCES OffreEmploi(OffreID)
);

