
<?php
session_start();
require 'dbcon.php';

if (isset($_POST['delete_student'])) {
    $id = (int) $_POST['delete_student'];

    $stmt = mysqli_prepare($con, "DELETE FROM Students WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    $success = mysqli_stmt_execute($stmt);

    $_SESSION['message'] = $success
        ? "Student Deleted Successfully"
        : "Student Not Deleted";

    header("Location: index.php");
    exit();
}

if (isset($_POST['update_student'])) {
    $id = (int) $_POST['student_id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $course = trim($_POST['course']);

    $stmt = mysqli_prepare(
        $con,
        "UPDATE Students SET name=?, email=?, phone=?, course=? WHERE id=?"
    );
    mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $phone, $course, $id);
    $success = mysqli_stmt_execute($stmt);

    $_SESSION['message'] = $success
        ? "Student Updated Successfully"
        : "Student Not Updated";

    header("Location: index.php");
    exit();
}

if (isset($_POST['save_student'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $course = trim($_POST['course']);

    $codes = $_POST['subject_code'] ?? [];
    $names = $_POST['subject_name'] ?? [];
    $units = $_POST['units'] ?? [];

    if (count($codes) === 0 || count($codes) !== count($names) ||
        count($codes) !== count($units)) {
        $_SESSION['message'] = "Please enter valid subject information.";
        header("Location: student-create.php");
        exit();
    }

    mysqli_begin_transaction($con);

    try {
        $stmt = mysqli_prepare(
            $con,
            "INSERT INTO Students (name, email, phone, course) VALUES (?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone, $course);

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Unable to save student.");
        }

        $student_id = mysqli_insert_id($con);

        $sub_stmt = mysqli_prepare(
            $con,
            "INSERT INTO Student_subjects
            (student_id, subject_code, subject_name, units)
            VALUES (?, ?, ?, ?)"
        );

        foreach ($codes as $i => $code) {
            $code = trim($code);
            $subname = trim($names[$i]);
            $unit = (int) $units[$i];

            mysqli_stmt_bind_param(
                $sub_stmt, "issi", $student_id, $code, $subname, $unit
            );

            if (!mysqli_stmt_execute($sub_stmt)) {
                throw new Exception("Unable to save subject.");
            }
        }

        mysqli_commit($con);
        $_SESSION['message'] = "Student and subjects saved successfully!";
        header("Location: index.php");
        exit();
    } catch (Throwable $e) {
        mysqli_rollback($con);
        $_SESSION['message'] = "Unable to save student and subjects.";
        header("Location: student-create.php");
        exit();
    }
}
?>
