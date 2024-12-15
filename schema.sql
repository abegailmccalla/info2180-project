DROP DATABASE IF EXISTS dolphin_crm;
CREATE DATABASE dolphin_crm;
USE dolphin_crm;

-- Users --
CREATE TABLE Users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(35) NOT NULL,
    lastname VARCHAR(35) NOT NULL,
    pwd VARCHAR(85) NOT NULL,
    email VARCHAR(35) NOT NULL UNIQUE,
    _role VARCHAR(35) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO Users VALUES (1,'Admin','User',"$2y$10$gjsO0Y6301wR9uRa1/bBSuTUh6HH2fgslC4j76/xSVVSXEt1sNC4K","admin@project2.com","Admin",CURRENT_TIMESTAMP),
(2,'John','Brown',"$2y$10$f1Qyv4wvRZxPRmUjzl07R.HFtaAOwC3XKLXqeHcbXSdL06Cdyuypi","johnb@gmail.com","Member",CURRENT_TIMESTAMP),
(3,'Mary','White',"$2y$10$uTSs0PPWzfJZmSuQyKaYG.CE4NLZXSIOBJyRIucoE.LZJTi6AwZc.","maryw@gmail.com","Member",CURRENT_TIMESTAMP);

-- Contacts --
CREATE TABLE Contacts (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(5) NOT NULL,
    firstname VARCHAR(35) NOT NULL,
    lastname VARCHAR(35) NOT NULL,
    email VARCHAR(35) NOT NULL,
    telephone VARCHAR(15) NOT NULL,
    company VARCHAR(55) NOT NULL,
    _type VARCHAR(35) NOT NULL,
    assigned_to INTEGER,
    created_by INTEGER,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_to) REFERENCES Users(id),
    FOREIGN KEY (created_by) REFERENCES Users(id)
);

 -- Notes --
CREATE TABLE Notes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    contact_id INTEGER NOT NULL,
    comment TEXT NOT NULL,
    created_by INT,
    FOREIGN KEY (created_by) REFERENCES Users(id),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
