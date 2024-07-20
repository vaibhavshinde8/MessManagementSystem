<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    date_default_timezone_set('Asia/Kolkata');
    $conn = new mysqli('localhost', 'root', '', 'mess');
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    if (isset($_POST['attendance_state'], $_POST['student_id'], $_POST['attendance_type'], $_POST['mess_id'], $_POST['attendance_date'])) {
        $student_id = intval($_POST['student_id']);
        $attendance_type = ($_POST['attendance_type'] == 'lunch' || $_POST['attendance_type'] == 'dinner') ? $_POST['attendance_type'] : null;
        $attendance_state = $_POST['attendance_state'];
        $mess_id = intval($_POST['mess_id']);
        $attendance_date = date('Y-m-d', strtotime($_POST['attendance_date'])); 
    
        if (!$student_id || !$attendance_type || !$mess_id || !$attendance_date) {
            die("Invalid input data.");
        }
        
        $existing_entry_sql = "SELECT * FROM attendance WHERE student_id = ? AND mess_id = ? AND attendance_type = ? AND date = ?";
        $existing_entry_stmt = $conn->prepare($existing_entry_sql);
        $existing_entry_stmt->bind_param("iiss", $student_id, $mess_id, $attendance_type, $attendance_date);
        $existing_entry_stmt->execute();
        $existing_entry_result = $existing_entry_stmt->get_result();
        
        if ($existing_entry_result->num_rows > 0) {
            header("Location: dashboard.php?student_id=" . $student_id . "&alert=existing_entry");
            exit();
        } else {
            $insert_sql = "INSERT INTO attendance (student_id, mess_id, attendance_type, attendance_state, date) VALUES (?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("iisss", $student_id, $mess_id, $attendance_type, $attendance_state, $attendance_date);
            
            if ($insert_stmt->execute()) {
                header("Location: dashboard.php?student_id=" . $student_id);
                exit();
            } else {
                echo "Error: " . $insert_sql . "<br>" . $conn->error;
            }
            $insert_stmt->close();
        }
        $existing_entry_stmt->close();
    }
}
?>
