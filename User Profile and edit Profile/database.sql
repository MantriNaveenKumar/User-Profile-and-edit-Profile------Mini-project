CREATE DATABASE userdatabase ;

CREATE TABLE UserDetails (
    id serial PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    age INT,
    email VARCHAR(255),
    dob DATE,
    contact VARCHAR(15),
    profile_image BYTEA
);

CREATE TABLE usersession (
    session_created_time TIMESTAMP,
    username VARCHAR(255),
    session_logout_time TIMESTAMP
);

