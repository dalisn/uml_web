<?php
session_start();
include_once 'dbConnect.php';
include_once 'Account.php';

if (isset($_POST['login2'])) {
    // Using prepared statements to prevent SQL injection
    $stmt1 = $conn->prepare("UPDATE customer SET Customer_street = ?, Customer_city = ? WHERE Customer_name = ?");
    $stmt1->bind_param("sss", $_POST['cStreet'], $_POST['cCity'], $_SESSION['y']);
    $res2 = $stmt1->execute();

    $stmt2 = $conn->prepare("UPDATE account SET Branch_name = ? WHERE Account_number = ?");
    $stmt2->bind_param("ss", $_POST['cbName'], $_SESSION['x']);
    $res3 = $stmt2->execute();

    if ($res2 && $res3) {
        ?>
        <script>
        alert('Information is updated...');
        window.location='admin2.php';
        </script>
        <?php
    } else {
        ?>
        <script>
        alert('Error updating...');
        window.location='admin2.php';
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
               $obAccount = new Account($conn);
               $acNum = $_POST['acNo'];
               $rs = $obAccount->showAccountInfo($acNum);

               if ($rs->num_rows < 1) { 
                  ?>
                  <p>Invalid Account Number </p><a href="admin2.php">Try again!</a>
                  <?php
                  die("Error: " . $conn->error); // Improved error handling
               }       
               $row = $rs->fetch_assoc();
            ?>

            <form action="" method="post">
             
              <div class="form-group">
                <label for="deposit">Account Number</label>
                <input type="text" name="cNum" disabled class="form-control" value="<?php echo $row['Account_number']; $_SESSION['x'] = $row['Account_number']; ?>" />
              </div>

              <div class="form-group">
                <label for="deposit">Customer Name</label>
                <input type="text" name="cName" disabled class="form-control" value="<?php echo $row['Customer_name']; $_SESSION['y'] = $row['Customer_name']; ?>" />
              </div>

              <div class="form-group">
                <label for="deposit">Branch Name</label>
                <input type="text" name="cbName" required class="form-control" value="<?php echo $row['Branch_name']; ?>" />
              </div>

              <div class="form-group">
                <label for="deposit">Customer Street</label>
                <input type="text" name="cStreet" required class="form-control" value="<?php echo $row['Customer_street']; ?>" />
              </div>

              <div class="form-group">
                <label for="deposit">Customer City</label>
                <input type="text" name="cCity" required class="form-control" value="<?php echo $row['Customer_city']; ?>" />
              </div>
                
              <button type="submit" name="login2" class="btn btn-success">Update</button>
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
