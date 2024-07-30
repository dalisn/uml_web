<?php
session_start();
include_once 'dbConnect.php';



$query = "SELECT * FROM transactions ORDER BY transaction_date DESC";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaction History</title>
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
            <h2>Transaction History</h2>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>From Account</th>
                        <th>To Account</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['transaction_id']; ?></td>
                        <td><?php echo $row['from_account']; ?></td>
                        <td><?php echo $row['to_account']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo $row['transaction_date']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
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
