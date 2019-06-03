<?php
session_start();

require "./globals.php";
//DB connection
require APP_PATH . "/models/DBConnect.php";
// viewBuilder for building pages
require APP_PATH . "/views/ViewBuilder.php";

//Controllers for choosing pages and generating data and calling the viewBuilder function to add data in it
require APP_PATH . "/controllers/Controllers.php";

//router for routing and helping to select which controller needs to be select.
require APP_PATH . "/utils/router.php";
