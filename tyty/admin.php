<?php
session_start();
include("dbConnect.php");

extract($_POST);

if (isset($login)) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM admin WHERE email = ? AND password = ?");
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) < 1) {
        $found = "N";
    } else {
        $_SESSION['email'] = $email;
        $row = mysqli_fetch_array($result);
        $_SESSION['name'] = $row['Name'];
    }

    mysqli_stmt_close($stmt);
}

if (isset($_SESSION['email'])) {
    header("Location: admin2.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="css/jquery.min.js"></script>
    <script src="css/bootstrap.min.js"></script>
</head>

<body>
   <div class="container">
     <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Our Banking Management System</a>
            </div>
            <ul class="nav navbar-nav pull-right">
                <li><a href="admin.php">Home</a></li>
                <li><a href="index.php">User Login</a></li>
                <li><a href="admin.php">Admin Login</a></li>
            </ul>
        </div>
     </nav>

     <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Admin Login</h2>
        </div>

        <div class="panel-body">
          <div style="max-width: 600px; margin: 0 auto">
            <form action="" method="post">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="text" name="email" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" />
                </div>
                <button type="submit" name="login" class="btn btn-success">Login</button>
            </form>
         </div>
        </div>
     </div>

     <div class="well">
        <h3> 
           <span class="pull-right"> </span>
        </h3>
     </div>   
   </div>
</body>
</html>
