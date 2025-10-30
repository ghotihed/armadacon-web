<?php

namespace db;

use mysqli;
use mysqli_sql_exception;

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/MembershipType.php';

class MembershipTypesTable {
    private mysqli $connection;

    public function __construct() {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function getMembershipTypes(int $event_id) : array {
        $membership_types = array();
        $stmt = $this->connection->prepare("SELECT * FROM membership_types WHERE event_id = ?");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $membership_types[] = new MembershipType($row);
        }
        usort($membership_types, function($a, $b) {
            if ($a->start < $b->start) {
                return -1;
            } elseif ($a->start > $b->start) {
                return 1;
            } elseif ($a->end < $b->end) {
                return -1;
            } elseif ($a->end > $b->end) {
                return 1;
            } else {
                return strcmp($a->name, $b->name);
            }
        });

        return $membership_types;
    }

    public function getMembershipType(int $membership_type_id) : ?MembershipType {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM membership_types WHERE id = ?");
            $stmt->bind_param("i", $membership_type_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return new MembershipType($row);
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return null;
    }
}