<?php
$conn = new mysqli('localhost', 'root', '', 'mess');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function getLunchAttendance($mess_id, $conn) {
    $today = date("Y-m-d");
    $sql = "SELECT s.full_name, a.attendance_state 
            FROM students s
            INNER JOIN enrollment e ON s.student_id = e.student_id
            INNER JOIN attendance a ON s.student_id = a.student_id
            WHERE e.mess_id = '$mess_id' AND e.fees_status = 'paid'
            AND a.attendance_type = 'lunch' AND DATE(a.date) = '$today'";
    $result = $conn->query($sql);
    if ($result === false) {
        echo "Error executing query: " . $conn->error;
    } else {
        
    }
    $attendance = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $attendance[] = $row;
        }
    }
    return $attendance;
}


function getDinnerAttendance($mess_id, $conn) {
    $today = date("Y-m-d");
    $sql = "SELECT s.full_name, a.attendance_state 
            FROM students s
            INNER JOIN enrollment e ON s.student_id = e.student_id
            INNER JOIN attendance a ON s.student_id = a.student_id
            WHERE e.mess_id = '$mess_id' AND e.fees_status = 'paid'
            AND a.attendance_type = 'dinner' AND DATE(a.date) = '$today'";
    $result = $conn->query($sql);
    if ($result === false) {
        echo "Error executing query: " . $conn->error;
    } else {
       
    }
    $attendance = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $attendance[] = $row;
        }
    }
    return $attendance;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Attendance</title>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="header">
    <h1>Mess Management System</h1>
  </div>
 <div class="butt">
   
   <a href="admindash.php?mess_id=<?= $_GET['mess_id'] ?>" class="btn btn-primary">Home</a>
  </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Today's Lunch Attendance</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Attendance Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $mess_id = $_GET['mess_id'] ?? null;
                                $lunchAttendance = getLunchAttendance($mess_id, $conn);
                                foreach ($lunchAttendance as $attendance) {
                                    echo "<tr><td>{$attendance['full_name']}</td><td>{$attendance['attendance_state']}</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Today's Dinner Attendance</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Attendance Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $dinnerAttendance = getDinnerAttendance($mess_id, $conn);
                                foreach ($dinnerAttendance as $attendance) {
                                    echo "<tr><td>{$attendance['full_name']}</td><td>{$attendance['attendance_state']}</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
