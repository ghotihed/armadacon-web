<?php

namespace db;

use mysqli;
use mysqli_sql_exception;

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/Payment.php';

class PaymentsTable {
    private mysqli $connection;

    public function __construct() {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function addPayment(Payment $payment) : int {
        try {
            $stmt = $this->connection->prepare("INSERT INTO payments (payer, registration_id, amount, payment_type) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iids", $payment->payer, $payment->registration_id, $payment->amount, $payment->payment_type);
            if ($stmt->execute()) {
                return $this->connection->insert_id;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return 0;
    }

    public function getPayments(int $reg_id) : array {
        $payments = [];
        $stmt = $this->connection->prepare("SELECT * FROM payments WHERE registration_id = ?");
        $stmt->bind_param("i", $reg_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $payments[] = Payment::createFromDb($row);
        }
        return $payments;
    }
}