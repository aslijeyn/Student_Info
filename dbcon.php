
<?php
$con = mysqli_connect("localhost", "root", "", "Student_Info");

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($con, "utf8mb4");
?>
