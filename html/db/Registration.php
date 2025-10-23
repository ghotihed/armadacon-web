<?php

namespace db;

use DateTime;
use libs\MemberRegInfo;

class Registration {
    const string FIELD_NAME_ID = "id";
    const string FIELD_NAME_EVENT_ID = 'event_id';
    const string FIELD_NAME_REGISTRATION_DATE = 'registration_date';
    const string FIELD_NAME_BADGE_NAME  = 'badge_name';
    const string FIELD_NAME_REGISTERED_BY = 'registered_by';
    const string FIELD_NAME_FOR_MEMBER = 'for_member';
    const string FIELD_NAME_MEMBERSHIP_TYPE = 'membership_type';

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

    public static function createFromArray(array $array) : Registration {
        $registration = new Registration();
        $registration->id = $array[Registration::FIELD_NAME_ID];
        $registration->event_id = $array[Registration::FIELD_NAME_EVENT_ID];
        $registration->registration_date = DateTime::createFromFormat('Y-m-d H:i:s', $array[Registration::FIELD_NAME_REGISTRATION_DATE] ?? "1970-01-01 00:00:00");
        $registration->badge_name = $array[Registration::FIELD_NAME_BADGE_NAME];
        $registration->registered_by = $array[Registration::FIELD_NAME_FOR_MEMBER];
        $registration->for_member = $array[Registration::FIELD_NAME_FOR_MEMBER];
        $registration->membership_type = $array[Registration::FIELD_NAME_MEMBERSHIP_TYPE];
        return $registration;
    }

    public static function create(Member $member, string $badge_name, MembershipType $membership_type) : Registration {
        $registration = new Registration();
        $registration->badge_name = $badge_name;
        $registration->event_id = $membership_type->event_id;
        $registration->membership_type = $membership_type->id;
        $registration->for_member = $member->id;
        $registration->registered_by = $member->id;
        return $registration;
    }

    public function saveToArray() : array {
        return array(
            Registration::FIELD_NAME_EVENT_ID => $this->event_id,
            Registration::FIELD_NAME_REGISTRATION_DATE => $this->registration_date->format('Y-m-d H:i:s'),
            Registration::FIELD_NAME_BADGE_NAME => $this->badge_name,
            Registration::FIELD_NAME_REGISTERED_BY => $this->registered_by,
            Registration::FIELD_NAME_FOR_MEMBER => $this->for_member,
            Registration::FIELD_NAME_MEMBERSHIP_TYPE => $this->membership_type,
        );
    }
}