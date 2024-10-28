<?php

namespace db;

use mysqli;

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Member.php';

class MembersTable {
    private mysqli $connection;

    public function __construct() {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function getMember(int $id) : Member {
        $stmt = $this->connection->prepare("SELECT * FROM members WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return Member::createFromDbArray($row);
        }
        return new Member();
    }

    public function findMembers(string $email, string $first_name, string $surname) : array {
        $members = array();
        $stmt = $this->connection->prepare("SELECT * FROM members WHERE email = ? AND first_name = ? AND surname = ?");
        $stmt->execute([$email, $first_name, $surname]);
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $members[] = Member::createFromDbArray($row);
        }
        return $members;
    }

    public function findMatchingMembers(Member $member) : array {
        return self::findMembers($member->email, $member->first_name, $member->surname);
    }

    public function addMember(Member $member) : int {
        // TODO INSERT
        return 0;
    }

    public function updateMember(Member $member) : int {
        // TODO ALTER
        return 0;
    }
}