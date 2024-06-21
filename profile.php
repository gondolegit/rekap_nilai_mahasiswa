<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALDO 211011401581 | Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Profile Saya</h2>
    <table class="table table-striped">
        <tr>
            <th>Username</th>
            <td><?php echo $user['username']; ?></td>
        </tr>
        <tr>
            <th>Nama Lengkap</th>
            <td><?php echo $user['fullname']; ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo $user['email']; ?></td>
        </tr>
        <tr>
            <th>No. Telepon</th>
            <td><?php echo $user['phone']; ?></td>
        </tr>
    </table>
    <a href="logout.php" class="btn btn-secondary">Logout</a>
</div>
</body>
</html>
