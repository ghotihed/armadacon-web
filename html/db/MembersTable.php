<?php

namespace db;

use mysqli;

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/Member.php';

class MembersTable {
    private mysqli $connection;

    public function __construct() {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function getMember(int $id) : Member {
        $stmt = $this->connection->prepare("SELECT * FROM members WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return Member::createFromDbArray($row);
        }
        return new Member();
    }

    public function getAllMembers() : array {
        $members = array();
        $stmt = $this->connection->prepare("SELECT * FROM members");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $members[] = Member::createFromDbArray($row);
        }
        return $members;
    }

    public function findMembers(string $email, string $first_name, string $surname) : array {
        $members = array();
        $stmt = $this->connection->prepare("SELECT * FROM members WHERE email = ? AND first_name = ? AND surname = ?");
        $stmt->bind_param("sss", $email, $first_name, $surname);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $members[] = Member::createFromDbArray($row);
        }
        return $members;
    }

    public function findMemberByEmail(string $email) : array {
        $members = array();
        $stmt = $this->connection->prepare("SELECT * FROM members WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
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
        $stmt = $this->connection->prepare("INSERT INTO members (email, first_name, surname, address1, address2, city, post_code, phone, agree_to_policy, agree_to_email_updates, agree_to_public_listing) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssiii", $member->email, $member->first_name, $member->surname, $member->address1, $member->address2, $member->city, $member->post_code, $member->phone, $member->agree_to_policy, $member->agree_to_email_updates, $member->agree_to_public_listing);
        if ($stmt->execute()) {
            return $this->connection->insert_id;
        }
        return 0;
    }

    public function updateMember(Member $member) : int {
        // TODO ALTER
        return 0;
    }
}