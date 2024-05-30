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

Insert into table mwiaadmin (name,email,password) values ('ramesh', 'ramrc007@gmail.com', '1234567');