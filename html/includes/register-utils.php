<?php
    require_once __DIR__ . "/../libs/MemberRegInfo.php";
    require_once __DIR__ . "/../db/bootstrap.php";
    require_once __DIR__ . "/../libs/Convention.php";
    require_once __DIR__ . "/../config/MailConfig.php";
    require_once __DIR__ . "/../libs/Mailer.php";
    require_once __DIR__ . "/../libs/MailRegConfirmation.php";
    require_once __DIR__ . "/../includes/stripe-processing.php";

    use config\MailConfigRegistration;
    use db\MembersTable;
    use db\Member;
    use db\Registration;
    use db\RegistrationsTable;
    use libs\Convention;
    use libs\Mailer;
    use libs\MailRegConfirmation;
    use libs\MemberRegInfo;

    $debug_no_save = true;      // FIXME: Do not check in with this set to true.

    function displayMembers(array $members, Convention $reg_convention) : float {
        $total = 0.0;
        foreach ($members as $key => $member) {
            $reg_info = MemberRegInfo::createFromArray($member);
            $membership_type = $reg_convention->getMembershipType($reg_info->membership_type_id);
            echo "<div class='member-info'>";
            echo "<table class='member-table'>";
            echo "<tr><td>First Name</td><td>$reg_info->first_name</td></tr>";
            echo "<tr><td>Last Name</td><td>$reg_info->surname</td></tr>";
            echo "<tr><td>Badge Name</td><td>$reg_info->badge_name</td></tr>";
            echo "<tr><td>Email</td><td>$reg_info->email</td></tr>";
            echo "<tr><td>Phone</td><td>$reg_info->phone</td></tr>";
            echo "<tr><td>Address #1</td><td>$reg_info->address1</td></tr>";
            echo "<tr><td>Address #2</td><td>$reg_info->address2</td></tr>";
            echo "<tr><td>City</td><td>$reg_info->city</td></tr>";
            echo "<tr><td>Postcode</td><td>$reg_info->post_code</td></tr>";
            echo "<tr><td>List publicly?</td><td>" . ($reg_info->agree_to_public_listing ? "Yes" : "No") . "</td></tr>";
            echo "<tr><td>Membership</td><td>$membership_type->name (£$membership_type->price)</td></tr>";
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
        $total = 0.0;
        $member_display = "";
        foreach ($members as $member) {
            $reg_info = MemberRegInfo::createFromArray($member);
            $membership_type = $reg_convention->getMembershipType($reg_info->membership_type_id);
            $display_name = mb_strtoupper($reg_info->displayName());
            $member_display .= "<div class='multipass'><img src='/Images/multipass-template.png' alt='MULTI PASS'/><div class='multipass-name'>$display_name</div></div>";
            $total += $membership_type->price;
        }
        echo "<div class='grand-total'>Please Pay £$total</div>";
        echo "<div class='uid-list'><ul>";
        echo "<p>Please provide the following code" . (count($reg_uid_list) > 1 ? "s" : "") . " when providing payment:</p>";
        foreach ($reg_uid_list as $uid) {
            echo "<li>$uid</li>";
        }
        echo "</ul></div>";
        echo "<h1>Members registered:</h1>";
        echo "<ul>$member_display</ul>";
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

            $uid = "M$member->id-E$registration->event_id-R$registration->id-P$membership_type->price";
            $uid_list[] = $uid;

            // Send an email confirmation
            $mail_confirmation = new MailRegConfirmation($reg_year, $member, $registration, $membership_type);
            $mailer = new Mailer(new MailConfigRegistration);
            $mailer->send_email($mail_confirmation);
        }
        return $uid_list;
    }