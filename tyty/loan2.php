<?php
session_start();
include_once 'dbConnect.php';
include_once 'Loan.php';

// Check if the user is logged in as admin
if (!isset($_SESSION['admin'])) {
    header("Location: adminLogin.php");
    exit();
}

$loan = new Loan($conn);
$loans = $loan->getAllLoans();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Loan Information</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="css/jquery.min.js"></script>
    <script src="css/bootstrap.min.js"></script>
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
        <h2>Loan Information</h2>
      </div>
      <div class="panel-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Loan Number</th>
              <th>Branch Name</th>
              <th>Amount</th>
              <th>Customer Name</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($loan = $loans->fetch_assoc()) { ?>
            <tr>
              <td><?php echo $loan['Loan_number']; ?></td>
              <td><?php echo $loan['Branch_name']; ?></td>
              <td><?php echo $loan['Amount']; ?></td>
              <td><?php echo $loan['Customer_name']; ?></td>
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
