<?php
include APP_PATH . '/views/includes/head.php';
include APP_PATH . '/views/includes/header.php';
?>
<main class="about">
  
    <?php foreach ($payload as $key) {
        echo"<section>";
        $title = $key['title'];
        $description = $key['description'];
        echo"<h2>$title</h2>";
        echo"<p>$description</p>";
        echo"</section>";  
    }
?>


</main>
<?php
include APP_PATH . '/views/includes/footer.php';
?>