<?php
include APP_PATH . '/views/includes/head.php';
include APP_PATH . '/views/includes/header.php';
?>



<main class="signup-main">
<?php
if ($status === "success") {
    foreach ($payload as $key) {
        $fname = $key['firstName'];
        $lname = $key['lastName'];
        $email = $key['email'];
        echo "<form>
    <h2>Welcome $fname $lname</h2>
    <h3>$email</h3>";
        foreach ($key['availability'] as $availability) {
            $timestamp = strtotime($availability);
            $availability = date('d F Y, h:i A', $timestamp);
            echo "<p>$availability</p>";

        }
        echo "</form>";
    }

} else {

    ?>
    <form action="<?=BASE_PATH . "/signup"?>" method="POST">
    <h2>Sign Up</h2>
        <input type="hidden" name="action" value="POST">
        <input type="text" name="firstName" placeholder="first name">
        <input type="text" name="lastName" placeholder ="last name">
        <input type="email" name="email" placeholder ="example@students.highline.edu">
        <button type="button" class="bttn-simple bttn-sm" onclick="signup.signupAddAvailabilityTime()">Availability</button>
        <div id = "availability"></div>


        <p><label for="future-updates">I would like to receive email updates.</label>
        <input type="checkbox" name="emailUpdates" id="future-updates" class="regular-checkbox"/></p>
        <p><label for="future-club-leader">I want to be future club leaders.</label>
        <input type="checkbox" name="futureClubLeader" id="future-club-leader" class="regular-checkbox"/></p>

        <button type="submit">Sign Up</button>
    </form>
<?php
}

?>

</main>
<script src="<?=BASE_PATH . "/public/js/signup.js"?>"></script>
<?php

include APP_PATH . '/views/includes/footer.php';
?>