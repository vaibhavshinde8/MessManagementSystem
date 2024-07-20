<?php
    $conn = new mysqli('localhost', 'root', '', 'mess');
    if($conn->connect_error){
        die("Connection failed!! " . $conn->connect_error);
    }
    $name = htmlspecialchars($_POST['fullname']);
    $ph = htmlspecialchars($_POST['phone-number']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO students (full_name, email, phone_number, gender, password) VALUES ('$name', '$email', '$ph', 'male', '$hashedPassword')";
    if($conn->query($sql) === TRUE){
        $conn->close(); 
        header("Location: user.php");
        exit; 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>
