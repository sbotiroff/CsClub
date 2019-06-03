<?php
include APP_PATH . '/views/includes/head.php';
include APP_PATH . '/views/includes/header.php';
?>
<?php
   if($status ==='success' || isset($_SESSION['token'])){
    header("Location:" . BASE_PATH . '/cs-admin/dashboard' . "");
   }else{
?>
<main class="cs-admin-login">
    <form action="<?=BASE_PATH."/cs-admin/login"?>" method="POST">
        <h2>Admin</h2>
        <input type="hidden" name="action" value="POST">
        <input type="text" placeholder="username" name = "username">
        <input type="password"placeholder="password" name = "password">
        <button type="submit">Log In</button>
    </form>
</main>
 <?php 
 }
   
?> 



<?php
include APP_PATH . '/views/includes/footer.php';
?>