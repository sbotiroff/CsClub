<?php
include APP_PATH . '/views/includes/head.php';
include APP_PATH . '/views/includes/header.php';
?>

<link rel="stylesheet" href=<?=BASE_PATH . "/public/css/dashboard.css?";?> />
<main class="dashboard">
    <nav>
        <ul>
            <li><a id ="events">Events</a> </li>
            <li><a id ="opportunity">Opportunity</a> </li>
            <li><a id ="faq">Faq</a></li>
            <li><a id ="clubLeaders">Club Leaders</a></li>
            <li><a id ="users">Users</a></li>
            <li><a id ="announcement">Announcement</a></li>
            <li><a id ="about">About</a></li>
            <li class="dashboard-log-out"><a href="<?=BASE_PATH . "/log-out"?>">Log Out</a></li>
        </ul>

    </nav>
    <div id="root">
        <form action="" method="POST">
        <div>TO:
        <?php 
            foreach($payload as $email){
                $singleEmail = $email['email'];
                echo" 
                <p><label >$singleEmail
                        <input name='email[]' type='checkbox' value='$singleEmail'>
                    </label> 
                </p>";
            } ?>
            </div>
            
           <p><label for="">Subject: <input type="text" name="subject"></label></p>
           <p><textarea name="message" id="" cols="30" rows="10"></textarea></p>
           <button type='submit'>Send</button>
       </form>

       <?php
    //    var_dump($_POST);
    if(isset($_POST['email'])){
        foreach($_POST['email'] as $key){
            $to = $key;
            $subject = $_POST['subject'];
            $body = $_POST['message'];
            $from = "sardor.botiroff@gmail.com";
            $result = mail($to,$subject,$body,$from);
            echo"<p>Email Sent to :$to</p>";
            
         }
         echo"<p>Subject :$subject<p>";
         echo"<p>Message :$body<p>";
    }
       
       ?>
    </div>
</main>
<script src=<?=BASE_PATH . "/public/js/dashboard/modules/fetch.js";?>></script>
<script src=<?=BASE_PATH . "/public/js/dashboard/modules/helpers.js";?>></script>

<script src=<?=BASE_PATH . "/public/js/dashboard/modules/leaders.js";?>></script>
<script src=<?=BASE_PATH . "/public/js/dashboard/modules/events.js";?>></script>
<script src=<?=BASE_PATH . "/public/js/dashboard/modules/announcement.js";?>></script>
<script src=<?=BASE_PATH . "/public/js/dashboard/modules/faq.js";?>></script>
<script src=<?=BASE_PATH . "/public/js/dashboard/modules/opportunities.js";?>></script>
<script src=<?=BASE_PATH . "/public/js/dashboard/modules/about.js";?>></script>
<script src=<?=BASE_PATH . "/public/js/dashboard/modules/users.js";?>></script>
<script src=<?=BASE_PATH . "/public/js/dashboard/app.js";?>></script>
<?php
include APP_PATH . '/views/includes/footer.php';
?>