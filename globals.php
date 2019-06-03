<?php

# Define APP ROOT
define("APP_PATH", dirname(__FILE__));

// Define URL of the the app as BASE PATH which can be used for public folders.
$protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
define("BASE_PATH", $protocol . $_SERVER['SERVER_NAME'] . $_SERVER["CONTEXT_PREFIX"] .'/csclub');

function vardump($vardump){
    echo"<div style='border:1px solid black; margin:20px; padding:10px;'>";
    foreach($vardump as $vardumpkey){
        echo"<div style='border:1px solid white;'>";
        foreach($vardumpkey as $key=>$value){
            echo"<div><span style='color:red;'>$key :</span><p>$value<p></div>";
        }

            echo"</div>";
    }
echo"</div>";
}
