<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mess Management System - Bootstrap demo</title> <!-- Added header -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    .header {
      background-color: #007bff; 
      color: #fff;
      padding: 5px; 
      text-align: center; 
    }
    .sub-header {
      background-color: #6c757d; 
      color: #fff; 
      padding: 5px; 
      text-align: center;
      width: fit-content;
      padding: 10px;
      margin-left: auto;
      margin-right: auto;
      margin-top: 2%;
    }
    .admin{
      display: flex;
    }
    .butt{
      margin-right: 2%;
      margin-top: 2%;
    }
    .custom-text-color {
      color: black;
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

        .back{
            background-color:#222;
        }

  </style>
</head>
<body>

  <div class="header">
    <h1>Mess Management System</h1>
  </div>



 <div class="admin">
  <div class="sub-header">

    

    <h2>Admin Dashboard</h2>
    
  </div>
  

  <div class="butt">
  
    <a href="logout.php"><button type="button" class="btn btn-primary">Log Out</button></a>
  </div>
</div>

</div>

  
<div style="width: 100%;" class="container mt-5">
    <div class="row">
      
        <div class="col-sm-3 mt-4">
            <div class="card" style="margin-left: 5px;">
                <div class="card-body">
                    <h5 class="card-title">Mark Todays Attendance</h5>
                    <div class="d-grid gap-2">
                    <a href="mark.php?mess_id=<?= $_GET['mess_id'] ?>" class="btn btn-primary">Mark</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 mt-4">
            <div class="card" style="margin-left: 5px;">
                <div class="card-body">
                    <h5 class="card-title">Todays Attendance Status:</h5>
                    <div class="d-grid gap-2">
                    <a href="cheack_attendance.php?mess_id=<?= $_GET['mess_id'] ?>" class="btn btn-primary">cheak</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 mt-4">
            <div class="card" style="margin-left: 5px;">
                <div class="card-body">
                    <h5 class="card-title">Total Enroll Students</h5>
                    <div class="d-grid gap-2">
                    <a href="enrolled2.php?mess_id=<?= $_GET['mess_id'] ?>" class="btn btn-primary">Check</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 mt-4">
            <div class="card" style="margin-left: 5px;">
                <div class="card-body">
                    <h5 class="card-title">Unpaid fee Students</h5>
                    <div class="d-grid gap-2">
                    <a href="enrolled.php?mess_id=<?= $_GET['mess_id'] ?>" class="btn btn-primary">cheak</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        
        <div class="col-sm-3 mt-4">
            <div class="card" style="margin-left: 5px;">
                <div class="card-body">
                    <h5 class="card-title">Update Menu</h5>
                    <div class="d-grid gap-2">
                    <a href="menue.php?mess_id=<?= $_GET['mess_id'] ?>" class="btn btn-primary">cheak</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 mt-4">
            <div class="card" style="margin-left: 5px;">
                <div class="card-body">
                    <h5 class="card-title">Payment History</h5>
                    <div class="d-grid gap-2">
                    <a href="history.php?mess_id=<?= $_GET['mess_id'] ?>" class="btn btn-primary">cheak</a>
                    </div>
                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <div class="footer-bottom">
        &copy; 2024 Mess Management System. All rights reserved.
    </div>
</footer>


</body>
</html>