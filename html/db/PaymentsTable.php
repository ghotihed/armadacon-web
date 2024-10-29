<?php

namespace db;

use mysqli;

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/Payment.php';

class PaymentsTable {
    private mysqli $connection;

    public function __construct() {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function addPayment(Payment $payment) : int {
        $stmt = $this->connection->prepare("INSERT INTO payments (payer, registration_id, amount, payment_type) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iids", $payment->payer, $payment->registration_id, $payment->amount, $payment->payment_type);
        if ($stmt->execute()) {
            return $this->connection->insert_id;
        }
        return 0;
    }
}