<?php

namespace libs;

use config\DBConfig;
use Exception;
use DateTime;
use DateInterval;
use mysqli;

require __DIR__ . '/../config/DBConfig.php';
require __DIR__ . '/MembershipType.php';

class Convention
{
    private int $year;
    private array $info;
    private array $membership_types;

    // A simple function that lets us fake the current time for debugging purposes.
    static function now() : DateTime {
        return new DateTime();
//        return new DateTime('11/01/2024 8:00 PM');    // DEBUG ONLY
    }

    static function nowString() : string {
        return Convention::now()->format('m/d/Y g:i A');
    }

    function __construct(int $year = 0)
    {
        $now = Convention::now();
        $this->membership_types = array();
        $db = new mysqli(DBConfig::$host, DBConfig::$user, DBConfig::$pass, DBConfig::$dbname);
        try {
            if ($year === 0) {
                $query = "SELECT * FROM events WHERE name LIKE 'ArmadaCon %'";
                $result = $db->query($query);
                while ($row = $result->fetch_assoc()) {
                    $start = DateTime::createFromFormat('Y-m-d H:i:s', $row['start']);
                    $end = DateTime::createFromFormat('Y-m-d H:i:s', $row['end']);
                    if ($now < $end) {
                        // This is the next or current convention.
                        $this->year = $start->format('Y');
                        self::fillInfo($start, $end);
                        $this->info['id'] = $row['id'];
                        break;
                    }
                }
            } else {
                $query = "SELECT * FROM events WHERE name LIKE 'ArmadaCon $year'";
                $result = $db->query($query);
                if ($row = $result->fetch_assoc()) {
                    $start = new DateTime($row['start']);
                    $end = new DateTime($row['end']);
                    $this->year = $year;
                    self::fillInfo($start, $end);
                    $this->info['id'] = $row['id'];
                } else {
                    $this->year = 0;
                    $this->info = [];
                }
            }
        } catch (Exception) {
        }

        if ($this->info['id'] !== 0) {
            self::loadMembershipTypes($db, $this->info['id']);
        }
        $db->close();
    }

    private function fillInfo(DateTime $start, DateTime $end) : void{
        $this->info = array();
        $this->info['start'] = $start->format('m/d/Y g:i A');
        $this->info['end'] = $end->format('m/d/Y g:i A');
        $this->info['prereg_cutoff_days'] = 14;
        $this->info['banner-short'] = $start->format('D j\<\s\u\p\>S') . '</sup> - ' . $end->format('D j\<\s\u\p\>S\<\/\s\u\p\> F');
        $this->info['banner-long'] = $start->format('l j\<\s\u\p\>S') . '</sup> - ' . $end->format('l j\<\s\u\p\>S\<\/\s\u\p\> F');
    }

    private function loadMembershipTypes(mysqli $db, int $event_id) : void {
        $query = "SELECT * FROM membership_types WHERE event_id = $event_id";
        $result = $db->query($query);
        while ($row = $result->fetch_assoc()) {
            $this>$this->membership_types[] = new MembershipType($row);
        }
    }

    public function isRunning(): bool
    {
        if ($this->year != 0) {
            try {
                $now = Convention::now();
                $start = new DateTime($this->info['start']);
                $end = new DateTime($this->info['end']);
                return ($now > $start) && ($now < $end);
            } catch (Exception) {
            }
        }
        return false;
    }

    public function isPreregAvailable(): bool
    {
        if ($this->year != 0) {
            try {
                $now = Convention::now();
                $prereg = new DateTime($this->info['start']);
                $prereg->sub(new DateInterval("P{$this->info['prereg_cutoff_days']}D"));
                return $now < $prereg;
            } catch (Exception) {
            }
        }
        return false;
    }

    public function id(): int {
        return $this->info['id'];
    }

    public function year(): int
    {
        return $this->year;
    }

    public function startString(): string
    {
        return $this->year != 0 ? $this->info['start'] : '';
    }

    public function endString(): string
    {
        return $this->year != 0 ? $this->info['end'] : '';
    }

    public function shortBanner(): string
    {
        return $this->year != 0 ? $this->info['banner-short'] : '';
    }

    public function longBanner(): string
    {
        return $this->year != 0 ? $this->info['banner-long'] : '';
    }

    public function membershipTypes(): array {
        return $this->membership_types;
    }

    public function getMembershipType(int $type_id) : MembershipType {
        foreach ($this->membership_types as $membership_type) {
            if ($membership_type->id == $type_id) {
                return $membership_type;
            }
        }
        // It's unlikely we'd have an error here, but just in case, return
        // the first membership type.
        return $this->membership_types[0];
    }
}
