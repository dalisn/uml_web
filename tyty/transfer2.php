<?php
session_start();
include_once 'Account.php';
include("dbConnect.php");
?>

<?php
if (isset($_POST['login2'])) {
    $obAccount2 = new Account($conn); // Pass the database connection to the constructor
    if ($_SESSION['bal'] - $_POST['tMoney'] < 500) {
        ?>
        <script>
        alert('Not Enough Balance to Transfer...');
        window.location='transfer.php'
        </script>
        <?php
    } else {
        $value = $_SESSION['bal'] - $_POST['tMoney'];
        $res1 = $obAccount2->updateBalance($_SESSION['aNum'], $value);

        $obAccount3 = new Account($conn); // Pass the database connection to the constructor
        $rs2 = $obAccount3->showBalance($_POST['payee']);

        if ($rs2->num_rows < 1) {
            ?>
            <p>Invalid Account Number </p><a href="transfer.php">Try again!</a>
            <?php
            die($conn->error); // TODO: better error handling
        }
        $row2 = $rs2->fetch_array();

        $value2 = $row2[2] + $_POST['tMoney'];
        $res2 = $obAccount2->updateBalance($_POST['payee'], $value2);

        if ($res1 && $res2) {
            ?>
            <script>
            alert('Transfer Succeeded...');
            window.location='transfer.php'
            </script>
            <?php
        } else {
            ?>
            <script>
            alert('Error updating balance...');
            window.location='transfer.php'
            </script>
            <?php
        }
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
            <li><a href="user.php">Home</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>
     </nav>

     <div class="panel panel-default">
      <div class="panel-heading">
        <h2>Transfer Money</h2>
      </div>

      <div class="panel-body">
        <div style="max-width: 600px; margin: 0 auto">
            <?php
               $obAccount = new Account($conn); // Pass the database connection to the constructor
               $acNum = $_POST['acNo'];
               $rs = $obAccount->showBalance($acNum);

               if ($rs->num_rows < 1) {
                  ?>
                  <p>Invalid Account Number </p><a href="transfer.php">Try again!</a>
                  <?php
                  die($conn->error); // TODO: better error handling
               }
               $rowa = $rs->fetch_array();
            ?>
            
            <table class="table table-striped">
              <tr>
                  <td width="35%">Account Number: </td>
                  <th><?php echo $rowa[1]; $_SESSION['aNum'] = $rowa[1]; ?></th>
              </tr>
              <tr>
                  <td width="35%">Customer Name: </td>
                  <th><?php echo $rowa[0]; ?></th>
              </tr>
              <tr>
                <td width="35%">Balance: </td>
                <th><?php echo $rowa[2]; $curBal = $rowa[2]; $_SESSION['bal'] = $rowa[2]; ?></th>
              </tr>
            </table>

            <form action="" method="post">
              <div class="form-group">
                <label for="payee">Enter Account Number of Payee</label>
                <input type="text" name="payee" required class="form-control" />
              </div>

              <div class="form-group">
                <label for="tMoney">Enter Transfer Amount</label>
                <input type="text" name="tMoney" required class="form-control" />
              </div>
                
              <button type="submit" name="login2" class="btn btn-success">Send</button>
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
