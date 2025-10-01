<?php
// register.php - self-contained (no include)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ======= konfigurasi DB: sesuaikan jika perlu =======
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webprodb5d";

// Create connection
$conn = new mysqli($servername,$username,$password,$dbname);

// Check connection
if($conn->connect_error){
    die("Connection failed:".$conn->connect_error);
}

// ======= proses form =======
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username   = trim($_POST['username'] ?? '');
    $fullname   = trim($_POST['fullname'] ?? '');
    $password   = $_POST['password'] ?? '';
    $repassword = $_POST['repassword'] ?? '';
    $role       = $_POST['role'] ?? 'visitor';

    // validasi dasar
    if ($password === '' || $username === '' || $fullname === '') {
        $message = 'Semua field harus diisi.';
    } elseif ($password !== $repassword) {
        $message = 'Password dan Re-enter Password tidak sama.';
    } else {
        // cek username unik
        $check = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            $message = 'Username sudah digunakan. Pilih username lain.';
            $check->close();
        } else {
            $check->close();
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password, fullname, role) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $username, $hashed, $fullname, $role);
            if ($stmt->execute()) {
                header('Location: create_account.php');
                exit;
            } else {
                $message = 'Error saat menyimpan: ' . $stmt->error;
            }
            $stmt->close();
        }
    }
}

$conn->close();
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Register User</title>
<style>
/* (CSS sederhana seperti contohmu) */
body{font-family:Arial, sans-serif;background:#f4f4f4;display:flex;align-items:center;justify-content:center;height:100vh;margin:0}
.container{background:#fff;padding:25px;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.08);width:420px}
h2{text-align:center;margin-top:0}
label{display:block;margin-top:12px;font-weight:bold}
input{width:100%;padding:10px;margin-top:6px;border:1px solid #ccc;border-radius:5px}
.roles{margin-top:8px}
.roles label{font-weight:normal;margin-right:12px}
button{margin-top:18px;width:100%;padding:12px;background:#007bff;color:#fff;border:none;border-radius:6px;cursor:pointer}
button:hover{background:#0056b3}
.message{margin:12px 0;padding:10px;background:#f0f0f0;border-radius:4px}
</style>
<script>
function validateForm(){
    var p=document.getElementById('password').value;
    var r=document.getElementById('repassword').value;
    if(p !== r){ alert('Password dan Re-enter Password harus sama.'); return false; }
    if(p.length < 6){ alert('Password minimal 6 karakter.'); return false; }
    return true;
}
</script>
</head>
<body>
<div class="container">
  <h2>Register User</h2>
  <?php if ($message !== ''): ?>
    <div class="message"><?= $message ?></div>
  <?php endif; ?>
  <form method="post" onsubmit="return validateForm()">
    <label>Username</label>
    <input type="text" name="username" required>

    <label>Full Name</label>
    <input type="text" name="fullname" required>

    <label>Password</label>
    <input type="password" id="password" name="password" required>

    <label>Re-enter Password</label>
    <input type="password" id="repassword" name="repassword" required>

    <label>Role</label>
    <div class="roles">
      <label><input type="radio" name="role" value="visitor" checked> Visitor</label>
      <label><input type="radio" name="role" value="operator"> Operator</label>
      <label><input type="radio" name="role" value="admin"> Admin</label>
    </div>

    <button type="submit" href="create_account.php">Register</button>
  </form>
</div>
</body>
</html>
