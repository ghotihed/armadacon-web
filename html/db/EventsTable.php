<?php

namespace db;

use mysqli;

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/Event.php';

class EventsTable {
    private mysqli $connection;

    public function __construct() {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function getConventionEvents() : array {
        $events = array();
        $stmt = $this->connection->prepare("SELECT * FROM events WHERE name LIKE 'ArmadaCon %'");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $events[] = new Event($row);
        }
        usort($events, function($a, $b) {
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
        return $events;
    }

    public function getConventionEvent(int $year) : ?Event {
        $stmt = $this->connection->prepare("SELECT * FROM events WHERE name LIKE ?");
        $stmt->execute(["ArmadaCon $year"]);
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return new Event($row);
        }
        return null;
    }
}