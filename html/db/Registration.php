<?php

namespace db;

use DateTime;
use libs\MemberRegInfo;

class Registration {
    public int $id;
    public int $event_id;
    public DateTime $registration_date;
    public string $badge_name;
    public int $registered_by;
    public int $for_member;
    public int $membership_type;

    public function __construct() {
        $this->id = 0;
        $this->event_id = 0;
        $this->registration_date = new DateTime();
        $this->badge_name = '';
        $this->registered_by = 0;
        $this->for_member = 0;
        $this->membership_type = 0;
    }

    public static function createFromDb(array $row) : Registration {
        $registration = new Registration();
        $registration->id = $row['id'];
        $registration->event_id = $row['event_id'];
        $registration->registration_date = DateTime::createFromFormat('Y-m-d H:i:s', $row['registration_date']);    // read only
        $registration->badge_name = $row['badge_name'];
        $registration->registered_by = $row['registered_by'];
        $registration->for_member = $row['for_member'];
        $registration->membership_type = $row['membership_type'];
        return $registration;
    }

    public static function createFromRegInfo(Member $member, MemberRegInfo $reg_info, MembershipType $membership_type) : Registration {
        $registration = new Registration();
        $registration->badge_name = $reg_info->badge_name;
        $registration->event_id = $membership_type->event_id;
        $registration->membership_type = $membership_type->id;
        $registration->for_member = $member->id;
        $registration->registered_by = $member->id;
        return $registration;
    }
}