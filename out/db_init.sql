CREATE DATABASE IF NOT EXISTS vulnapp;
USE vulnapp;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100),
  password VARCHAR(100),
  fullname VARCHAR(200)
);

-- Usuario de ejemplo (password en texto plano: 'user')
INSERT INTO users (username, password, fullname) VALUES ('user','user','Usuario Vulnerable');
