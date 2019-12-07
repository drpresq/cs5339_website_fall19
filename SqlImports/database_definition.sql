-- CS5339 - Secure-Web Systems
-- Instructor: Dr Longpre
-- Students: Ernesto Vazquez & George Wood
-- SQL File that creates tables for Assigment 3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE usertype (
	id int auto_increment,
	utype varchar(10) not null,
	primary key (id),
	unique (utype)
);

insert into usertype (utype) values ('admin'), ('user');

CREATE TABLE tusers (
	ID int auto_increment,
	Username varchar(100) NOT NULL,
	UPassword varchar(256) NOT NULL,
	EmailAddress varchar(100) NOT NULL,
	utype varchar(10) not null,
	PRIMARY KEY (ID),
	UNIQUE (Username),
	UNIQUE (EmailAddress),
	foreign key (utype) references usertype(utype)
);

INSERT INTO tusers (Username, UPassword, EmailAddress, utype) VALUES ('longpre','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8','longpre@utep.edu','admin'), ('dreyes15','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8','dreyes15@miners.utep.edu','admin'), ('user1','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8','email1@miners.utep.edu','user');

