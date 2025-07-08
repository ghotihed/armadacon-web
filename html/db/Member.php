<?php

namespace db;

use DateTime;
use libs\MemberRegInfo;

class Member {
    public int $id;
    public string $email;
    public string $password;
    public string $first_name;
    public string $surname;
    public string $address1;
    public string $address2;
    public string $city;
    public string $post_code;
    public string $country;
    public string $phone;
    public string $notes;
    public bool $past_guest;
    public bool $agree_to_policy;
    public bool $agree_to_email_updates;
    public bool $agree_to_public_listing;
    public DateTime $created_on;
    public DateTime $modified_on;
    public bool $is_admin;
    public string $permissions;
    public string $login_code;
    public string $login_code_expiry;

    public function __construct() {
        $this->id = 0;
        $this->email = '';
        $this->password = '';
        $this->first_name = '';
        $this->surname = '';
        $this->address1 = '';
        $this->address2 = '';
        $this->city = '';
        $this->post_code = '';
        $this->country = '';
        $this->phone = '';
        $this->notes = '';
        $this->past_guest = false;
        $this->agree_to_policy = false;
        $this->agree_to_email_updates = false;
        $this->agree_to_public_listing = false;
        $this->created_on = new DateTime();
        $this->modified_on = new DateTime();
        $this->is_admin = false;
        $this->permissions = '';
        $this->login_code = '';
        $this->login_code_expiry = '';
    }

    public static function createFromDbArray(array $row) : Member {
        $member = new Member();
        $member->id = $row['id'];
        $member->email = $row['email'];
        $member->password = $row['password'] ?? '';
        $member->first_name = $row['first_name'] ?? '';
        $member->surname = $row['surname'] ?? '';
        $member->address1 = $row['address1'] ?? '';
        $member->address2 = $row['address2'] ?? '';
        $member->city = $row['city'] ?? '';
        $member->post_code = $row['post_code'] ?? '';
        $member->country = $row['country'] ?? '';
        $member->phone = $row['phone'] ?? '';
        $member->notes = $row['notes'] ?? '';
        $member->past_guest = $row['past_guest'] ?? false;
        $member->agree_to_policy = $row['agree_to_policy'] ?? false;
        $member->agree_to_email_updates = $row['agree_to_email_updates'] ?? false;
        $member->agree_to_public_listing = $row['agree_to_public_listing'] ?? false;
        $member->created_on = DateTime::createFromFormat('Y-m-d H:i:s', $row['created_on'] ?? "1970-01-01 00:00:00");
        $member->modified_on = DateTime::createFromFormat('Y-m-d H:i:s', $row['modified_on'] ?? "1970-01-01 00:00:00");
        $member->is_admin = $row['is_admin'] ?? false;
        $member->permissions = $row['permissions'] ?? '';
        $member->login_code = $row['login_code'] ?? '';
        $member->login_code_expiry = $row['login_code_expiry'] ?? '';
        return $member;
    }

    public static function createFromMemberRegInfo(MemberRegInfo $reg_info) : Member {
        $member = new Member();
        $member->email = $reg_info->email;
        $member->first_name = $reg_info->first_name;
        $member->surname = $reg_info->surname;
        $member->address1 = $reg_info->address1;
        $member->address2 = $reg_info->address2;
        $member->city = $reg_info->city;
        $member->post_code = $reg_info->post_code;
        $member->country = $reg_info->country;
        $member->phone = $reg_info->phone;
        $member->agree_to_policy = $reg_info->agree_to_policy;
        $member->agree_to_email_updates = $reg_info->agree_to_email_updates;
        $member->agree_to_public_listing = $reg_info->agree_to_public_listing;
        return $member;
    }

    public function displayName(bool $include_email = true) : string {
        $name = $this->first_name . ' ' . $this->surname;
        if ($include_email) {
            $name .= ' &lt;' . $this->email . '&gt;';
        }
        return $name;
    }
}