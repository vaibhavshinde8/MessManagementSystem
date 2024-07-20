<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_GET['student_id'] ?? null;
    $conn = new mysqli('localhost', 'root', '', 'mess');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql_check_enrollment = "SELECT COUNT(*) AS count FROM Enrollment WHERE student_id = ? And remaining_attempts>0";
    $stmt_check_enrollment = $conn->prepare($sql_check_enrollment);
    $stmt_check_enrollment->bind_param("i", $student_id);
    $stmt_check_enrollment->execute();
    $result_check_enrollment = $stmt_check_enrollment->get_result();
    $row_check_enrollment = $result_check_enrollment->fetch_assoc();
    $enrollment_count = $row_check_enrollment['count'];

    if ($enrollment_count > 0) {
        echo "<script>alert('You are already enrolled in a mess!');</script>";
    } else {
        $selected_plan = $_POST["selected_plan"];
        switch ($selected_plan) {
            case "1_time":
                $remaining_attempts = 1;
                break;
            case "15_days":
                $remaining_attempts = 30;
                break;
            case "20_days":
                $remaining_attempts = 60;
                break;
            case "1_month":
                $remaining_attempts = 30;
                break;
            default:
                $remaining_attempts = 0;
        }
        $mess_id = $_GET['mess_id'] ?? null;
        $pricing_id = 1; 

        $stmt = $conn->prepare("INSERT INTO Enrollment (student_id, mess_id, pricing_id, remaining_attempts) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiii", $student_id, $mess_id, $pricing_id, $remaining_attempts);
        if ($stmt->execute()) {
            echo "<script>alert('Enrollment successful!');</script>";
        } else {
            echo "<script>alert('Enrollment failed!');</script>";
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: beige;
        }

        
        .food-mess-profile {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
        }

        .photo img {
            width: 100%;
            max-width: 400px;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .details {
            text-align: center;
        }

        .details h1 {
            margin: 0;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .details p {
            margin: 5px 0;
            font-size: 16px;
        }

        .details p span {
            font-weight: bold;
        }

        .btn-group {
            margin-top: 20px;
        }

        .pricing {
            display: flex;
            text-align: center;
            justify-content: center;
            justify-content: space-evenly;
            margin-top: 20px;
        }

        .pricing div {
            flex: 1;
        }

        .enroll-btn {
            margin-top: 20px;
        }

        .footer {
            background-color: #333;
            color: #fff;
            padding: 50px 0;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .footer-section {
            flex: 1;
            min-width: 200px;
            margin-bottom: 20px;
        }

        .footer-section h2 {
            color: #fff;
        }

        .footer-section p {
            color: #ccc;
        }

        .footer-section ul {
            list-style-type: none;
            padding: 0;
        }

        .footer-section a {
            color: #ccc;
            text-decoration: none;
        }

        .footer-section a:hover {
            color: #fff;
        }

        .footer-bottom {
            background-color: #222;
            text-align: center;
            padding: 10px 0;
            color: #ccc;
        }

        .back {
            background-color: #222;
        }
    </style>
</head>
<body>
    <ul class="nav justify-content-end fixed-top">
        <li class="nav-item me-4 mt-2">
        <a href="dashboard.php?student_id=<?php echo isset($_GET['student_id']) ? $_GET['student_id'] : ''; ?>" class="btn btn-outline-success">Dashboard</a>
    </li>

        </li>
        <li class="nav-item me-4 mt-2">
        <a href="student.php?student_id=<?php echo isset($_GET['student_id']) ? $_GET['student_id'] : ''; ?>" class="btn btn-outline-success">Home</a>
    </li>
        </li>
    </ul>

    <section class="food-mess-profile border">
        <?php
        $conn = new mysqli('localhost', 'root', '', 'mess');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $mess_id = $_GET['mess_id'] ?? null;
        if (!$mess_id) {
            echo "Mess ID not provided!";
            exit;
        }
        $sql = "SELECT * FROM mess WHERE mess_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $mess_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            <div class="photo">
                <img src="<?php echo $row['image1']; ?>" alt="Mess Photo">
            </div>
            <div class="details">
                <h1><?php echo $row['mess_name']; ?></h1>
                <p>Owner: <?php echo $row['owner_name']; ?></p>
                <p>Location: <?php echo $row['location']; ?></p>
                <?php
                $sql = "SELECT * FROM Pricing WHERE mess_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $mess_id);
                $stmt->execute();
                $pricing_result = $stmt->get_result();
                if ($pricing_result->num_rows > 0) {
                    $pricing_row = $pricing_result->fetch_assoc();
                    ?>
                    <div class="pricing">
                        <div>
                            <p>One Time Price: <span><?php echo $pricing_row['price_1_time']; ?></span></p>
                            <p>15 Days Price: <span><?php echo $pricing_row['price_15_days']; ?></span></p>
                            <p>30 Days Price: <span><?php echo $pricing_row['price_30_days']; ?></span></p>
                        </div>
                    </div>
                    <?php
                } else {
                    echo "Pricing not found!";
                }
                ?>
<form method="post">
    <div class="mb-3">
        <label for="selected_plan" class="form-label">Select Plan:</label>
        <select class="form-select" id="selected_plan" name="selected_plan">
            <option value="1_time">One Time</option>
            <option value="15_days">15 Days</option>
            <option value="20_days">20 Days</option>
            <option value="1_month">1 Month</option>
        </select>
    </div>
    <div class="enroll-btn">
        <button type="submit" class="btn btn-primary">Enroll</button>
    </div>
</form>

            </div>
            <?php
        } else {
            echo "No mess found!";
        }
        $conn->close();
        ?>
    </section>
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section about">
                    <h2>About Us</h2>
                    <p>Your mess management system website provides easy solutions for managing meals, payments, and more.</p>
                </div>
                <div class="footer-section contact">
                    <h2>Contact Us</h2>
                    <p>Email: info@messmanagement.com</p>
                    <p>Phone: +1 (123) 456-7890</p>
                </div>
                <div class="footer-section links">
                    <h2>Quick Links</h2>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2024 Mess Management System. All rights reserved.
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
