<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paid Students</title>
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
    <?php
   
    $conn = new mysqli('localhost', 'root', '', 'mess');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   
    $mess_id = $_GET['mess_id'] ?? null;
  
    $sql = "SELECT s.full_name, e.remaining_attempts
            FROM students s
            INNER JOIN Enrollment e ON s.student_id = e.student_id
            WHERE e.fees_status = 'paid' AND e.remaining_attempts > 0 AND e.mess_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $mess_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table class='table'><thead><tr><th>Student Name</th><th>Remaining Attempts</th></tr></thead><tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['full_name'] . "</td><td>" . $row['remaining_attempts'] . "</td></tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-info' role='alert'>No paid students with remaining attempts found.</div>";
    }

    $stmt->close();
    $conn->close();
    ?>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
