<?php

namespace libs;

use DateInterval;
use DateTime;
use db\EventsTable;
use db\MembershipType;
use db\MembershipTypesTable;
use Exception;

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/bootstrap.php';

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
        try {
            $eventsTable = new EventsTable();
            if ($year === 0) {
                $events = $eventsTable->getConventionEvents();
                foreach ($events as $event) {
                    if ($now < $event->end) {
                        // This is the next or current convention.
                        $this->year = $event->start->format('Y');
                        self::fillInfo($event->start, $event->end);
                        $this->info['id'] = $event->id;
                        break;
                    }
                }
            } else {
                $event = $eventsTable->getConventionEvent($year);
                if ($event) {
                    $this->year = $year;
                    self::fillInfo($event->start, $event->end);
                    $this->info['id'] = $event->id;
                } else {
                    $this->year = 0;
                    $this->info = [];
                }
            }
        } catch (Exception) {
        }

        if ($this->info['id'] !== 0) {
            $membershipTypesTable = new MembershipTypesTable();
            $this->membership_types= $membershipTypesTable->getMembershipTypes($this->info['id']);
        }
    }

    private function fillInfo(DateTime $start, DateTime $end) : void{
        $this->info = array();
        $this->info['start'] = $start->format('m/d/Y g:i A');
        $this->info['end'] = $end->format('m/d/Y g:i A');
        $this->info['prereg_cutoff_days'] = 14;
        $this->info['banner-short'] = $start->format('D j\<\s\u\p\>S') . '</sup> - ' . $end->format('D j\<\s\u\p\>S\<\/\s\u\p\> F');
        $this->info['banner-long'] = $start->format('l j\<\s\u\p\>S') . '</sup> - ' . $end->format('l j\<\s\u\p\>S\<\/\s\u\p\> F');
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
