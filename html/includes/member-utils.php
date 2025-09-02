<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/bootstrap.php';

use db\EventsTable;
use db\MembershipTypesTable;
use db\MembersTable;
use db\PaymentsTable;
use db\RegistrationsTable;

/**
 * Decodes the UID generated when a member registers. The resulting array will contain
 * the following data.
 *
 *  - Member ID
 *  - Event ID
 *  - Registration ID
 *  - Price
 * @param string $uid The UID generated when a member registers.
 * @return array A breakdown of the individual IDs in the UID.
 */
function decode_uid(string $uid) : array {
    // $uid = "M$member->id-E$registration->event_id-R$registration->id-P$membership_type->price";
    $result = array();
    $ids = explode('-', $uid);
    foreach ($ids as $id) {
        $id = substr($id, 1);
        $result[] = $id;
    }
    return $result;
}

function get_reg_info(string $uid) : array {
    $membership_type = null;
    $payments = [];

    [$member_id, $event_id, $reg_id, ] = decode_uid($uid);

    $membersTable = new MembersTable();
    $member = $membersTable->getMember($member_id);

    $eventsTable = new EventsTable();
    $event = $eventsTable->getEvent($event_id);

    $registrationsTable = new RegistrationsTable();
    $registration = $registrationsTable->getRegistration($reg_id);

    if ($registration) {
        $membershipTypesTable =  new MembershipTypesTable();
        $membership_type = $membershipTypesTable->getMembershipType($registration->membership_type);

        $paymentsTable = new PaymentsTable();
        $payments = $paymentsTable->getPayments($registration->id);
    }

    return [$member, $event, $registration, $membership_type, $payments];
}