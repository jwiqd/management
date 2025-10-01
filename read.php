<?php
// include "config/com_db.php";

// // Ambil semua data produk
// $sql = "SELECT id, name, description, price FROM products";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     // looping untuk tampilkan semua baris
//     while ($row = $result->fetch_assoc()) {
//         echo "ID: " . $row["id"] . 
//              " - Name: " . $row["name"] . 
//              " - Description: " . $row["description"] . 
//              " - Price: " . $row["price"] . "<br>";
//     }
// } else {
//     echo "0 results - Data not found";
// }

// // Tutup koneksi
// $conn->close();

// include "config/com_db.php";

// // Ambil semua data produk
// $sql = "SELECT id, name, description, price FROM products";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     echo "<table border='1' cellspacing='0' cellpadding='8'>
//             <tr>
//                 <th>ID</th>
//                 <th>Name</th>
//                 <th>Description</th>
//                 <th>Price</th>
//             </tr>";
    
//     while ($row = $result->fetch_assoc()) {
//         echo "<tr>
//                 <td>" . $row["id"] . "</td>
//                 <td>" . $row["name"] . "</td>
//                 <td>" . $row["description"] . "</td>
//                 <td>" . $row["price"] . "</td>
//               </tr>";
//     }
    
//     echo "</table>";
// } else {
//     echo "0 results - Data not found";
// }

// // Tutup koneksi
// $conn->close();
include "config/com_db.php";

// Kalau ada request update data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $sql = "UPDATE products SET name='$name', description='$description', price=$price WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Data berhasil diupdate.</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}

// Ambil semua data
$sql = "SELECT id, name, description, price FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1' cellspacing='0' cellpadding='8'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        // Jika tombol edit ditekan, baris berubah jadi form
        if (isset($_GET['edit']) && $_GET['edit'] == $row['id']) {
            echo "<tr>
                    <form method='POST' action=''>
                        <td>" . $row['id'] . "<input type='hidden' name='id' value='" . $row['id'] . "'></td>
                        <td><input type='text' name='name' value='" . $row['name'] . "'></td>
                        <td><input type='text' name='description' value='" . $row['description'] . "'></td>
                        <td><input type='number' name='price' value='" . $row['price'] . "'></td>
                        <td>
                            <button type='submit' name='update'>Save</button>
                            <a href='read.php'>Cancel</a>
                        </td>
                    </form>
                  </tr>";
        } else {
            // Tampilan normal
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["description"] . "</td>
                    <td>" . $row["price"] . "</td>
                    <td>
                        <a href='read.php?edit=" . $row["id"] . "'>Edit</a> | 
                        <a href='delete.php?id=" . $row["id"] . "' onclick=\"return confirm('Yakin mau hapus data ini?');\">Delete</a>
                    </td>
                  </tr>";
        }
    }
    
    echo "</table>";
} else {
    echo "0 results - Data not found";
}

$conn->close();


?>
<!-- Tombol Add Product -->
<a href="create.php" class="btn">+ Add Product</a>