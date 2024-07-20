<?php

$conn = new mysqli('localhost', 'root', '', 'mess');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    function updateAttendance($student_id, $meal_type, $attendance_state, $mess_id, $date, $conn) {
        $sql = "INSERT INTO attendance (student_id, mess_id, date, Attendance_type, attendance_state) 
                VALUES ('$student_id', '$mess_id', '$date', '$meal_type', '$attendance_state')
                ON DUPLICATE KEY UPDATE attendance_state = '$attendance_state'";
        return $conn->query($sql);
    }

  
    if (isset($_POST['lunch'])) {
        $lunch_state = $_POST['lunch'];
        foreach ($lunch_state as $student_id => $attendance_state) {
            $sql = "SELECT fees_status, remaining_attempts FROM Enrollment WHERE student_id = '$student_id' AND mess_id = '$_GET[mess_id]'";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($row['fees_status'] == 'paid' && $row['remaining_attempts'] > 0) {
                    $date = date("Y-m-d");
                    $result = updateAttendance($student_id, 'lunch', $attendance_state, $_GET['mess_id'], $date, $conn);
                    if (!$result) {
                        echo "Error updating lunch attendance.";
                        exit;
                    }
                   
                    if ($attendance_state == 'present') {
                        $sql = "UPDATE Enrollment SET remaining_attempts = remaining_attempts - 1 WHERE student_id = '$student_id'";
                        $conn->query($sql);
                    }
                }
            }
        }
    }

 
    if (isset($_POST['dinner'])) {
        $dinner_state = $_POST['dinner'];
        foreach ($dinner_state as $student_id => $attendance_state) {
            $sql = "SELECT fees_status, remaining_attempts FROM Enrollment WHERE student_id = '$student_id' AND mess_id = '$_GET[mess_id]'";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($row['fees_status'] == 'paid' && $row['remaining_attempts'] > 0) {
                    $date = date("Y-m-d");
                    $result = updateAttendance($student_id, 'dinner', $attendance_state, $_GET['mess_id'], $date, $conn);
                    if (!$result) {
                        echo "Error updating dinner attendance.";
                        exit;
                    }
                  
                    if ($attendance_state == 'present') {
                        $sql = "UPDATE Enrollment SET remaining_attempts = remaining_attempts - 1 WHERE student_id = '$student_id'";
                        $conn->query($sql);
                    }
                }
            }
        }
    }

  
    $mess_id = $_GET['mess_id'] ?? null;
    header("Location: mark.php?mess_id=$mess_id");
    exit();
}


$mess_id = $_GET['mess_id'] ?? null;
$sql = "SELECT e.student_id, s.full_name 
        FROM Enrollment e
        INNER JOIN Students s ON e.student_id = s.student_id
        WHERE e.mess_id = '$mess_id' AND e.fees_status = 'paid' AND e.remaining_attempts > 0";
$result = $conn->query($sql);
$students = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[$row['student_id']] = $row['full_name'];
    }
}


$attendanceExists = [];
$date = date("Y-m-d");
foreach ($students as $student_id => $student_name) {
    $sql = "SELECT * FROM attendance WHERE student_id = '$student_id' AND mess_id = '$mess_id' AND date = '$date'";
    $result = $conn->query($sql);
    $attendanceExists[$student_id] = $result && $result->num_rows > 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mark Attendance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script>

    function showSuccessAlert() {
        alert("Attendance submitted successfully!");
    }
  </script>
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
  <div style="width: 100%;" class="container mt-5">
      <div class="row">
          <div class="col-sm-8 mt-4">
              <div class="card" style="margin-left: 5px;">
                  <div class="card-body ">
                      <h5 class="card-title">Mark Attendance</h5>
                      <br>
                      <form method="post" onsubmit="showSuccessAlert()">
                          <table class="table">
                              <thead>
                                  <tr>
                                      <th>Student Name</th>
                                      <th>Lunch</th>
                                      <th>Dinner</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php foreach ($students as $student_id => $student_name): ?>
                                      <tr>
                                          <td><?= $student_name ?></td>
                                          <td>
                                              <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="lunch[<?= $student_id ?>]" id="flexRadioDefaultLunchPresent_<?= $student_id ?>" value="present" <?= $attendanceExists[$student_id] ? 'disabled' : '' ?>>
                                                  <label class="form-check-label" for="flexRadioDefaultLunchPresent_<?= $student_id ?>">
                                                      Present
                                                  </label>
                                              </div>
                                              <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="lunch[<?= $student_id ?>]" id="flexRadioDefaultLunchAbsent_<?= $student_id ?>" value="absent" checked <?= $attendanceExists[$student_id] ? 'disabled' : '' ?>>
                                                  <label class="form-check-label" for="flexRadioDefaultLunchAbsent_<?= $student_id ?>">
                                                      Absent
                                                  </label>
                                              </div>
                                          </td>
                                          <td>
                                              <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="dinner[<?= $student_id ?>]" id="flexRadioDefaultDinnerPresent_<?= $student_id ?>" value="present" <?= $attendanceExists[$student_id] ? 'disabled' : '' ?>>
                                                  <label class="form-check-label" for="flexRadioDefaultDinnerPresent_<?= $student_id ?>">
                                                      Present
                                                  </label>
                                              </div>
                                              <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="dinner[<?= $student_id ?>]" id="flexRadioDefaultDinnerAbsent_<?= $student_id ?>" value="absent" checked <?= $attendanceExists[$student_id] ? 'disabled' : '' ?>>
                                                  <label class="form-check-label" for="flexRadioDefaultDinnerAbsent_<?= $student_id ?>">
                                                      Absent
                                                  </label>
                                              </div>
                                          </td>
                                      </tr>
                                  <?php endforeach; ?>
                              </tbody>
                          </table>
                          <div class="d-grid gap-2">
                              <button class="btn btn-primary" type="submit">Submit</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
