create database organ;

CREATE TABLE registration (
    username VARCHAR(20) PRIMARY KEY,
    password varchar(20),
    email varchar(50),
usertype varchar(20)
);

CREATE TABLE login_details (
    username VARCHAR(20) PRIMARY KEY,
    password varchar(20),
    login_time datetime,
usertype varchar(20),
    FOREIGN KEY (username) REFERENCES registration(username) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE patients (
    username VARCHAR(20) PRIMARY KEY,
    place	varchar(100),
	blood_group	varchar(10),
	contact	varchar(20)	,
	organ	varchar(10),
	age	int(3),
	usertype	varchar(20)	,
    FOREIGN KEY (username) REFERENCES registration(username) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE donor (
    username VARCHAR(20) PRIMARY KEY,
    place	varchar(100),
	blood_group	varchar(10),
	contact	varchar(20)	,
	organ	varchar(10),
	age	int(3),
	usertype	varchar(20)	,
    FOREIGN KEY (username) REFERENCES registration(username) ON DELETE CASCADE ON UPDATE CASCADE
);
