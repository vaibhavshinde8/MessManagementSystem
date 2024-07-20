<?php

$conn = new mysqli('localhost', 'root', '', 'mess');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function getUnpaidStudents($mess_id, $conn) {
    $sql = "SELECT s.student_id, s.full_name, e.remaining_attempts
            FROM students s
            INNER JOIN Enrollment e ON s.student_id = e.student_id
            WHERE e.mess_id = '$mess_id' AND e.fees_status = 'not paid'";
            
    $result = $conn->query($sql);
    $students = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
    }
    return $students;
}


if (isset($_POST['student_id']) ) {
    $student_id = $_POST['student_id'];
    $mess_id = $_GET['mess_id'];
    
    $sql_update = "UPDATE Enrollment SET fees_status = 'paid' WHERE student_id = '$student_id' AND mess_id = '$mess_id'";
    if ($conn->query($sql_update) === TRUE) {
       
        header("Location: enrolled.php?mess_id=$mess_id");
        exit();
    } else {
        echo "Error updating payment status: " . $conn->error;
    }
}


$mess_id =$_GET['mess_id']; 
$unpaid_students = getUnpaidStudents($mess_id, $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Unpaid Students</title>
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
    <?php if (empty($unpaid_students)): ?>
      <div class="alert alert-info" role="alert">
        No unpaid students found.
      </div>
    <?php else: ?>
      <table class="table">
        <thead>
          <tr>
            <th>Student Name</th>
            <th>Enrolled attempts</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($unpaid_students as $student): ?>
            <tr>
              <td><?= $student['full_name'] ?></td>
              <td><?= $student['remaining_attempts'] ?></td>
              <td>
                <form method="post">
                  <input type="hidden" name="student_id" value="<?= $student['student_id'] ?>">
                  <button type="submit" class="btn btn-primary">Paid</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
