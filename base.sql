CREATE DATABASE takalo;
USE takalo;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categorie (
    id_categorie INT PRIMARY KEY AUTO_INCREMENT,
    nom_categorie VARCHAR(255) NOT NULL,
    description_categorie TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO categorie (nom_categorie, description_categorie) VALUES
('Électronique', 'Appareils électroniques tels que téléphones, ordinateurs, tablettes, etc.'),
('Vêtements', 'Vêtements pour hommes, femmes et enfants.'),
('Livres', 'Livres de différents genres et catégories.'),
('Meubles', 'Meubles pour la maison et le bureau.'),
('Jouets', 'Jouets pour enfants de tous âges.');

CREATE TABLE objet (
    id_objet INT PRIMARY KEY AUTO_INCREMENT,
    nom_objet VARCHAR(255) NOT NULL,
    description_objet TEXT,
    id_categorie INT,
    id_user INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_categorie) REFERENCES categorie(id_categorie),
    FOREIGN KEY (id_user) REFERENCES users(id)
);

CREATE TABLE objet_photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    objet_id INT NOT NULL,
    photo_path VARCHAR(255) NOT NULL,
    FOREIGN KEY (objet_id) REFERENCES objet(id_objet)
);
CREATE TABLE demande_echange (
    id_demande INT PRIMARY KEY AUTO_INCREMENT,
    id_objet_demande INT NOT NULL COMMENT 'Objet que le demandeur veut obtenir',
    id_objet_offert INT NOT NULL COMMENT 'Objet que le demandeur propose en échange',
    id_demandeur INT NOT NULL COMMENT 'Utilisateur qui fait la demande',
    id_proprietaire INT NOT NULL COMMENT 'Propriétaire de l objet demandé',
    statut ENUM('en_attente', 'accepte', 'refuse') DEFAULT 'en_attente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_objet_demande) REFERENCES objet(id_objet),
    FOREIGN KEY (id_objet_offert) REFERENCES objet(id_objet),
    FOREIGN KEY (id_demandeur) REFERENCES users(id),
    FOREIGN KEY (id_proprietaire) REFERENCES users(id)
);



insert into objet (nom_objet, description_objet, id_categorie, id_user) values
('Vélo', 'Un vélo de montagne en bon état', 5, 1),
('Table', 'Une table en bois massif', 4, 2),
('Chaise', 'Une chaise confortable pour le bureau', 4, 3);