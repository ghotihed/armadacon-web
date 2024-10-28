<?php

namespace db;

use DateTime;

class Event {
    public int $id;
    public string $name;
    public string $location;
    public DateTime $start;
    public DateTime $end;

    function __construct(array $row) {
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->location = $row['location'];
        $this->start = DateTime::createFromFormat('Y-m-d H:i:s', $row['start']);
        $this->end = DateTime::createFromFormat('Y-m-d H:i:s', $row['end']);
    }
}