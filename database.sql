
CREATE DATABASE IF NOT EXISTS warriors_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE warriors_db;

CREATE TABLE IF NOT EXISTS joueurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    numero INT NOT NULL,
    poste VARCHAR(60) NOT NULL,
    periode VARCHAR(60) NOT NULL,
    description TEXT NOT NULL,
    photo VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS titres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    annee INT NOT NULL UNIQUE,
    adversaire VARCHAR(100) NOT NULL,
    resultat VARCHAR(15) NOT NULL
);

INSERT INTO joueurs
(nom, numero, poste, periode, description, photo)
VALUES
('Stephen Curry', 30, 'Meneur', '2009 - présent',
 'Joueur emblématique de la franchise, connu pour son adresse à trois points.',
 'curry.jpg'),
('Klay Thompson', 11, 'Arrière', '2011 - 2024',
 'Arrière réputé pour son tir extérieur et ses performances avec les Warriors.',
 'thompson.jpg'),
('Draymond Green', 23, 'Ailier fort', '2012 - présent',
 'Joueur reconnu pour sa défense, sa polyvalence et sa vision du jeu.',
 'green.jpg'),
('Kevin Durant', 35, 'Ailier', '2016 - 2019',
 'Joueur offensif majeur des titres NBA de 2017 et 2018.',
 'durant.jpg'),
('Wilt Chamberlain', 13, 'Pivot', '1959 - 1965',
 'Légende de la franchise, célèbre notamment pour son match à 100 points.',
 'chamberlain.jpg');

INSERT INTO titres (annee, adversaire, resultat)
VALUES
(1947, 'Chicago Stags', '4-1'),
(1956, 'Fort Wayne Pistons', '4-1'),
(1975, 'Washington Bullets', '4-0'),
(2015, 'Cleveland Cavaliers', '4-2'),
(2017, 'Cleveland Cavaliers', '4-1'),
(2018, 'Cleveland Cavaliers', '4-0'),
(2022, 'Boston Celtics', '4-2');
