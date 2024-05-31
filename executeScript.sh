####### Apache2 #####
#sudo apachectl restart


####### MY SQL #####
#CREATE DATABASE mwiaTicketingSystem;
#SHOW DATABASES;
#USE mwiaTicketingSystem;

CREATE TABLE mwiaadmin (
    id INT AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    PRIMARY KEY(id)
) ENGINE=InnoDB;

Insert into mwiaadmin (name,email,password) values ('ramesh', 'ramrc007@gmail.com', '1234567');


CREATE TABLE mwia_members_2024 (
    id integer unsigned not null AUTO_INCREMENT,
    memberId VARCHAR(100) NOT NULL,
    emailId VARCHAR(100) NOT NULL,
    membershipLevel VARCHAR(100) NOT NULL,
    firstName VARCHAR(100) NOT NULL,
    lastName VARCHAR(100),
    streetName VARCHAR(100),
    houseNumber VARCHAR(100),
    postalCode VARCHAR(100),
    city VARCHAR(100),
    mobileNumber VARCHAR(100),
    paymentReferenceNumber VARCHAR(100),
    spouseFirstName VARCHAR(100),
    spouseLastName VARCHAR(100),
    PRIMARY KEY(id)
) ENGINE=InnoDB AUTO_INCREMENT=1000;

CREATE TABLE mwia_members_child_2024 (
    id INT AUTO_INCREMENT,
    memberId VARCHAR(100) NOT NULL,
    childFullName VARCHAR(100) NOT NULL,
    childAge Int,
    PRIMARY KEY(id)
) ENGINE=InnoDB;

#HappyD0g$Br1ghtL1ghtS! -> SQL PASSWORD