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
Auctionendtime datetime NOT NULL,
Minimumsaleprice double(9,2) NOT NULL,
Startbidvalue double(9,2) NOT NULL,
Itemname varchar(50) NOT NULL,
Username varchar(50) NOT NULL,
Catname varchar(50) NOT NULL,
Contype enum('1','2','3','4','5') NOT NULL,
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


INSERT INTO NormalUser (Username) VALUES ('user1');
INSERT INTO NormalUser (Username) VALUES ('user2');
INSERT INTO NormalUser (Username) VALUES ('user3');
INSERT INTO NormalUser (Username) VALUES ('user4');
INSERT INTO NormalUser (Username) VALUES ('user5');
INSERT INTO NormalUser (Username) VALUES ('user6');


INSERT INTO AdminUser (Username,Position) VALUES ('admin1','Technical Support');
INSERT INTO AdminUser (Username,Position) VALUES ('admin2','Chief Techy');

INSERT INTO Cat (Catname) VALUES ('Art');
INSERT INTO Cat (Catname) VALUES ('Books');
INSERT INTO Cat (Catname) VALUES ('Electronics');
INSERT INTO Cat (Catname) VALUES ('Home & Garden');
INSERT INTO Cat (Catname) VALUES ('Sporting Goods');
INSERT INTO Cat (Catname) VALUES ('Toys');
INSERT INTO Cat (Catname) VALUES ('Other');


INSERT INTO AuctionItem (Itemid,Description,Getitnowprice,Returnable,Auctionendtime,Minimumsaleprice,Startbidvalue,Itemname,Username,Catname,Contype) VALUES ('1',	'This is a great GPS.',		'99','FALSE',		'2018/03/31  12:22:00',	'70','50','Garmin GPS','user1','Electronics','3');
INSERT INTO AuctionItem (Itemid,Description,Getitnowprice,Returnable,Auctionendtime,Minimumsaleprice,Startbidvalue,Itemname,Username,Catname,Contype) VALUES ('2',	'Point and shoot!',		'80','FALSE',		    '2018/04/01  2:14:00',	'60','40','Canon Powershot','user1','Electronics','2');
INSERT INTO AuctionItem (Itemid,Description,Getitnowprice,Returnable,Auctionendtime,Minimumsaleprice,Startbidvalue,Itemname,Username,Catname,Contype) VALUES ('3',	'New and in box!',		'2000','FALSE',		    '2018/04/05  9:19:00',	'1800','1500','Nikon D3','user2','Electronics','4');
INSERT INTO AuctionItem (Itemid,Description,Getitnowprice,Returnable,Auctionendtime,Minimumsaleprice,Startbidvalue,Itemname,Username,Catname,Contype) VALUES ('4',	'Delicious Danish Art',		'15','TRUE',		'2018/04/05  3:33:00',	'10','10','Danish Art Book','user3','Art','3');
INSERT INTO AuctionItem (Itemid,Description,Getitnowprice,Returnable,Auctionendtime,Minimumsaleprice,Startbidvalue,Itemname,Username,Catname,Contype) VALUES ('5',	'Learn SQL really fast!',	'12','FALSE',		'2018/04/05  4:48:00',	'10','5','SQL in 10 Minutes','admin1','Books','1');
INSERT INTO AuctionItem (Itemid,Description,Getitnowprice,Returnable,Auctionendtime,Minimumsaleprice,Startbidvalue,Itemname,Username,Catname,Contype) VALUES ('6',	'Learn SQL even faster!',	'10','FALSE',		'2018/04/08  10:01:00',	'8','5','SQL in 8 Minutes','admin2','Books','2');
INSERT INTO AuctionItem (Itemid,Description,Getitnowprice,Returnable,Auctionendtime,Minimumsaleprice,Startbidvalue,Itemname,Username,Catname,Contype) VALUES ('7',	'Works on any door frame.',	'40','TRUE',		'2018/04/09 10:09:00',	'25','20','Pull-up Bar','admin2','Electronics','3');
INSERT INTO AuctionItem (Itemid,Description,Getitnowprice,Returnable,Auctionendtime,Minimumsaleprice,Startbidvalue,Itemname,Username,Catname,Contype) VALUES ('8',	'A great tool!',            '75','TRUE',        '2018/04/16 3:15：00',	'50','25','Garmin GPS', 'user6','Sporting Goods','4');
INSERT INTO AuctionItem (Itemid,Description,Getitnowprice,Returnable,Auctionendtime,Minimumsaleprice,Startbidvalue,Itemname,Username,Catname,Contype) VALUES ('9',  'Worth buy it!',              NULL,'FALSE',       '2018/04/16 1:01：00',    '1500','1000','MacBook Pro','user4','Electronics','5');
INSERT INTO AuctionItem (Itemid,Description,Getitnowprice,Returnable,Auctionendtime,Minimumsaleprice,Startbidvalue,Itemname,Username,Catname,Contype) VALUES ('10', 'Good for notes.',          '899','FALSE',      '2018/04/16 6:00：00',     '750','500','Microsoft Surface','user5','Electronics','4');


INSERT INTO Bid (Username,Itemid,Bidtime,Bidprice) VALUES ('user4','1','2018-3-30 14:53:00','50');
INSERT INTO Bid (Username,Itemid,Bidtime,Bidprice) VALUES ('user5','1','2018-3-30 16:45:00','55');
INSERT INTO Bid (Username,Itemid,Bidtime,Bidprice) VALUES ('user4','1','2018-3-30 19:28:00','75');
INSERT INTO Bid (Username,Itemid,Bidtime,Bidprice) VALUES ('user5','1','2018-3-31 10:00:00','85');
INSERT INTO Bid (Username,Itemid,Bidtime,Bidprice) VALUES ('user6','2','2018-4-1 13:55:00','80');
INSERT INTO Bid (Username,Itemid,Bidtime,Bidprice) VALUES ('user1','3','2018-4-4 8:37:00','1500');
INSERT INTO Bid (Username,Itemid,Bidtime,Bidprice) VALUES ('user3','3','2018-4-4 9:15:00','1501');
INSERT INTO Bid (Username,Itemid,Bidtime,Bidprice) VALUES ('user1','3','2018-4-4 12:27:00','1795');
INSERT INTO Bid (Username,Itemid,Bidtime,Bidprice) VALUES ('user4','7','2018-4-8 20:20:00','20');
INSERT INTO Bid (Username,Itemid,Bidtime,Bidprice) VALUES ('user2','7','2018-4-9 21:15:00','25');


INSERT INTO Review (Username,Itemid,Comment,Rating,Time) VALUES ('user2','1','Great GPS!','3/30/2018 17:00','5');
INSERT INTO Review (Username,Itemid,Comment,Rating,Time) VALUES ('user3','1','Not so great GPS!','3/30/2018 18:00','2');
INSERT INTO Review (Username,Itemid,Comment,Rating,Time) VALUES ('user4','1','A favorite of mine.','3/30/2018 19:00','4');
INSERT INTO Review (Username,Itemid,Comment,Rating,Time) VALUES ('user1','4','Go for the Italian stuff instead.','4/1/2018 16:46','1');
INSERT INTO Review (Username,Itemid,Comment,Rating,Time) VALUES ('admin1','6','Not recommended.','4/6/2018 23:56','1');
INSERT INTO Review (Username,Itemid,Comment,Rating,Time) VALUES ('user1','6','This book is okay.','4/7/2018 13:32','3');
INSERT INTO Review (Username,Itemid,Comment,Rating,Time) VALUES ('user2','6','I learned SQL in 8 minutes!','4/7/2018 14:44','5');



