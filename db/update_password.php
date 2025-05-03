<?php
session_start();
include('config.php');

$email = $_SESSION['user_email'] ?? 'mim@gmail.com'; // fallback for testing

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = trim($_POST['new_password']);
    
    if (!empty($newPassword)) {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $con->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hash, $email);
        
        if ($stmt->execute()) {
            $success = true;
        } else {
            $error = $stmt->error;
        }
    } else {
        $error = "Password cannot be empty!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: #fff;
        }
        .card {
            background: #ffffff15;
            padding: 30px 50px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(8px);
        }
        .card h2 {
            margin-bottom: 20px;
        }
        .input-box {
            margin: 20px 0;
        }
        input[type="password"] {
            padding: 12px;
            border-radius: 8px;
            border: none;
            font-size: 16px;
            width: 100%;
        }
        .btn-group {
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            margin: 0 10px;
            text-decoration: none;
            background: #fff;
            color: #333;
            border-radius: 6px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn:hover {
            background: #333;
            color: #fff;
        }
        .error {
            color: #ffdddd;
            background: #ff4d4d;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 6px;
        }
        .success {
            color: #ddffdd;
            background: #28a745;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <div class="card">
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <?php if ($success): ?>
                <div class="success">✅ Password updated successfully!</div>
            <?php else: ?>
                <div class="error">❌ Failed to update: <?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <div class="btn-group">
                <a href="../index.php" class="btn">🔙 Back</a>
                <a href="../login.php" class="btn">🏠 Login</a>
            </div>
        <?php else: ?>
            <h2>🔐 Reset Your Password</h2>
            <form method="POST">
                <div class="input-box">
                    <input type="password" name="new_password" placeholder="Enter New Password" required>
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn">✅ Confirm</button>
                    <a href="../index.php" class="btn">🔙 Back</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
