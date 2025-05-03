<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$_SESSION['user_email'] = $_SESSION['user_email'] ?? 'mim@gmail.com'; // keep for reset_password.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(270deg, #6a11cb, #2575fc);
            background-size: 400% 400%;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow: hidden;
            animation: backgroundMove 8s ease infinite;
        }

        @keyframes backgroundMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .dashboard-card {
            background: #ffffff10;
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 40px 60px;
            text-align: center;
            color: #fff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            transform: translateY(40px);
            opacity: 0;
            animation: slideIn 1s ease-out forwards;
        }

        @keyframes slideIn {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .dashboard-card h1 {
            font-size: 32px;
            margin-bottom: 20px;
        }

        .dashboard-card p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn-group a, .btn-group button {
            text-decoration: none;
            background-color: #fff;
            color: #333;
            padding: 12px 28px;
            border-radius: 6px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .btn-group a:hover, .btn-group button:hover {
            background-color: #333;
            color: #fff;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.6);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            width: 300px;
        }

        .modal-content input {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .modal-content .actions {
            display: flex;
            justify-content: space-between;
        }

        .modal-content button {
            padding: 10px 20px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .cancel-btn {
            background-color: #ccc;
        }

        .submit-btn {
            background-color: #2575fc;
            color: white;
        }

        .cancel-btn:hover {
            background-color: #999;
        }

        .submit-btn:hover {
            background-color: #1e5fd3;
        }
    </style>
</head>
<body>

    <div class="dashboard-card">
        <h1>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></h1>
        <p>This is your dashboard.</p>
        <div class="btn-group">
            <a href="logout.php">Logout</a>
            <button onclick="openModal()">Reset Password</button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="resetModal">
        <form action="db/update_password.php" method="POST" class="modal-content">
            <h3>🔒 Reset Password</h3>
            <input type="password" name="new_password" placeholder="Enter new password" required>
            <div class="actions">
                <button type="button" class="cancel-btn" onclick="closeModal()">Back</button>
                <button type="submit" class="submit-btn">Confirm</button>
            </div>
        </form>
    </div>

    <script>
        function openModal() {
            document.getElementById('resetModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('resetModal').style.display = 'none';
        }
    </script>
</body>
</html>
