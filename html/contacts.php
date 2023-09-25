<!doctype html>
<html lang="en">

<?php
    $page_name = "contacts";
    $page_title = "Contact Us";
    include("includes/html-header.php")
?>

<body>
    <?php include("includes/header-banner.php"); ?>

    <!-- Main content section -->
    <div class="content">
        <h1 class="page-title">Contact Us</h1>

        <h2>General Queries</h2>
        <p>If you have a problem, if no one else can help, and if you can find them, then maybe you should contact the 'Eh?' Team.</p>
        <p>
            But seriously, if you have any questions, would like to put on an event or display at ArmadaCon,
            or any other queries, then use the email address below and ask away.
        </p>
        <a style="margin: 40px" href="mailto:armadacon@ghoti.net?subject=ArmadaCon Enquiry">armadacon@ghoti.net</a>

        <h2>Website Queries</h2>
        <p>For website-related enquiries please e-mail the webmaster, putting 'ArmadaCon Website' in the subject line.</p>
        <a style="margin: 40px" href="mailto:armadacon@ghoti.net?subject=ArmadaCon Website">armadacon@ghoti.net</a>

        <h2>Snail Mail</h2>
        <p>If you're a pen and paper sort of person, here is our contact postal address:</p>
            <ul style="list-style-type: none; margin-bottom: 8px">
                <li>ArmadaCon</li>
                <li>23 The Square</li>
                <li>Stonehouse</li>
                <li>Plymouth</li>
                <li>PL1 3JX</li>
            </ul>
    </div>

    <?php include("includes/footer.php")?>
</body>
</html>
