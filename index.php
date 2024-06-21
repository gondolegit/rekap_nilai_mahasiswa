<?php
session_start();
include 'config.php';

if (isset($_SESSION['status'])) {
    if ($_SESSION['status'] == 'guru') {
        header("Location: guru.php");
    } elseif ($_SESSION['status'] == 'murid') {
        header("Location: murid.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALDO 211011401581 | Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Selamat Datang di Sistem Rekap Nilai Siswa</h2>
    <a href="login.php" class="btn btn-primary">Login</a>
    <a href="register.php" class="btn btn-secondary">Register</a>
</div>
</body>
</html>
