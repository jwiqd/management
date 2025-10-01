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

// Hapus user jika ada request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: create_account.php");
    exit;
}

// Update user jika ada request POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_id'])) {
    $id = intval($_POST['update_id']);
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $role = $conn->real_escape_string($_POST['role']);
    $status = $conn->real_escape_string($_POST['status']);

    $conn->query("UPDATE users SET fullname='$fullname', role='$role', status='$status' WHERE id=$id");
    header("Location: create_account.php");
    exit;
}

// Query ambil data users
$sql = "SELECT id, username, fullname, role, status, updated FROM users ORDER BY id ASC";
$result = $conn->query($sql);

// Jika sedang edit
$edit_id = isset($_GET['edit']) ? intval($_GET['edit']) : null;
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Daftar Akun User</title>
<style>
body{font-family:Arial,sans-serif;background:#f4f4f4;margin:0;padding:20px;}
.container{background:#fff;padding:20px;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.08);max-width:1000px;margin:auto;}
h2{text-align:center;margin-top:0;}
.actions{margin-bottom:15px;text-align:right;}
a.btn,button.btn{display:inline-block;padding:6px 12px;margin:2px;border-radius:5px;text-decoration:none;font-size:14px;border:none;cursor:pointer;}
.btn-primary{background:#007bff;color:#fff;}
.btn-primary:hover{background:#0056b3;}
.btn-danger{background:#dc3545;color:#fff;}
.btn-danger:hover{background:#a71d2a;}
.btn-edit{background:#28a745;color:#fff;}
.btn-edit:hover{background:#1e7e34;}
.btn-cancel{background:#6c757d;color:#fff;}
.btn-cancel:hover{background:#565e64;}
table{width:100%;border-collapse:collapse;margin-top:10px;}
th,td{border:1px solid #ddd;padding:10px;text-align:center;}
th{background:#007bff;color:#fff;}
tr:nth-child(even){background:#f9f9f9;}
</style>
</head>
<body>
<div class="container">
  <h2>Daftar Akun User</h2>
  
  <div class="actions">
    <a href="form_register.php" class="btn btn-primary">➕ Kembali ke Register</a>
  </div>

  <?php if ($result && $result->num_rows > 0): ?>
    <table>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Full Name</th>
        <th>Role</th>
        <th>Status</th>
        <th>Updated</th>
        <th>Aksi</th>
      </tr>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <?php if ($edit_id === (int)$row['id']): ?>
            <!-- Form edit inline -->
            <form method="post">
              <td><?= $row['id'] ?><input type="hidden" name="update_id" value="<?= $row['id'] ?>"></td>
              <td><?= htmlspecialchars($row['username']) ?></td>
              <td><input type="text" name="fullname" value="<?= htmlspecialchars($row['fullname']) ?>"></td>
              <td>
                <select name="role">
                  <option value="visitor" <?= $row['role']=='visitor'?'selected':'' ?>>Visitor</option>
                  <option value="operator" <?= $row['role']=='operator'?'selected':'' ?>>Operator</option>
                  <option value="admin" <?= $row['role']=='admin'?'selected':'' ?>>Admin</option>
                </select>
              </td>
              <td>
                <select name="status">
                  <option value="active" <?= $row['status']=='active'?'selected':'' ?>>Active</option>
                  <option value="inactive" <?= $row['status']=='inactive'?'selected':'' ?>>Inactive</option>
                </select>
              </td>
              <td><?= $row['updated'] ?></td>
              <td>
                <button type="submit" class="btn btn-edit">💾 Simpan</button>
                <a href="create_account.php" class="btn btn-cancel">❌ Batal</a>
              </td>
            </form>
          <?php else: ?>
            <!-- Tampilan biasa -->
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['fullname']) ?></td>
            <td><?= htmlspecialchars($row['role']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td><?= $row['updated'] ?></td>
            <td>
              <a href="create_account.php?edit=<?= $row['id'] ?>" class="btn btn-edit">✏️ Edit</a>
              <a href="create_account.php?delete=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin hapus user ini?')">🗑️ Hapus</a>
            </td>
          <?php endif; ?>
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
