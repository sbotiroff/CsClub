<header id="nav" class="animated" >
    <?php if(isset($_SESSION['token'])){?>
    <nav class = "dashboard-hidden-nav">
        <ul>
            <li><a href=<?=BASE_PATH . "/cs-admin/dashboard"?> <?php if($page === "dashboard"){echo'class = "active"';}?>>Dashboard</a></li>
        </ul>
    </nav>       
    <?php }else{?>

    <h1><span>&#60; </span><a href=<?=BASE_PATH?>>Cs Club</a><span> /></span></h1>
    <?php }?>
    <nav>
        <ul>
            <li><a href=<?=BASE_PATH?> <?php if($page === "home"){echo"class = 'active'";}?>>Home</a></li>
            <li><a href=<?=BASE_PATH . "/opportunity"?> <?php if($page === "opportunity"){echo"class = 'active'";}?>>Opportunity</a></li>
            <li><a href=<?=BASE_PATH . "/about"?> <?php if($page === "about"){echo'class = "active"';}?>>About</a></li>
            <li><a href=<?=BASE_PATH . "/faq"?> <?php if($page === "faq"){echo'class = "active"';}?>>Faq</a></li>
            <li><a href=<?=BASE_PATH . "/signup"?> <?php if($page === "signup"){echo'class = "active"';}?>><?=(isset($_SESSION['email']))?"Welcome":"SignUp";?></a></li>
            <li><a href=<?=BASE_PATH . "/contact"?> <?php if($page === "contact"){echo'class = "active"';}?>>Contact</a></li>
        </ul>  
        
    </nav>
   
</header>