<?php

namespace libs;

use DateTime;

class MembershipType {
    public int $id;
    public int $event_id;
    public string $name;
    public DateTime $start;
    public DateTime $end;
    public float $price_full;
    public float $price_concession;

    function __construct(array $info) {
        $this->id = $info['id'];
        $this->event_id = $info['event_id'];
        $this->name = $info['name'];
        $this->start = DateTime::createFromFormat('Y-m-d H:i:s', $info['start']);
        $this->end = DateTime::createFromFormat('Y-m-d H:i:s', $info['end']);
        $this->price_full = $info['price_full'];
        $this->price_concession = $info['price_concession'];
    }
}
