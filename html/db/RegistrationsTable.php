<?php

namespace db;

use mysqli;

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Registration.php';

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
}