
<?php
session_start();
require 'dbcon.php';

if (!isset($_SESSION['auth'])) {
    $_SESSION['message'] = "Please login to access the system";
    header("Location: login.php");
    exit();
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

$query = "SELECT * FROM Students ORDER BY id DESC";
$query_run = mysqli_query($con, $query);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>BSIS 3rd Year - Students</title>
</head>
<body>
<div class="container mt-4">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info">
            <?= e($_SESSION['message']); unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h3>BSIS 3rd Year
                <a href="student-create.php" class="btn btn-primary float-end">Add Students</a>
            </h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Course</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($query_run && mysqli_num_rows($query_run) > 0): ?>
                    <?php while ($student = mysqli_fetch_assoc($query_run)): ?>
                    <tr>
                        <td><?= e($student['id']); ?></td>
                        <td><?= e($student['name']); ?></td>
                        <td><?= e($student['email']); ?></td>
                        <td><?= e($student['phone']); ?></td>
                        <td><?= e($student['course']); ?></td>
                        <td>
                            <a href="student-view.php?id=<?= (int)$student['id']; ?>" class="btn btn-info btn-sm">View</a>
                            <a href="student-edit.php?id=<?= (int)$student['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                            <form action="code.php" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this student?');">
                                <button type="submit" name="delete_student"
                                        value="<?= (int)$student['id']; ?>"
                                        class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center">No Record Found</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <a href="logout.php" class="btn btn-outline-secondary mt-3">Logout</a>
</div>
</body>
</html>
