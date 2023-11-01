<?php

namespace libs;

use \Exception;
use \DateTime;
use \DateInterval;

class Convention
{
    private int $year;
    private array $info;

    // A simple function that lets us fake the current time for debugging purposes.
    static function now() : DateTime {
        return new DateTime();
//        return new DateTime('11/05/2023 5:00 PM');    // DEBUG ONLY
    }

    static function nowString() : string {
        return Convention::now()->format('m/d/Y g:i A');
    }

    function __construct(int $year = 0)
    {
        global $con_dates;
        if ($year === 0) {
            try {
                $now = Convention::now();
                foreach ($con_dates as $year => $con_info) {
                    $end = new DateTime($con_info['end']);
                    if ($now < $end) {
                        // This is the next or current convention.
                        $this->year = $year;
                        $this->info = $con_info;
                        break;
                    }
                }
            } catch (Exception) {
            }
        } elseif (array_key_exists($year, $con_dates)) {
            $this->year = $year;
            $this->info = $con_dates[$year];
        } else {
            $this->year = 0;
            $this->info = [];
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

}
