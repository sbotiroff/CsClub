<?php
include APP_PATH . '/views/includes/head.php';
include APP_PATH . '/views/includes/header.php';
?>
<main class="contact">
    <div class = "all-leaders">
    <?php foreach ($payload as $key) {
    $first_name = $key['first_name'];
    $last_name = $key['last_name'];
    $email = $key['email'];
    $image = $key['image'];
    $position = $key['position'];
    $major = $key['major'];
    $contact = $key['contact'];
    echo"<div class='leader'>";
        echo"<h3>$first_name $last_name</h3>";
        if(!empty($image)){
            echo "<img src=data:image/*;base64," . base64_encode($image). " width ='100%' />";
        }else{
            echo"<img src='".BASE_PATH."/public/images/icon/user.png' width = '100%' />";
        }
        echo"<ul>";
            echo"<li>Position: $position</li>";
            echo"<li>Major: $major</li>";
            echo"<li>Contact info: <a href='mailto:$email?' target='_top'>$email</a></li>";
        echo"</ul>";

    echo"</div>";

}
?>
    </div>
</main>
<?php
include APP_PATH . '/views/includes/footer.php';
?>



</div>