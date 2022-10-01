//Création de la base de données
CREATE DATABASE greenfit2;
USE greenfit2;

//Création de la table users_roles
DROP TABLE IF EXISTS users_roles;
CREATE TABLE users_roles (
    id INT(10) PRIMARY KEY AUTO_INCREMENT NOT NULL, 
    name VARCHAR(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

//Insertion du rôle admin
LOCK TABLES users_roles WRITE;
INSERT INTO `users_roles`(`id`, `name`) VALUES ('1','["ROLE_ADMIN"]');
UNLOCK TABLES;

//Création de la table users
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT(10) PRIMARY KEY NOT NULL,
    email VARCHAR(180) UNIQUE COLLATE utf8mb4_unicode_ci NOT NULL,
    roles LONGTEXT COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
    password VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    lastname VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL,
    firstname VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL,
    address VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    zipcode VARCHAR(5) COLLATE utf8mb4_unicode_ci NOT NULL,
    city VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL,
    roles_users_id INT(10) DEFAULT NULL,
    FOREIGN KEY(roles_users_id) REFERENCES users_roles(id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


