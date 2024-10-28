<?php

namespace libs;

const FIELD_NAME_EMAIL = "email";
const FIELD_NAME_FIRST_NAME = "first-name";
const FIELD_NAME_SURNAME = "last-name";
const FIELD_NAME_BADGE_NAME = "badge-name";
const FIELD_NAME_ADDRESS1 = "address-first-line";
const FIELD_NAME_ADDRESS2 = "address-second-line";
const FIELD_NAME_ADDRESS_CITY = "address-city";
const FIELD_NAME_ADDRESS_POSTCODE = "address-post-code";
const FIELD_NAME_COUNTRY = "address-country";
const FIELD_NAME_PHONE = "phone";
const FIELD_NAME_MEMBERSHIP_TYPE = "membership-type";
const FIELD_NAME_AGREE_TO_POLICY = "agree-to-policy";
const FIELD_NAME_AGREE_TO_EMAIL = "agree-to-email";
const FIELD_NAME_AGREE_TO_LISTING = "agree-to-listing";

class MemberRegInfo {
    public string $email;
    public string $first_name;
    public string $surname;
    public string $badge_name;
    public string $address1;
    public string $address2;
    public string $city;
    public string $post_code;
    public string $country;
    public string $phone;
    public int $membership_type_id;
    public bool $agree_to_policy;
    public bool $agree_to_email_updates;
    public bool $agree_to_public_listing;

    public function __construct() {
        $this->email = '';
        $this->first_name = '';
        $this->surname = '';
        $this->badge_name = '';
        $this->address1 = '';
        $this->address2 = '';
        $this->city = '';
        $this->post_code = '';
        $this->country = '';
        $this->phone = '';
        $this->membership_type_id = 0;
        $this->agree_to_policy = false;
        $this->agree_to_email_updates = false;
        $this->agree_to_public_listing = false;
    }

    /**
     * Create a new `MemberRegInfo` object with certain fields prefilled based on
     * the contents of an array.
     *
     * Note that this does not fill all fields from the array, just those that
     * could be useful to a new member, such as address and phone number, etc.
     *
     * @param array $array The values from a previous `$_POST` array or `$_SESSION` member array.
     * @return MemberRegInfo
     */
    public static function prefillFromArray(array $array) : MemberRegInfo {
        $info = new MemberRegInfo();
        $info->address1 = $array[FIELD_NAME_ADDRESS1] ?? '';
        $info->address2 = $array[FIELD_NAME_ADDRESS2] ?? '';
        $info->city = $array[FIELD_NAME_ADDRESS_CITY] ?? '';
        $info->post_code = $array[FIELD_NAME_ADDRESS_POSTCODE] ?? '';
        $info->country = $array[FIELD_NAME_COUNTRY] ?? '';
        $info->phone = $array[FIELD_NAME_PHONE] ?? '';
        return $info;
    }

    /**
     * Create a new `MemberRegInfo` object from fields in an array.
     *
     * @param array $array The values from a previous `$_POST` array or `$_SESSION` member array.
     * @return MemberRegInfo
     */
    public static function createFromArray(array $array) : MemberRegInfo {
        $info = new MemberRegInfo();
        $info->email = $array[FIELD_NAME_EMAIL] ?? '';
        $info->first_name = $array[FIELD_NAME_FIRST_NAME] ?? '';
        $info->surname = $array[FIELD_NAME_SURNAME] ?? '';
        $info->badge_name = $array[FIELD_NAME_BADGE_NAME] ?? '';
        $info->address1 = $array[FIELD_NAME_ADDRESS1] ?? '';
        $info->address2 = $array[FIELD_NAME_ADDRESS2] ?? '';
        $info->city = $array[FIELD_NAME_ADDRESS_CITY] ?? '';
        $info->post_code = $array[FIELD_NAME_ADDRESS_POSTCODE] ?? '';
        $info->country = $array[FIELD_NAME_COUNTRY] ?? '';
        $info->phone = $array[FIELD_NAME_PHONE] ?? '';
        $info->membership_type_id = $array[FIELD_NAME_MEMBERSHIP_TYPE] ?? 0;
        $info->agree_to_policy = self::toBool($array, FIELD_NAME_AGREE_TO_POLICY);
        $info->agree_to_email_updates = self::toBool($array, FIELD_NAME_AGREE_TO_EMAIL);
        $info->agree_to_public_listing = self::toBool($array, FIELD_NAME_AGREE_TO_LISTING);
        return $info;
    }
    
    public function saveToArray() : array {
        return array(
            FIELD_NAME_EMAIL => $this->email,
            FIELD_NAME_FIRST_NAME => $this->first_name,
            FIELD_NAME_SURNAME => $this->surname,
            FIELD_NAME_BADGE_NAME => $this->badge_name,
            FIELD_NAME_ADDRESS1 => $this->address1,
            FIELD_NAME_ADDRESS2 => $this->address2,
            FIELD_NAME_ADDRESS_CITY => $this->city,
            FIELD_NAME_ADDRESS_POSTCODE => $this->post_code,
            FIELD_NAME_COUNTRY => $this->country,
            FIELD_NAME_PHONE => $this->phone,
            FIELD_NAME_MEMBERSHIP_TYPE => $this->membership_type_id,
            FIELD_NAME_AGREE_TO_POLICY => $this->agree_to_policy ? "true" : "false",
            FIELD_NAME_AGREE_TO_EMAIL => $this->agree_to_email_updates ? "true" : "false",
            FIELD_NAME_AGREE_TO_LISTING => $this->agree_to_public_listing ? "true" : "false"
        );
    }

    private static function toBool(array $arr, string $key) : bool {
        if (isset($arr[$key])) {
            return $arr[$key] === "true";
        } else {
            return false;
        }
    }

    private function createTextInput(string $field_name, string $field_type, string $field_label, string $field_value, string $field_placeholder, bool $is_required) : void {
        echo '<div><label for="' . $field_name . '">' . $field_label;
        if ($is_required) {
            echo '<span class="req">*</span>';
        }
        echo '</label>';
        echo '<input type="' . $field_type . '" name="' . $field_name . '" id="' . $field_name . '" value="' . $field_value . '" placeholder="' . $field_placeholder . '"';
        if ($is_required) {
            echo ' required';
        }
        echo "></div>" . PHP_EOL;
    }

    private function createCheckboxInput(string $field_name, bool $field_value, string $field_label, bool $is_required) : void {
        echo '<div><label for="' . $field_name . '">';
        echo '<input type ="checkbox" name="' . $field_name . '" id="' . $field_name . '" value="true"' . ($is_required ? ' required' : '') . ($field_value ? ' checked' : '') . '/> ' . $field_label;
        if ($is_required) {
            echo '<span class="req">*</span>';
        }
        echo '</label></div>' . PHP_EOL;
    }

    public function generateInputs(Convention $convention) : void {
        $this->createTextInput(FIELD_NAME_EMAIL, "email", "Email", $this->email, "Your email address", true);
        $this->createTextInput(FIELD_NAME_FIRST_NAME, "text", "First Name", $this->first_name, "Your given name", true);
        $this->createTextInput(FIELD_NAME_SURNAME, "text", "Surname", $this->surname, "Your surname", true);
        $this->createTextInput(FIELD_NAME_BADGE_NAME, "text", "Badge Name (if different)", $this->badge_name, "Badge name", false);
        $this->createTextInput(FIELD_NAME_ADDRESS1, "text", "First Line of Address", $this->address1, "First line of address", false);
        $this->createTextInput(FIELD_NAME_ADDRESS2, "text", "Second Line of Address", $this->address2, "", false);
        $this->createTextInput(FIELD_NAME_ADDRESS_CITY, "text", "City", $this->city, "City", false);
        $this->createTextInput(FIELD_NAME_ADDRESS_POSTCODE, "text", "Post Code", $this->post_code, "Post code", false);
        $this->createTextInput(FIELD_NAME_PHONE, "text", "Phone Number", $this->phone, "Your phone number", false);
        $membership_types = $convention->membershipTypes();
        if ($membership_types) {
            echo '<div><label for="' . FIELD_NAME_MEMBERSHIP_TYPE . '">Membership Type<span class="req">*</span></label>';
            echo '<select name="' . FIELD_NAME_MEMBERSHIP_TYPE . '" id="' . FIELD_NAME_MEMBERSHIP_TYPE . '" required>';
            echo '<option style="display: none;"/>';
            foreach ($membership_types as $membership_type) {
                $now = $convention->now();
                if ($membership_type->start <= $now && $membership_type->end >= $now) {
                    echo '<option value="' . $membership_type->id . '"' . ($membership_type->id == $this->membership_type_id ? ' selected' : '') . '>' . $membership_type->name . ' £' . $membership_type->price . '</option>';
                }
            }
            echo '</select></div>' . PHP_EOL;
        }
        $this->createCheckboxInput(FIELD_NAME_AGREE_TO_POLICY, $this->agree_to_policy, 'I have read and agree to abide by <a href="/policies.php" target="_new">the convention code of conduct and policies</a>.', true);
        $this->createCheckboxInput(FIELD_NAME_AGREE_TO_EMAIL, $this->agree_to_email_updates, 'I understand my details will be kept in a computerised database. My information will not be shared with outside organisations.', true);
        $this->createCheckboxInput(FIELD_NAME_AGREE_TO_LISTING, $this->agree_to_public_listing, 'I am fine with having my name (or badge name) listed publicly on the website.', false);
    }

    public function sanitize() : void {
        $this->email = filter_var(trim($this->email), FILTER_SANITIZE_EMAIL);
        $this->first_name = htmlspecialchars(trim($this->first_name));
        $this->surname = htmlspecialchars(trim($this->surname));
        $this->badge_name = htmlspecialchars(trim($this->badge_name));
        $this->address1 = htmlspecialchars(trim($this->address1));
        $this->address2 = htmlspecialchars(trim($this->address2));
        $this->city = htmlspecialchars(trim($this->city));
        $this->post_code = htmlspecialchars(trim($this->post_code));
        $this->phone = preg_replace('/[^0-9+\-() ]/', '', trim($this->phone));
    }

    public function validate() : array {
        $errors = array();
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = ['email', 'Please enter a valid email address'];
        }
        return $errors;
    }

    public function displayName() : string {
        if ($this->badge_name !== '') {
            return $this->badge_name;
        } else {
            return $this->first_name . ' ' . $this->surname;
        }
    }
}