<?php
include_once 'Loan.php';
include_once 'dbConnect.php';

class Account extends Loan
{
    private $accNumber;
    private $balance;
    private $branchName;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function openAccount($brName) {
        $this->balance = 500;

        $res = $this->conn->query("INSERT INTO ac SET name = 'Asif'");
        $sql = $this->conn->query("SELECT * FROM ac ORDER BY id DESC LIMIT 1");
        $row = $sql->fetch_assoc();
        $x = $row['id'];

        $sql2 = $this->conn->query("SELECT CONCAT('AC-', id) AS id FROM ac WHERE id = '$x'");
        $row2 = $sql2->fetch_assoc();

        $this->accNumber = $row2['id'];
        $this->branchName = $brName;

        $res = $this->conn->query("INSERT INTO account(Account_number, Branch_name, Balance) VALUES('$this->accNumber', '$this->branchName', '$this->balance')");

        return $res;
    }

    public function getAcNumber() {
        return $this->accNumber;
    }

    public function updateBalance($aNumber, $value) {
        $this->accNumber = $aNumber;
        $this->balance = $value;

        $res = $this->conn->query("UPDATE account SET Balance='$this->balance' WHERE Account_number='$this->accNumber'");

        return $res;
    }

    public function showBalance($acNo) {
        $this->accNumber = $acNo;

        $res = $this->conn->query("SELECT d.Customer_name, d.Account_number, a.Balance FROM depositor d, account a WHERE d.Account_number = '$this->accNumber' AND a.Account_number = '$this->accNumber'");

        return $res;
    }

    public function showAccountInfo($acNo) {
        $this->accNumber = $acNo;

        $res = $this->conn->query("SELECT d.Customer_name, d.Account_number, a.Balance, b.Branch_name, b.Branch_city, c.Customer_street, c.Customer_city FROM depositor d, account a, branch b, customer c WHERE d.Account_number = '$this->accNumber' AND a.Account_number = '$this->accNumber' AND a.Branch_name=b.Branch_name AND d.Customer_name=c.Customer_name");

        return $res;
    }

    public function showAllAccountInfo() {
        $res = $this->conn->query("SELECT d.Customer_name, d.Account_number, c.Customer_street, c.Customer_city, a.Balance, b.Branch_name, b.Branch_city FROM depositor d, account a, branch b, customer c WHERE d.Account_number = a.Account_number AND d.Customer_name = c.Customer_name AND a.Branch_name=b.Branch_name ORDER BY d.Account_number");

        return $res;      
    }

    public function closeAccount($acNo) {
        $this->accNumber = $acNo;

        $res = $this->conn->query("DELETE FROM account WHERE Account_number = '$this->accNumber'");

        return $res;
    }
}
?>
