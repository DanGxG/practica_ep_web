CREATE DATABASE DB_Series;

USE DB_Series;

-- Tabla SERIE
CREATE TABLE IF NOT EXISTS SERIE (
    nomSerie VARCHAR(100) PRIMARY KEY,
    anyCreacio INT NOT NULL,
    descripcio TEXT NOT NULL,
    imatge TEXT,
    valoracioMitjana FLOAT
) DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- Tabla TEMPORADA
CREATE TABLE IF NOT EXISTS TEMPORADA (
    nomSerie VARCHAR(100),
    numTemporada INT,
    descripcio TEXT NOT NULL,
    imatge TEXT,
    valoracioMitjana FLOAT,
    PRIMARY KEY (nomSerie, numTemporada),
    FOREIGN KEY (nomSerie) REFERENCES SERIE(nomSerie)
) DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- Tabla USUARI
CREATE TABLE IF NOT EXISTS USUARI (
    nomUsuari VARCHAR(50) PRIMARY KEY,
    contrasenya VARCHAR(255) NOT NULL,
    tipus VARCHAR(50) NOT NULL,
    numeroErrorsLogin INT
) DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- Tabla VALORADOR
CREATE TABLE IF NOT EXISTS VALORADOR (
    nomUsuari VARCHAR(50),
    nom VARCHAR(100) NOT NULL,
    cognoms VARCHAR(100) NOT NULL,
    imatge TEXT,
    email VARCHAR(100) NOT NULL,
    PRIMARY KEY (nomUsuari),
    FOREIGN KEY (nomUsuari) REFERENCES USUARI(nomUsuari)
) DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- Tabla VALORA
CREATE TABLE IF NOT EXISTS VALORA (
    nomSerie VARCHAR(100),
    numTemporada INT,
    nomUsuari VARCHAR(50),
    valor INT CHECK (valor BETWEEN 1 AND 5),
    comentari TEXT,
    PRIMARY KEY (nomSerie, numTemporada, nomUsuari),
    FOREIGN KEY (nomSerie, numTemporada) REFERENCES TEMPORADA(nomSerie, numTemporada),
    FOREIGN KEY (nomUsuari) REFERENCES VALORADOR(nomUsuari)
) DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- Inserir Dades de Prova
USE db_series;

-- Inserir sèries
INSERT INTO SERIE (nomSerie, anyCreacio, descripcio, imatge, valoracioMitjana)
VALUES
    ('Serie1', 2020, 'Descripció de la sèrie 1', 'imatge1.jpg', NULL),
    ('Serie2', 2022, 'Descripció de la sèrie 2', 'imatge2.jpg', NULL);

-- Inserir temporades per a les sèries
INSERT INTO TEMPORADA (nomSerie, numTemporada, descripcio, imatge, valoracioMitjana)
VALUES
    ('Serie1', 1, 'Descripció de la temporada 1 de Serie1', 'imatge1_temp1.jpg', NULL),
    ('Serie1', 2, 'Descripció de la temporada 2 de Serie1', 'imatge1_temp2.jpg', NULL),
    ('Serie2', 1, 'Descripció de la temporada 1 de Serie2', 'imatge2_temp1.jpg', NULL),
    ('Serie2', 2, 'Descripció de la temporada 2 de Serie2', 'imatge2_temp2.jpg', NULL);

-- Inserir usuaris
INSERT INTO USUARI (nomUsuari, contrasenya, tipus, numeroErrorsLogin)
VALUES
    ('admin1', 'adminpass', 'Administrador', 0),
    ('valorador1', 'valoradorpass', 'Valorador', 0);

-- Inserir valoradors
INSERT INTO VALORADOR (nomUsuari, nom, cognoms, imatge, email)
VALUES
    ('valorador1', 'Valorador', 'Primer', 'valorador1.jpg', 'valorador1@example.com');

-- Inserir valoracions de temporades
INSERT INTO VALORA (nomSerie, numTemporada, nomUsuari, valor, comentari)
VALUES
    ('Serie1', 1, 'valorador1', 4, 'Bona temporada amb una història emocionant'),
    ('Serie1', 2, 'valorador1', 5, 'Encara millor que la primera temporada, molt recomanable');
