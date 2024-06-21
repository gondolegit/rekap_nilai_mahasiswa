<?php
session_start();
include 'config.php';

if ($_SESSION['status'] != 'guru') {
    header("Location: login.php");
    exit();
}

// Handle form submissions for adding, updating, and deleting subjects
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_subject'])) {
        $name = $_POST['name'];
        $sql = "INSERT INTO subjects (name) VALUES ('$name')";
        $conn->query($sql);
    } elseif (isset($_POST['update_subject'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $sql = "UPDATE subjects SET name = '$name' WHERE id = $id";
        $conn->query($sql);
    } elseif (isset($_POST['delete_subject'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM subjects WHERE id = $id";
        $conn->query($sql);
    }
}

$sql = "SELECT * FROM subjects";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALDO 211011401581 | Manage Subjects</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Manage Subjects</h2>
    <form method="post" action="manage_subjects.php">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Subject Name" name="name" required>
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit" name="add_subject">Add Subject</button>
            </div>
        </div>
    </form>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td>
                    <form method="post" action="manage_subjects.php" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
                        <button class="btn btn-warning" type="submit" name="update_subject">Update</button>
                    </form>
                    <form method="post" action="manage_subjects.php" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button class="btn btn-danger" type="submit" name="delete_subject">Delete</button>
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
