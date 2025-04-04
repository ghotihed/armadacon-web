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
        $convention_search = "ArmadaCon $year";
        $stmt = $this->connection->prepare("SELECT * FROM events WHERE name LIKE ?");
        $stmt->bind_param('s', $convention_search);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return new Event($row);
        }
        return null;
    }

    public function getEvent(int $event_id) : ?Event {
        $stmt = $this->connection->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return new Event($row);
        }
        return null;
    }
}