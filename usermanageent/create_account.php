<?php
// koneksi ke database
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "webprodb5d";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Hapus user
if (isset($_POST['delete'])) {
    $id = intval($_POST['id']);
    $conn->query("DELETE FROM users WHERE id = $id");
}

// Update fullname & role
if (isset($_POST['update'])) {
    $id       = intval($_POST['id']);
    $fullname = $_POST['fullname'];
    $role     = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET fullname=?, role=? WHERE id=?");
    $stmt->bind_param("ssi", $fullname, $role, $id);
    $stmt->execute();
    $stmt->close();
}

// Ganti password
if (isset($_POST['change_password'])) {
    $id          = intval($_POST['id']);
    $newpassword = $_POST['newpassword'];

    if (!empty($newpassword)) {
        $hashed = password_hash($newpassword, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->bind_param("si", $hashed, $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Ambil semua user
$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f8fa;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        a {
            display: inline-block;
            margin-bottom: 15px;
            padding: 8px 14px;
            background: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        a:hover {
            background: #0056b3;
        }
        table {
            border-collapse: collapse;
            width: 90%;
            background: white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        input[type="text"], input[type="password"], select {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 6px 10px;
            margin: 2px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button[name="update"] {
            background: #28a745;
            color: white;
        }
        button[name="update"]:hover {
            background: #218838;
        }
        button[name="delete"] {
            background: #dc3545;
            color: white;
        }
        button[name="delete"]:hover {
            background: #c82333;
        }
        button[name="change_password"] {
            background: #ffc107;
            color: black;
        }
        button[name="change_password"]:hover {
            background: #e0a800;
        }
        td[colspan="5"] {
            background: #f9f9f9;
        }
    </style>
</head>
<body>
    <h2>📋 Daftar Akun User</h2>
    <a href="form_register.php">⬅ Kembali ke Form Register</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Fullname</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <form method="post">
                <td><?php echo $row['id']; ?>
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                </td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td>
                    <input type="text" name="fullname" value="<?php echo htmlspecialchars($row['fullname']); ?>">
                </td>
                <td>
                    <select name="role">
                        <option value="admin" <?php if ($row['role']=='admin') echo "selected"; ?>>Admin</option>
                        <option value="user" <?php if ($row['role']=='user') echo "selected"; ?>>User</option>
                        <option value="visitor" <?php if ($row['role']=='visitor') echo "selected"; ?>>Visitor</option>
                    </select>
                </td>
                <td>
                    <button type="submit" name="update">Update</button>
                    <button type="submit" name="delete" onclick="return confirm('Hapus user ini?')">Hapus</button>
                </td>
            </form>
        </tr>
        <tr>
            <form method="post">
                <td colspan="5">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    🔑 Ganti Password: 
                    <input type="password" name="newpassword" placeholder="Password baru">
                    <button type="submit" name="change_password">Simpan Password</button>
                </td>
            </form>
        </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
