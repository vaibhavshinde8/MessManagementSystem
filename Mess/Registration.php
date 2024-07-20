<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Page</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
        <nav>
                <img src="icons8-cooking-64.png" class="logo">
            <div class="menu">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="Admin.html">Admin</a></li>
                    <li><a href="user.html">User</a></li>
                  </ul>
            </div>
        </nav>
    </header>

  <div class="registration-container">
    <h2>Register</h2>
    <form id="registration-form" action="Register.php" method="post">
      <div class="input-group">
        <label for="full-name">Full Name:</label>
        <input type="text" id="full-name" name="fullname" required>
      </div>
      <div class="input-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="input-group">
        <label for="phone-number">Phone Number:</label>
        <input type="tel" id="phone-number" name="phone-number" required>
      </div>
      <div class="input-group">
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="other">Other</option>
        </select>
      </div>
      <div class="input-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="input-group">
        <label for="confirm-password">Confirm Password:</label>
        <input type="password" id="confirm-password" name="confirm-password" required>
      </div>
      <button type="submit" class="btn-register">Register</button>
    </form>
    <p>Already have an account? <a href="user.php">Login here</a></p>
  </div>

</body>
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
  }

  .registration-container {
    max-width: 400px;
    margin: 100px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  .registration-container h2 {
    text-align: center;
    margin-bottom: 20px;
  }

  .input-group {
    margin-bottom: 15px;
  }

  .input-group label {
    display: block;
    margin-bottom: 5px;
  }

  .input-group input,
  .input-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
  }

  .btn-register {
    display: block;
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
  }

  .btn-register:hover {
    background-color: #0056b3;
  }

  p {
    text-align: center;
  }

  p a {
    color: #007bff;
    text-decoration: none;
  }

  p a:hover {
    text-decoration: underline;
  }
</style>
</html>
