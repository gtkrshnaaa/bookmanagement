-- Membuat database bookmanagement
CREATE DATABASE bookmanagement;

-- Menggunakan database bookmanagement
USE bookmanagement;

-- Membuat tabel users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Membuat tabel books dengan kolom image bertipe LONGBLOB
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    author VARCHAR(100) NOT NULL,
    published_date DATE,
    genre VARCHAR(50),
    image LONGBLOB
);

-- Menambahkan pengguna admin dengan password terenkripsi
INSERT INTO users (username, password) VALUES ('admin', MD5('admin123'));
