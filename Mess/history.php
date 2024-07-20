<?php

$conn = new mysqli('localhost', 'root', '', 'mess');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function getEnrolledStudents($mess_id, $conn) {
    $sql = "SELECT s.full_name, s.email, s.phone_number, e.date
            FROM students s
            INNER JOIN Enrollment e ON s.student_id = e.student_id
            WHERE e.mess_id = '$mess_id'";
    $result = $conn->query($sql);
    $students = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
    }
    return $students;
}


$mess_id = $_GET['mess_id'] ?? null;


$enrolled_students = getEnrolledStudents($mess_id, $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrolled Students History</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
     .header {
      background-color: #007bff;
      color: #fff;
      padding: 5px; 
      text-align: center; 
    }
    .butt{
      margin-left: 93%;
      margin-top: 1%;
    }
  </style>
</head>
<body>
<div class="header">
    <h1>Mess Management System</h1>
  </div>
 <div class="butt">

   <a href="admindash.php?mess_id=<?= $_GET['mess_id'] ?>" class="btn btn-primary">Home</a>
  </div>
    <div class="container mt-5">
        <h2 class="mb-4">Enrolled Students History</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Enrolled Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enrolled_students as $student): ?>
                        <tr>
                            <td><?= $student['full_name'] ?></td>
                            <td><?= $student['email'] ?></td>
                            <td><?= $student['phone_number'] ?></td>
                            <td><?= $student['date'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
