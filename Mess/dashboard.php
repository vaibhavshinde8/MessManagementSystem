<?php
date_default_timezone_set('Asia/Kolkata');
$conn = new mysqli('localhost', 'root', '', 'mess');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = $_GET['student_id'] ?? null;

$sql_user = "SELECT * FROM students WHERE student_id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $student_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
if ($result_user->num_rows > 0) {
    $row_user = $result_user->fetch_assoc();
    $user_name = $row_user['full_name'];
    $user_email = $row_user['email'];
}
$sql_enrolled_mess = "SELECT enrollment.*, mess.mess_name 
                      FROM enrollment 
                      INNER JOIN mess ON enrollment.mess_id = mess.mess_id 
                      WHERE enrollment.student_id = ? AND enrollment.remaining_attempts > 0";
$stmt_enrolled_mess = $conn->prepare($sql_enrolled_mess);
$stmt_enrolled_mess->bind_param("i", $student_id);
$stmt_enrolled_mess->execute();
$result_enrolled_mess = $stmt_enrolled_mess->get_result();
if ($result_enrolled_mess->num_rows > 0) {
    $row_enrolled_mess = $result_enrolled_mess->fetch_assoc();
    $mess_name = $row_enrolled_mess['mess_name'];
    $remaining_attempts = $row_enrolled_mess['remaining_attempts']; 
    $sql_menu = "SELECT * FROM menu WHERE mess_id = ?";
    $stmt_menu = $conn->prepare($sql_menu);
    $stmt_menu->bind_param("i", $row_enrolled_mess['mess_id']);
    $stmt_menu->execute();
    $result_menu = $stmt_menu->get_result();
    $sql_attendance = "SELECT * FROM attendance WHERE student_id = ? AND mess_id = ?";
    $stmt_attendance = $conn->prepare($sql_attendance);
    $stmt_attendance->bind_param("ii", $student_id, $row_enrolled_mess['mess_id']);
    $stmt_attendance->execute();
    $result_attendance = $stmt_attendance->get_result();
    $attendance_data = array();
    if ($result_attendance->num_rows > 0) {
        while ($row_attendance = $result_attendance->fetch_assoc()) {
            $attendance_data[] = $row_attendance;
        }
    }
} else {
    $mess_name = "";
    $remaining_attempts = 0;
    $result_menu = null;
    $attendance_data = array();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }

        .card {
            margin-bottom: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.03);
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .card-text {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .table th, .table td {
            padding: 10px;
            text-align: center;
        }

        .btn {
            width: 100%;
            border-radius: 10px;
            transition: background-color 0.3s ease-in-out;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
    </style>
</head>
<body>
    <ul  class="nav  justify-content-end fixed-top ">
        <li class="nav-item me-4 mt-2">
            <a href="student.php?student_id=<?php echo $student_id; ?>" class="btn btn-outline-success">Home</a>
        </li>
        <li class="nav-item me-4 mt-2">
        <form action="logout.php" method="post">
            <button type="submit" class="btn btn-outline-primary">Log Out</button>
        </form>
    </li>
    </ul>

    <div class="container">
        <div class="card bg-light">
            <div class="card-body">
                <h5 class="card-title">User Information</h5>
                <p class="card-text">Name: <?php echo $user_name ?? ''; ?></p>
                <p class="card-text">Email: <?php echo $user_email ?? ''; ?></p>
            </div>
        </div>

        <?php if ($mess_name !== ""): ?>
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title">Current Enrolled Mess</h5>
                    <p class="card-text">Mess Name: <?php echo $mess_name; ?></p>
                    <p class="card-text">Remaining Meals: <?php echo $remaining_attempts; ?></p>
                    <p class="card-text">7 Days Menu:</p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th>Lunch</th>
                                <th>Dinner</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($result_menu !== null && $row_menu = $result_menu->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row_menu['day_of_week']; ?></td>
                                    <td><?php echo $row_menu['lunch']; ?></td>
                                    <td><?php echo $row_menu['dinner']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title">Attendance</h5>
                    <p class="card-text">Remaining Meals: <?php echo $remaining_attempts; ?></p>
        
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Attendance Type</th>
                                <th>Attendance State</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($attendance_data as $attendance): ?>
                                <tr>
                                    <td><?php echo $attendance['date']; ?></td>
                                    <td><?php echo $attendance['attendance_type']; ?></td>
                                    <td><?php echo $attendance['attendance_state']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card bg-light" id="lunch_attendance_form">
                <div class="card-body">
                    <h5 class="card-title">Mark Lunch Attendance</h5>
                    <form action="attendance.php" method="post">
                        <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                        <input type="hidden" name="attendance_type" value="lunch">
                        <input type="hidden" name="mess_id" value="<?php echo $row_enrolled_mess['mess_id']; ?>">
                        <input type="hidden" name="attendance_date" value="<?php echo date("Y-m-d"); ?>">
                        <button type="submit" class="btn btn-danger" name="attendance_state" id="lunch" value="absent">Absent</button>
                    </form>
                </div>
            </div>
    
            <div class="card bg-light" id="dinner_attendance_form">
                <div class="card-body">
                    <h5 class="card-title">Mark Dinner Attendance</h5>
                    <form  action="attendance.php" method="post">
                        <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                        <input type="hidden" name="attendance_type" value="dinner">
                        <input type="hidden" name="mess_id" value="<?php echo $row_enrolled_mess['mess_id']; ?>">
                        <input type="hidden" name="attendance_date" value="<?php echo date("Y-m-d"); ?>">
                        <button type="submit" class="btn btn-danger" name="attendance_state" id="dinner" value="absent">Absent</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title">No Mess Enrolled</h5>
                </div>
            </div>
        <?php endif; ?>
        
    </div>

    <div style="max-width: 800px; margin: auto;"class="card bg-light">
        <div class="card-body">
            <h5 class="card-title">Enrollment History</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mess Name</th>
                        <th>Enrolled Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_history = "SELECT mess.mess_name, enrollment.date 
                                    FROM enrollment 
                                    INNER JOIN mess ON enrollment.mess_id = mess.mess_id 
                                    WHERE enrollment.student_id = ? AND enrollment.remaining_attempts < 1";
                    $stmt_history = $conn->prepare($sql_history);
                    $stmt_history->bind_param("i", $student_id);
                    $stmt_history->execute();
                    $result_history = $stmt_history->get_result();

                    while ($row_history = $result_history->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row_history['mess_name']; ?></td>
                            <td><?php echo $row_history['date']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var currentTime = new Date();
        var currentHour = currentTime.getHours();

        if (currentHour >= 10) {
            document.getElementById("lunch").classList.add("disabled");
        }

        if (currentHour > 17) {
            document.getElementById("dinner").classList.add("disabled");
        }
    });
    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
