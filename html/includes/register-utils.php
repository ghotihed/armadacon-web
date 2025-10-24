<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/debug.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . "/libs/MemberRegInfo.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/db/bootstrap.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/libs/Convention.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/config/MailConfig.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/libs/Mailer.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/libs/MailRegConfirmation.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/includes/stripe-processing.php";

    use config\MailConfigRegistration;
    use db\MembershipType;
    use db\MembersTable;
    use db\Member;
    use db\Registration;
    use db\RegistrationsTable;
    use libs\Convention;
    use libs\Mailer;
    use libs\MailRegConfirmation;
    use libs\MemberRegInfo;

    global $debug_no_save;

    /**
     * In an effort to be more generic, this determines the path used to get to the current request. Such things
     * as the host and any queries are stripped from the path before returning.
     * @return string The path used by the browser for this request.
     */
    function myCalledPath() : string {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    function buildMemberTableLine(string $label, string $value, bool $include_blank) : string {
        if ($include_blank || $value != "") {
            return "<tr><td>$label</td><td>$value</td></tr>";
        }
        return "";
    }

    function buildMemberTable(MemberRegInfo $reg_info, MembershipType $membership_type, bool $include_blanks) : string {
        $member_display = buildMemberTableLine("First Name", $reg_info->first_name, $include_blanks);
        $member_display .= buildMemberTableLine("Last Name", $reg_info->surname, $include_blanks);
        $member_display .= buildMemberTableLine("Badge Name", $reg_info->badge_name, $include_blanks);
        $member_display .= buildMemberTableLine("Email", $reg_info->email, $include_blanks);
        $member_display .= buildMemberTableLine("Phone", $reg_info->phone, $include_blanks);
        $member_display .= buildMemberTableLine("Address #1", $reg_info->address1, $include_blanks);
        $member_display .= buildMemberTableLine("Address #2", $reg_info->address2, $include_blanks);
        $member_display .= buildMemberTableLine("City", $reg_info->city, $include_blanks);
        $member_display .= buildMemberTableLine("Postcode", $reg_info->post_code, $include_blanks);
        $member_display .= buildMemberTableLine("List publicly?", ($reg_info->agree_to_public_listing ? "Yes" : "No"), $include_blanks);
        $member_display .= buildMemberTableLine("Membership", "$membership_type->name (£$membership_type->price)", $include_blanks);
        return $member_display;
    }

    function displayMembers(array $members, Convention $reg_convention) : float {
        $total = 0.0;
        foreach ($members as $key => $member) {
            $reg_info = MemberRegInfo::createFromArray($member);
            $membership_type = $reg_convention->getMembershipType($reg_info->membership_type_id);
            echo "<div class='member-info'>";
            echo "<table>";
            echo buildMemberTable($reg_info, $membership_type, true);
            echo "<tr><td colspan='2' style='text-align: center'><button type='submit' name='edit' value='$key'>Edit</button></td></tr>";
            echo "<tr><td colspan='2' style='text-align: center'><button type='submit' name='delete' value='$key'>Delete</button></td>";
            echo "</table>";
            echo "</div>";
            $total += $membership_type->price;
        }
        echo "<div><b>Total Owed:</b> £$total</div>";
        return $total;
    }

    function listMembers(array $members, Convention $reg_convention, array $reg_uid_list) : void {
        echo "<div class='grand-total'>Payment successful.</div>";
        echo "<h1>Members registered:</h1>";
        foreach ($members as $key => $member) {
            $reg_info = MemberRegInfo::createFromArray($member);
            $membership_type = $reg_convention->getMembershipType($reg_info->membership_type_id);
            echo "<div class='member-info'>";
            echo "<table>";
            echo buildMemberTableLine("Registration ID", $reg_uid_list[$key], false);
            echo buildMemberTable($reg_info, $membership_type, false);
            echo "</table>";
        }
        echo "<form class='home-form' action='/' method='get'><button class='final-home-button'>Home</button></form>";
    }

    function saveRegistrationDetails(array $reg_members, int $reg_year) : array {
        global $debug_no_save;

        // Save all the member information to the database.
        $uid_list = array();
        $membersTable = new MembersTable();
        $registrationsTable = new RegistrationsTable();
        $reg_convention = new Convention($reg_year);
        foreach ($reg_members as $reg_member) {
            $reg_info = MemberRegInfo::createFromArray($reg_member);
            $member = Member::createFromMemberRegInfo($reg_info);
            $membership_type = $reg_convention->getMembershipType($reg_info->membership_type_id);

            $id = $debug_no_save ? rand(1, 500) :  $membersTable->addMember($member);
            $member->id = $id;

            $registration = Registration::createFromRegInfo($member, $reg_info, $membership_type);
            $id = $debug_no_save ? rand(1, 500) :  $registrationsTable->addRegistration($registration);
            $registration->id = $id;

            $uid_list[] = generateRegUid($member, $registration, $membership_type);

            // Send an email confirmation
            $mail_confirmation = new MailRegConfirmation($reg_year, $member, $registration, $membership_type);
            $mailer = new Mailer(new MailConfigRegistration);
            $mailer->send_email($mail_confirmation);
        }
        return $uid_list;
    }

    function generateRegUid(Member $member, Registration $registration, MembershipType $membershipType) : string {
        return "M$member->id-E$registration->event_id-R$registration->id-P$membershipType->price";
    }