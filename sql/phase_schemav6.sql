-- CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';
CREATE USER IF NOT EXISTS gatechUser@localhost IDENTIFIED BY 'gatech123';
DROP DATABASE IF EXISTS `cs6400_fa18_team046`;
SET default_storage_engine=InnoDB;
SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS cs6400_sp18_team046
DEFAULT CHARACTER SET utf8mb4
DEFAULT COLLATE utf8mb4_unicode_ci;
USE cs6400_sp18_team046;
GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO 
'gatechUser'@'localhost';
GRANT ALL PRIVILEGES ON `gatechuser`.* TO 'gatechUser'@'localhost';
GRANT ALL PRIVILEGES ON `cs6400_sp18_team046`.* TO 
'gatechUser'@'localhost';
FLUSH PRIVILEGES;

-- Tables
CREATE TABLE `User` (
 Username varchar(50) NOT NULL,
 Password varchar(50) NOT NULL,
 Firstname varchar(50) NOT NULL,
 Lastname varchar(50) NOT NULL,
 PRIMARY KEY (Username)
);

CREATE TABLE NormalUser (
 Username varchar(50) NOT NULL,
 PRIMARY KEY (Username)
);

CREATE TABLE AdminUser (
 Username varchar(50) NOT NULL,
 Position varchar(50) NOT NULL,
 PRIMARY KEY (Username)
);

CREATE TABLE AuctionItem (
Itemid integer unsigned NOT NULL AUTO_INCREMENT,
Description varchar(255) NULL,
Getitnowprice double(9,2) NULL,
Returnable boolean NOT NULL,
Auctionstarttime datetime NOT NULL,
Auctionlength enum('1','3','5','7') NOT NULL,
Minimumsaleprice double(9,2) NOT NULL,
Startbidvalue double(9,2) NOT NULL,
Itemname varchar(50) NOT NULL,
Username varchar(50) NOT NULL,
Catname varchar(50) NOT NULL,
Contype enum('New','Very Good','Good','Fair','Poor') NOT NULL,
PRIMARY KEY (Itemid)
);

CREATE TABLE Bid (
Username varchar(50) NOT NULL,
Itemid integer unsigned NOT NULL,
Bidtime datetime NOT NULL,
Bidprice double(9,2) NOT NULL,
PRIMARY KEY (Username, Itemid, Bidtime)
);

CREATE TABLE Review (
Username varchar(50) NOT NULL,
Itemid integer unsigned NOT NULL,
Comment varchar(255) NULL,
Rating ENUM('5','4','3','2','1') NOT NULL,
Time datetime NOT NULL,
PRIMARY KEY (Username, Itemid)
);

CREATE TABLE Cat (
Catname varchar(50) NOT NULL,
PRIMARY KEY (Catname)
);

CREATE TABLE Con (
Contype enum('New','Very Good','Good','Fair','Poor') NOT NULL,
PRIMARY KEY (Contype)
);


ALTER TABLE NormalUser
 ADD CONSTRAINT fk_NormalUser_Username_User_Username FOREIGN KEY (Username) REFERENCES `User` (Username);

ALTER TABLE AdminUser
 ADD CONSTRAINT fk_AdminUser_Username_User_Username FOREIGN KEY (Username) REFERENCES `User` (Username);

ALTER TABLE AuctionItem
 ADD CONSTRAINT fk_AuctionItem_Username_User_Username FOREIGN KEY (Username) REFERENCES `User` (Username),
 ADD CONSTRAINT fk_AuctionItem_Catname_Cat_Catname FOREIGN KEY (Catname) REFERENCES Cat (Catname);

ALTER TABLE Bid
 ADD CONSTRAINT fk_Bid_Username_User_Username FOREIGN KEY (Username) REFERENCES `User` (Username),
 ADD CONSTRAINT fk_Bid_Itemid_AuctionItem_Itemid FOREIGN KEY (Itemid) REFERENCES AuctionItem (Itemid);

ALTER TABLE Review
 ADD CONSTRAINT fk_Review_Username_User_Username FOREIGN KEY (Username) REFERENCES `User` (Username),
 ADD CONSTRAINT fk_Review_Itemid_AuctionItem_Itemid FOREIGN KEY (Itemid) REFERENCES AuctionItem (Itemid);




INSERT INTO `User` (Username, Password, Firstname, Lastname) VALUES('user1', 'pass1', 'Danite', 'Kelor');
INSERT INTO `User` (Username, Password, Firstname, Lastname) VALUES('user2', 'pass2', 'Dodra', 'Kiney');
INSERT INTO `User` (Username, Password, Firstname, Lastname) VALUES('user3', 'pass3', 'Peran', 'Bishop');
INSERT INTO `User` (Username, Password, Firstname, Lastname) VALUES('user4', 'pass4', 'Randy', 'Roran');
INSERT INTO `User` (Username, Password, Firstname, Lastname) VALUES('user5', 'pass5', 'Ashod', 'Iankel');
INSERT INTO `User` (Username, Password, Firstname, Lastname) VALUES('user6', 'pass6', 'Cany', 'Achant');
INSERT INTO `User` (Username, Password, Firstname, Lastname) VALUES('admin1', 'opensesame', 'Riley', 'Fuiss');
INSERT INTO `User` (Username, Password, Firstname, Lastname) VALUES('admin2', 'opensesayou', 'Tonnis', 'Kinser');

