<?php
session_start();
include_once 'Account.php';
include_once 'dbConnect.php';
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
            <li><a href="admin2.php">Home</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>
     </nav>

     <div class="panel panel-default">
      <div class="panel-heading">
        <h2>Account's Information</h2>
      </div>

      <div class="panel-body">
            <?php
               $obAccount = new Account($conn);
               
               $rs2 = $obAccount->showAllAccountInfo();

               if ($rs2->num_rows < 1) { 
                  ?>
                  <p>Invalid Account Number </p><a href="deposit.php">Try again!</a>
                  <?php
                  die("Error: " . $conn->error); // Improved error handling
               } ?>

              <table class="table table-striped">
                <tr>
                  <td>Account Number</td>
                  <td>Customer Name</td>
                  <td>Customer Street</td>
                  <td>Customer City</td>
                  <td>Balance</td>
                  <td>Branch Name</td>
                  <td>Branch City</td>                  
                </tr>
          <?php  while ($row2 = $rs2->fetch_assoc()) {
            ?>     
              <tr>
                  <td><?php echo $row2['Account_number']; ?></td>
                  <td><?php echo $row2['Customer_name']; ?></td>
                  <td><?php echo $row2['Customer_street']; ?></td>
                  <td><?php echo $row2['Customer_city']; ?></td>
                  <td><?php echo $row2['Balance']; ?></td>
                  <td><?php echo $row2['Branch_name']; ?></td>
                  <td><?php echo $row2['Branch_city']; ?></td>
              </tr>
              <?php } ?>
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
