CREATE TABLE Matiere(
   matId INT,
   matIntitulé VARCHAR(50) NOT NULL,
   PRIMARY KEY(matId)
);

CREATE TABLE Classe(
   claId INT,
   claNom VARCHAR(50),
   PRIMARY KEY(claId)
);

CREATE TABLE Professeur(
   profId INT,
   profNom VARCHAR(50),
   profPrenom VARCHAR(50),
   profMdp VARCHAR(50),
   PRIMARY KEY(profId)
);

CREATE TABLE Eleve(
   eleId INT,
   eleNom VARCHAR(50) NOT NULL,
   elePrenom VARCHAR(50) NOT NULL,
   eleMdp VARCHAR(50),
   claId INT NOT NULL,
   PRIMARY KEY(eleId),
   FOREIGN KEY(claId) REFERENCES Classe(claId)
);

CREATE TABLE Note(
   notId INT,
   notNote DECIMAL(3,1) NOT NULL,
   notIntitulé VARCHAR(50),
   claId INT NOT NULL,
   eleId INT NOT NULL,
   matId INT NOT NULL,
   PRIMARY KEY(notId),
   FOREIGN KEY(claId) REFERENCES Classe(claId),
   FOREIGN KEY(eleId) REFERENCES Eleve(eleId),
   FOREIGN KEY(matId) REFERENCES Matiere(matId)
);

CREATE TABLE Enseigne(
   matId INT,
   profId INT,
   PRIMARY KEY(matId, profId),
   FOREIGN KEY(matId) REFERENCES Matiere(matId),
   FOREIGN KEY(profId) REFERENCES Professeur(profId)
);
