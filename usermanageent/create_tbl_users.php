<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webprodb5d";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

// SQL untuk buat tabel users
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    role ENUM('visitor','operator','admin') NOT NULL DEFAULT 'visitor',
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table users created successfully<br>";
} else {
    echo "Error creating table users: " . $conn->error . "<br>";
}

// contoh tambahan table new_products (opsional)
$sql2 = "CREATE TABLE IF NOT EXISTS new_products (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    nik CHAR(16) NOT NULL,
    created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY(id)
)";

if ($conn->query($sql2) === TRUE) {
    echo "Table new_products created successfully<br>";
} else {
    echo "Error creating table new_products: " . $conn->error . "<br>";
}

$conn->close();
?>
