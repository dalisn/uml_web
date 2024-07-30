<?php
session_start();
include_once 'dbConnect.php';

// Check if the user is logged in as admin
if (!isset($_SESSION['admin'])) {
    echo "Access denied. Please log in as an admin.";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password

    // Insert new user into the user table
    $stmt = $conn->prepare("INSERT INTO user (Name, Email, Password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    try {
        if ($stmt->execute()) {
            echo "<script>alert('User added successfully');</script>";
        } else {
            // Handle error for duplicate email
            if ($conn->errno == 1062) {
                echo "<script>alert('Error: Email already exists');</script>";
            } else {
                echo "<script>alert('Error adding user');</script>";
            }
        }
    } catch (Exception $e) {
        echo "<script>alert('Error adding user: " . $e->getMessage() . "');</script>";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
   <div class="container">
     <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="admin2.php">Our Banking Management System</a>
            </div>
            <ul class="nav navbar-nav pull-right">
                <li><a href="admin2.php">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
     </nav>

     <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Add New User</h2>
        </div>
        <div class="panel-body">
            <form method="post" action="addUser.php">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Add User</button>
            </form>
        </div>
     </div>

     <div class="well">
        <h3>www.mycompany.com
           <span class="pull-right">Like Us: www.facebook.com/samy</span>
        </h3>
     </div>   
   </div>
</body>
</html>
