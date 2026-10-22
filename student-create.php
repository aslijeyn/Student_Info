<?php
session_start();
require 'dbcon.php';
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Create Student</title>
</head>
<body>
  
    <div class="container mt-5">

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Add Student
                            <a href="index.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST">

                            <!-- Student Details -->
                            <div class="mb-3">
                                <label>Student Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Student Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Student Phone</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Student Course</label>
                                <input type="text" name="course" class="form-control" required>
                            </div>

                            <hr>
                            <h5>Subjects</h5>
                            <div id="subjects-area">
                                <div class="row g-2 subject-field mb-3">
                                    <div class="col-md-3">
                                        <input type="text" name="subject_code[]" class="form-control" placeholder="Subject Code" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="subject_name[]" class="form-control" placeholder="Subject Name" required>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" name="units[]" class="form-control" placeholder="Units" required>
                                    </div>
                                    
                                </div>
                            </div>

                            <button type="button" class="btn btn-success mb-3" onclick="addSubject()">+ Add Subject</button>
                            <button type="submit" name="save_student" class="btn btn-primary mb-3">Save Student</button>
                           

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
function addSubject() {
    let div = document.createElement('div');
    div.classList.add('row','g-2','subject-field','mb-3');
    div.innerHTML = `
        <div class="col-md-3">
            <input type="text" name="subject_code[]" class="form-control" placeholder="Subject Code" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="subject_name[]" class="form-control" placeholder="Subject Name" required>
        </div>
        <div class="col-md-2">
            <input type="number" name="units[]" class="form-control" placeholder="Units" required>
        </div>
    
    `;
    document.getElementById('subjects-area').appendChild(div);
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>