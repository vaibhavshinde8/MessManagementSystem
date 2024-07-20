<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body{
            background-color:#C2CAD0;
        }
        .card-body {
            align-items: center;
            text-align: center;
            background-color: rgba(19, 40, 20, 0.754);
        }

        .card-img-top {
            height: 200px; 
            object-fit: cover;
        }
        .nav-item{
            margin-left:2px;
        }
        /* Footer styles */
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

        .back{
            background-color:#222;
        }

    </style>
</head>
<body>
<ul class="nav justify-content-end fixed-top">
    <li class="nav-item me-4 mt-2">
        <a href="dashboard.php?student_id=<?php echo isset($_GET['student_id']) ? $_GET['student_id'] : ''; ?>" class="btn btn-outline-success">Dashboard</a>
    </li>
    <li class="nav-item me-4 mt-2">
        <form action="logout.php" method="post">
            <button type="submit" class="btn btn-outline-primary">Log Out</button>
        </form>
    </li>
</ul>


    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            $conn = new mysqli('localhost', 'root', '', 'mess');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

    
            $student_id = $_GET['student_id'] ?? null;

            $sql = "SELECT * FROM mess";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col">
                        <a href="mess_info.php?mess_id=<?php echo $row['mess_id']; ?>&student_id=<?php echo $student_id; ?>" class="text-decoration-none">
                            <div class="card h-100">
                                <img src="<?php echo $row['image1']; ?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['mess_name']; ?></h5>
                                    <p><?php echo $row['location']; ?></p>
                                    <p><?php echo $row['owner_name']; ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                }
            } else {
                echo "No mess found";
            }
            $conn->close();
            ?>
        </div>
    </div>

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
