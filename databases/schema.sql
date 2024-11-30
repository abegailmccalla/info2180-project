DROP DATABASE IF EXISTS dolphin_crm;
CREATE DATABASE dolphin_crm;

USE dolphin_crm;

-- Creating User Table
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `role` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
);

--Creating Contacts Table
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `telephone` varchar(250) NOT NULL,
  `company` varchar(250) NOT NULL,
  `type` varchar(250) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`assigned_to`) REFERENCES `users`(`id`),
  FOREIGN KEY (`created_by`) REFERENCES `users`(`id`)
);

--Creating Notes Table
CREATE TABLE `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `comment` TEXT NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`contact_id`) REFERENCES `contacts`(`id`),
  FOREIGN KEY (`created_by`) REFERENCES `users`(`id`)
);

-- Insert Admin User with Hashed Password
INSERT INTO users (firstname, lastname, password, email, role) 
VALUES ('Admin', 'User', '$2y$10$gjsO0Y6301wR9uRa1/bBSuTUh6HH2fgslC4j76/xSVVSXEt1sNC4K', 'admin@project2.com', 'administrator');
