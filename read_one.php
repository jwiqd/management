<?php
include "config/com_db.php";
$sql = "SELECT name, description, price FROM products WHERE id=1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
if ($result->num_rows > 0) {
  // output data of each row
  echo "Name: " . $row["name"]. " - Description: " . $row["description"]. " - Price: " . $row["price"]. "<br>";
} else {
  echo "0 results - Data not found";
}
  //close connection
  $conn->close();
?>