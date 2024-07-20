<?php
$conn = new mysqli('localhost', 'root', '', 'mess');
if($conn->connect_error){
    die("Connection failed!! " . $conn->connect_error);
}

$username = $_POST['email'];
$sql = "SELECT student_id, PASSWORD FROM STUDENTS WHERE EMAIL='$username'";
$result = $conn->query($sql);

if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    $student_id = $row['student_id'];
    $hashedPasswordFromDB = $row['PASSWORD'];
    if(password_verify($_POST['password'], $hashedPasswordFromDB)){

        header("LOCATION: student.php?student_id=$student_id");
        exit;
    }
    else{
        echo "<script>alert('Incorrect password. Please try again.');</script>";
    }
}
else{
    echo "User not found";
}
?>
