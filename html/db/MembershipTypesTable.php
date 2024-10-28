<?php

namespace db;

use mysqli;

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/MembershipType.php';

class MembershipTypesTable {
    private mysqli $connection;

    public function __construct() {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function getMembershipTypes(int $event_id) : array {
        $membership_types = array();
        $stmt = $this->connection->prepare("SELECT * FROM membership_types WHERE event_id = ?");
        $stmt->execute([$event_id]);
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
}