CREATE DATABASE formulaire_db;

USE formulaire_db;

CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lastname VARCHAR(100),
    firstname VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(255)
);
