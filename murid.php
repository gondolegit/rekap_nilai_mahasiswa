<?php
session_start();
include 'config.php';

if ($_SESSION['status'] != 'murid') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT subjects.name, grades.grade
        FROM grades
        JOIN subjects ON grades.subject_id = subjects.id
        WHERE grades.user_id = $user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALDO 211011401581 | Murid</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Nilai Saya</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Mata Pelajaran</th>
            <th>Nilai</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['grade']; ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <a href="profile.php" class="btn btn-primary">Lihat Profil</a>
    <a href="logout.php" class="btn btn-secondary">Logout</a>
</div>
</body>
</html>
