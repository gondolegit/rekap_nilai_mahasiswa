<?php
session_start();
include 'config.php';

if ($_SESSION['status'] != 'guru') {
    header("Location: login.php");
    exit();
}

$error_message = "";
$search_query = "";

// Handle form submissions for adding, updating, and deleting grades
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_grade'])) {
        $user_id = $_POST['user_id'];
        $subject_id = $_POST['subject_id'];
        $grade = $_POST['grade'];

        // Check for duplicate grade entry
        $check_sql = "SELECT * FROM grades WHERE user_id = '$user_id' AND subject_id = '$subject_id'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            $error_message = "Nilai untuk mata kuliah ini sudah ada untuk siswa tersebut.";
        } else {
            $sql = "INSERT INTO grades (user_id, subject_id, grade) VALUES ('$user_id', '$subject_id', '$grade')";
            $conn->query($sql);
        }
    } elseif (isset($_POST['update_grade'])) {
        $id = $_POST['id'];
        $user_id = $_POST['user_id'];
        $subject_id = $_POST['subject_id'];
        $grade = $_POST['grade'];

        // Check for duplicate grade entry excluding the current record
        $check_sql = "SELECT * FROM grades WHERE user_id = '$user_id' AND subject_id = '$subject_id' AND id != '$id'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            $error_message = "Nilai untuk mata kuliah ini sudah ada untuk siswa tersebut.";
        } else {
            $sql = "UPDATE grades SET user_id = '$user_id', subject_id = '$subject_id', grade = '$grade' WHERE id = $id";
            $conn->query($sql);
        }
    } elseif (isset($_POST['delete_grade'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM grades WHERE id = $id";
        $conn->query($sql);
    }
}

if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

$sql = "SELECT grades.id, users.username, subjects.name as subject, grades.grade, grades.user_id, grades.subject_id
        FROM grades
        JOIN users ON grades.user_id = users.id
        JOIN subjects ON grades.subject_id = subjects.id
        WHERE users.username LIKE '%$search_query%'";
$result = $conn->query($sql);

$sql_users = "SELECT * FROM users WHERE status = 'murid'";
$result_users = $conn->query($sql_users);

$sql_subjects = "SELECT * FROM subjects";
$result_subjects = $conn->query($sql_subjects);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALDO 211011401581 | Manage Grades</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Manage Grades</h2>
    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form method="post" action="manage_grades.php">
        <div class="form-group">
            <label for="user_id">Student</label>
            <select class="form-control" id="user_id" name="user_id" required>
                <?php while ($row_users = $result_users->fetch_assoc()): ?>
                    <option value="<?php echo $row_users['id']; ?>"><?php echo $row_users['username']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="subject_id">Subject</label>
            <select class="form-control" id="subject_id" name="subject_id" required>
                <?php while ($row_subjects = $result_subjects->fetch_assoc()): ?>
                    <option value="<?php echo $row_subjects['id']; ?>"><?php echo $row_subjects['name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="grade">Grade</label>
            <input type="number" class="form-control" id="grade" name="grade" required>
        </div>
        <button type="submit" class="btn btn-primary" name="add_grade">Add Grade</button>
    </form>

    <form method="get" action="manage_grades.php" class="mt-4">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Cari siswa berdasarkan nama" name="search" value="<?php echo $search_query; ?>">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </div>
    </form>

    <table class="table table-striped mt-4">
        <thead>
        <tr>
            <th>ID</th>
            <th>Student</th>
            <th>Subject</th>
            <th>Grade</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['subject']; ?></td>
                <td><?php echo $row['grade']; ?></td>
                <td>
                    <form method="post" action="manage_grades.php" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                        <input type="hidden" name="subject_id" value="<?php echo $row['subject_id']; ?>">
                        <input type="number" name="grade" value="<?php echo $row['grade']; ?>" required>
                        <button class="btn btn-warning" type="submit" name="update_grade">Update</button>
                    </form>
                    <form method="post" action="manage_grades.php" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button class="btn btn-danger" type="submit" name="delete_grade">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <a href="guru.php" class="btn btn-secondary">Back</a>
</div>
</body>
</html>
