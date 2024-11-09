<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/bootstrap.php';

use db\MembersTable;

if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    if ($_POST['submit'] === 'member_csv') {
        $membersTable = new MembersTable();
        $members = $membersTable->getAllMembers();
        usort($members, function ($a, $b) {
            return strcmp($a->displayName(), $b->displayName());
        });
        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=member_list.csv");
        echo "first_name,last_name,email" . PHP_EOL;
        $member_list = array();
        foreach ($members as $member) {
            $displayName = $member->displayName();
            if (array_key_exists($displayName, $member_list)) {
                $member_list[$displayName][] = $member->id;
            } else {
                $member_list[$displayName] = [$member->id];
                echo "$member->first_name,$member->surname,$member->email" . PHP_EOL;
            }
        }
    }
}
