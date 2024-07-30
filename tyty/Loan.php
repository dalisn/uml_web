<?php
include("Customer.php");

class Loan extends Customer {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllLoans() {
        $query = "SELECT l.Loan_number, l.Branch_name, l.Amount, b.Customer_name
                  FROM loan l
                  JOIN borrower b ON l.Loan_number = b.Loan_number
                  ORDER BY l.Loan_number";
        return $this->conn->query($query);
    }
}
?>
