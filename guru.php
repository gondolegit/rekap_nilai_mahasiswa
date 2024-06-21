<?php
session_start();
include 'config.php';

if ($_SESSION['status'] != 'guru') {
    header("Location: login.php");
    exit();
}

$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

$sql = "SELECT users.id, users.username, users.fullname, users.email, users.phone,
               IFNULL(AVG(grades.grade), 0) AS average_grade
        FROM users
        LEFT JOIN grades ON users.id = grades.user_id
        WHERE users.status = 'murid' AND (users.username LIKE '%$search_query%' OR users.id LIKE '%$search_query%')
        GROUP BY users.id
        ORDER BY average_grade DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALDO 211011401581 | Guru</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Ranking Siswa</h2>
    <form method="get" action="guru.php">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Cari murid berdasarkan nama atau ID" name="search" value="<?php echo $search_query; ?>">
            <button class="btn btn-primary" type="submit">Cari</button>
        </div>
    </form>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>No. Telepon</th>
            <th>Nilai Rata-rata</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['fullname']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['average_grade']; ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <a href="manage_subjects.php" class="btn btn-primary">Manage Subjects</a>
    <a href="manage_grades.php" class="btn btn-primary">Manage Grades</a>
    <a href="logout.php" class="btn btn-secondary">Logout</a>
</div>
</body>
</html>
