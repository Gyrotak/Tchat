CREATE DATABASE IF NOT EXISTS TChat;

USE TChat;

CREATE Table `User` (
       ID INT PRIMARY KEY AUTO_INCREMENT,
       Pseudo Varchar(100) NOT NULL UNIQUE,
       Password Varchar(255) NOT NULL,
       Connected INT NOT NULL,
       Created_at TIMESTAMP DEFAULT NOW(),
       Updated_at TIMESTAMP
);

CREATE Table `Chat` (
       ID INT PRIMARY KEY AUTO_INCREMENT,
       ID_User INT NOT NULL,
       Message TEXT NOT NULL,
       Created_at TIMESTAMP DEFAULT NOW(),
       CONSTRAINT FK_UserMessage FOREIGN KEY (ID_User) REFERENCES User(ID)
 );
