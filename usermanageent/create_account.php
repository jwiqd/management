<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webprodb5d";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query ambil data users
$sql = "SELECT id, username, fullname, role, status, updated FROM users ORDER BY id ASC";
$result = $conn->query($sql);
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Daftar Akun User</title>
<style>
body{font-family:Arial,sans-serif;background:#f4f4f4;margin:0;padding:20px;}
.container{background:#fff;padding:20px;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.08);max-width:800px;margin:auto;}
h2{text-align:center;}
table{width:100%;border-collapse:collapse;margin-top:20px;}
th,td{border:1px solid #ddd;padding:10px;text-align:center;}
th{background:#007bff;color:#fff;}
tr:nth-child(even){background:#f9f9f9;}
</style>
</head>
<body>
<div class="container">
  <h2>Daftar Akun User</h2>
  <?php if ($result && $result->num_rows > 0): ?>
    <table>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Full Name</th>
        <th>Role</th>
        <th>Status</th>
        <th>Updated</th>
      </tr>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['username']) ?></td>
          <td><?= htmlspecialchars($row['fullname']) ?></td>
          <td><?= htmlspecialchars($row['role']) ?></td>
          <td><?= htmlspecialchars($row['status']) ?></td>
          <td><?= htmlspecialchars($row['updated']) ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php else: ?>
    <p>Tidak ada user terdaftar.</p>
  <?php endif; ?>
</div>
</body>
</html>
<?php
$conn->close();
?>
