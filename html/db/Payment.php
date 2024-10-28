<?php

namespace db;

use DateTime;

class Payment {
    public int $id;
    public int $payer;
    public int $registration_id;
    public DateTime $payment_date;
    public float $amount;
    public string $payment_type;

    public function __construct() {
        $this->id = 0;
        $this->payer = 0;
        $this->registration_id = 0;
        $this->payment_date = new DateTime();
        $this->amount = 0.0;
        $this->payment_type = '';
    }

    public static function createFromDb(array $row) : Payment {
        $payment = new Payment();
        $payment->id = $row['id'];
        $payment->payer = $row['payer'];
        $payment->registration_id = $row['registration_id'];
        $payment->payment_date = DateTime::createFromFormat('Y-m-d H:i:s', $row['payment_date']);    // read only
        $payment->amount = $row['amount'];
        $payment->payment_type = $row['payment_type'];
        return $payment;
    }

    public static function createFromData(Member $member, Registration $registration, float $amount, string $payment_type) : Payment {
        $payment = new Payment();
        $payment->payer = $member->id;
        $payment->registration_id = $registration->id;
        $payment->amount = $amount;
        $payment->payment_type = $payment_type;
        return $payment;
    }
}