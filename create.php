<!-- <?php
// include "config/com_db.php";
// //insert data  table
// $sql = "INSERT INTO products(name, description, price)
// VALUES ('earphone','you need this if you love music', 20000)";
// if ($conn->query($sql) === TRUE) {
//   echo "New record created successfully";
// } else {
//   echo "Error: " . $sql . "<br>" . $conn->error;
// }
//   //close connection
//   $conn->close();

?> -->
<?php
// include "config/com_db.php";

// // Cek apakah form disubmit
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Ambil data dari form
//     $name = $_POST['name'];
//     $description = $_POST['description'];
//     $price = $_POST['price'];

//     // Query insert
//     $sql = "INSERT INTO products (name, description, price)
//             VALUES ('$name', '$description', $price)";

//     if ($conn->query($sql) === TRUE) {
//         echo "New record created successfully<br>";
//     } else {
//         echo "Error: " . $sql . "<br>" . $conn->error;
//     }

//     // Tutup koneksi
//     $conn->close();
// }
include "config/com_db.php";

// Proses simpan data kalau form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $sql = "INSERT INTO products (name, description, price) VALUES ('$name', '$description', $price)";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Produk berhasil ditambahkan.</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
</head>
<body>
    <h2>Tambah Produk Baru</h2>
    <form method="POST" action="create.php">
        <label>Product Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Description:</label><br>
        <input type="text" name="description" required><br><br>

        <label>Price:</label><br>
        <input type="number" name="price" required><br><br>

        <button type="submit">Tambah Produk</button>
    </form>

    <br>
    <a href="read.php">Lihat Semua Produk</a>
</body>
</html>
