<?php

namespace db;

use mysqli;
use mysqli_sql_exception;

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/Registration.php';

class RegistrationsTable
{
    private mysqli $connection;

    public function __construct() {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function addRegistration(Registration $registration) : int {
        $stmt = $this->connection->prepare("INSERT INTO registrations (event_id, badge_name, registered_by, for_member, membership_type) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isiii", $registration->event_id, $registration->badge_name, $registration->registered_by, $registration->for_member, $registration->membership_type);
        if ($stmt->execute()) {
            return $this->connection->insert_id;
        }
        return 0;
    }

    public function getRegistration(int $reg_id) : ?Registration {
        $stmt = $this->connection->prepare("SELECT * FROM registrations WHERE id = ?");
        $stmt->bind_param("i", $reg_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return Registration::createFromDb($row);
        }
        return null;
    }

    public function getRegistrationsForEvent(int $event_id) : array {
        $registrations = [];
        $stmt = $this->connection->prepare("SELECT * FROM registrations WHERE event_id = ?");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $registrations[] = Registration::createFromDb($row);
        }
        return $registrations;
    }

    public function getRegistrationsForMember(int $member_id) : array {
        $registrations = [];
        $stmt = $this->connection->prepare("SELECT * FROM registrations WHERE for_member = ?");
        $stmt->bind_param("i", $member_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $registrations[] = Registration::createFromDb($row);
        }
        return $registrations;
    }

    public function getRegistrationsByMember(int $member_id) : array {
        $registrations = [];
        try {
            $stmt = $this->connection->prepare("SELECT * FROM registrations WHERE registered_by = ?");
            $stmt->bind_param("i", $member_id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $registrations[] = Registration::createFromDb($row);
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return $registrations;
    }
}