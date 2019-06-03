<?php

$controllers = new Controllers();

$request = isset($_GET['url']) ? $_GET['url'] : "/";
$action = isset($_POST['action']) ? $_POST['action'] : "GET";

if ($request === "/" && $action === "GET") {
    $controllers->getHome();
} else if ($request === "about" && $action === "GET") {
    $controllers->getAbout();
} else if ($request === "opportunity" && $action === "GET") {
    $controllers->getOpportunity();
} else if ($request === "faq" && $action === "GET") {
    $controllers->getFaq();
} else if ($request === "signup" && $action === "GET") {
    $controllers->getSignup();
} else if ($request === "contact" && $action === "GET") {
    $controllers->getContact();
}else if (isset($_SESSION['token']) && $request ==="cs-admin/dashboard" && $action ==="GET"){
    $controllers->getDashboard();
}else if (!isset($_SESSION['token']) && $request === "cs-admin" || $request === "cs-admin/" && $action === "GET") {
    header("Location:" . BASE_PATH . '/cs-admin/login' . "");
} else if (!isset($_SESSION['token']) && $request === "cs-admin/login" && $action === "GET") {
    $controllers->getLogin();
}else if (isset($_SESSION['token']) && $request ==="log-out" && $action ==="GET"){
    session_destroy();
    header("Location:" . BASE_PATH . '/' . "");
}

// POST actions.
else if ($request === "signup" && $action === "POST") {
    $userInfo = $_POST;
    $controllers->postSignup($userInfo);
} else if ($request === "cs-admin/login" && $action === "POST") {
    $adminInfo = $_POST;
    echo"iam here";
    $controllers->authAdmin($adminInfo);

}else if (preg_match('/\bapi\b/', $request)) {
    $controllers->apiResponse();
}

// 404 Error page.
else {
    $controllers->getError();
}
