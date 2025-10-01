<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully <br>";
// Create database
$sql = "CREATE DATABASE webproDB5d";
if ($conn->query($sql) === TRUE) {
  echo "Database webproDB created successfully";
} else {
  echo "Error creating database webproDB5d: " . $conn->error;
}

// Close connection
$conn->close();
?>