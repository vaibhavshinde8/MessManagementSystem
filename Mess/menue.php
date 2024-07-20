<?php

$conn = new mysqli('localhost', 'root', '', 'mess');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function getMenu($mess_id, $conn) {
    $sql = "SELECT * FROM Menu WHERE mess_id = '$mess_id'";
    $result = $conn->query($sql);
    $menu = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $menu[$row['day_of_week']] = $row;
        }
    }
    return $menu;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mess_id = $_GET['mess_id'] ?? null;
    foreach ($_POST as $day => $meal) {
        $sql = "UPDATE Menu SET lunch='$meal[0]', dinner='$meal[1]' WHERE mess_id='$mess_id' AND day_of_week='$day'";
        $conn->query($sql);
    }
   
    header("Location: {$_SERVER['PHP_SELF']}?mess_id=$mess_id");
    exit();
}


$mess_id = $_GET['mess_id'] ?? null;


$menu = getMenu($mess_id, $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Menu</title>
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
        <h2 class="mb-4">Update Menu</h2>
        <form method="post">
            <?php foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day): ?>
                <div class="form-group">
                    <label><?= $day ?></label>
                    <input type="text" class="form-control" name="<?= $day ?>[]" value="<?= $menu[$day]['lunch'] ?? '' ?>" placeholder="Lunch">
                    <input type="text" class="form-control mt-2" name="<?= $day ?>[]" value="<?= $menu[$day]['dinner'] ?? '' ?>" placeholder="Dinner">
                </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary">Update Menu</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
