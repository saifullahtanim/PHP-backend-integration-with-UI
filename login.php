<?php
session_start();
include('db/config.php');

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            // ✅ Save all necessary session data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email']; // ✅ For password reset usage

            header("Location: index.php");
            exit();
        } else {
            $error = "❌ Incorrect Password!";
        }
    } else {
        $error = "❌ Email not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Modern UI</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .modern-wrapper {
            height: 100vh;
            background: linear-gradient(135deg, #8360c3, #2ebf91);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: sans-serif;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            color: white;
            width: 350px;
        }

        .glass-card h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .glass-card input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 10px;
            border: none;
            outline: none;
            font-size: 16px;
        }

        .glass-card button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: none;
            background: white;
            color: #5a2ea3;
            font-weight: bold;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
        }

        .glass-card button:hover {
            background: #5a2ea3;
            color: white;
        }

        .error {
            color: #ff4d4d;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="modern-wrapper">
        <div class="glass-card">
            <h2>🔐 User Login</h2>
            <?php if ($error): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>
            <form method="POST">
                <input type="email" name="email" placeholder="Enter Email" required>
                <input type="password" name="password" placeholder="Enter Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
