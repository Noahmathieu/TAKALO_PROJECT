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


