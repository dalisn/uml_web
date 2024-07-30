<?php
session_start();
include_once 'Account.php';
include("dbConnect.php");

if (isset($_POST['login2'])) {
    $obAccount2 = new Account($conn); // Pass the database connection to the constructor
    $res1 = $obAccount2->closeAccount($_SESSION['aNum']);

    $res2 = $conn->query("DELETE FROM depositor WHERE Account_number = '$_SESSION[aNum]'");

    if ($res2) {
        ?>
        <script>
        alert('Account is closed Successfully...');
        window.location = 'admin2.php';
        </script>
        <?php
    } else {
        ?>
        <script>
        alert('Error Occurred...');
        window.location = 'admin2.php';
        </script>
        <?php
    }
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
            <li><a href="admin2.php">Home</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>
     </nav>

     <div class="panel panel-default">
      <div class="panel-heading">
        <h2>Deposit Money</h2>
      </div>

      <div class="panel-body">
        <div style="max-width: 600px; margin: 0 auto">
            <?php
               $acNum = $_POST['acNo'];
               $obAccount = new Account($conn); // Pass the database connection to the constructor
               $rs = $obAccount->showAccountInfo($acNum);

               if ($rs->num_rows < 1) { 
                  ?>
                  <p>Invalid Account Number </p><a href="deposit.php">Try again!</a>
                  <?php
                  die($conn->error); // TODO: better error handling
               }       
               $row = $rs->fetch_array();
            ?>
            
            <table class="table table-striped">
              <tr>
                  <td width="35%">Account Number: </td>
                  <th><?php echo $row[1]; $_SESSION['aNum'] = $row[1]; ?></th>                  
              </tr> 
              <tr>
                  <td width="35%">Customer Name: </td>
                  <th><?php echo $row[0]; $_SESSION['aName'] = $row[1]; ?></th>
              </tr> 
              <tr>
                <td width="35%">Balance: </td>
                <th><?php echo $row[2]; ?></th>
              </tr>
              <tr>
                <td width="35%">Branch Name: </td>
                <th><?php echo $row[3]; ?></th>
              </tr>
              <tr>
                <td width="35%">Branch City: </td>
                <th><?php echo $row[4]; ?></th>
              </tr>
              <tr>
                <td width="35%">Customer Street: </td>
                <th><?php echo $row[5]; ?></th>
              </tr>
              <tr>
                <td width="35%">Customer City: </td>
                <th><?php echo $row[6]; ?></th>
              </tr>
            </table>

            <form action="" method="post">
              <button type="submit" name="login2" class="btn btn-success">Close</button>
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
