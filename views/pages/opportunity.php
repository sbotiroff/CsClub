<?php
include APP_PATH . '/views/includes/head.php';
include APP_PATH . '/views/includes/header.php';
?>
<main class = "opportunity">
    <div class="internship">
    <h2>Internships</h2>
        <?php foreach ($payload as $key) {
    if ($key['type'] === "internship") {
        $title = $key['title'];
        $description = $key['description'];
        $url = $key['url'];
        print<<<SECTION
        <section>
            <h3>$title</h3>
            <p>$description</p>
        </section>
SECTION;
    }
}
?>
    </div>
    <div class="volunteerWork">
    <h2>Volunteer Works</h2>
        <?php foreach ($payload as $key) {
    if ($key['type'] === "volunteerWork") {
        $title = $key['title'];
        $description = $key['description'];
        $url = $key['url'];
        print<<<SECTION
        <section>
            <h3>$title</h3>
            <p>$description</p>
        </section>
SECTION;

    }
}
?>
    </div>

    <div class="jobs">
    <h2>Jobs</h2>
    <?php foreach ($payload as $key) {
    if ($key['type'] === "jobs") {
        $title = $key['title'];
        $description = $key['description'];
        $url = $key['url'];
        print<<<SECTION
        <section>
            <h3>$title</h3>
            <p>$description</p>
        </section>
SECTION;

    }
}
?>
    </div>



</main>
<?php
include APP_PATH . '/views/includes/footer.php';
?>