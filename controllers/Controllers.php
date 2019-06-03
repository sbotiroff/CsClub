<?php
//Including Validations 
include APP_PATH . '/models/InputChecker.php';
include APP_PATH . '/models/Sanitizer.php';

// Including models
include APP_PATH . '/models/ViewControllerContract.php';
include APP_PATH . '/models/AdminModel.php';
include APP_PATH . '/models/Events.php';
include APP_PATH . '/models/Opportunities.php';
include APP_PATH . '/models/Faqs.php';
include APP_PATH . '/models/Leaders.php';
include APP_PATH . '/models/Users.php';
include APP_PATH . '/models/User.php';
include APP_PATH . '/models/Announcements.php';
include APP_PATH . '/models/AboutClub.php';

// including helper controllers
require APP_PATH . "/controllers/Home.php";
require APP_PATH . "/controllers/Opportunity.php";
require APP_PATH . "/controllers/Login.php";
require APP_PATH . "/controllers/About.php";
require APP_PATH . "/controllers/Contact.php";
require APP_PATH . "/controllers/Faq.php";
require APP_PATH . "/controllers/Signup.php";
require APP_PATH . "/controllers/Dashboard.php";
require APP_PATH . "/controllers/Error404.php";
require APP_PATH . "/controllers/Api.php";

class Controllers
{
    private $home;
    private $about;
    private $faq;
    private $opportunity;
    private $contact;
    private $error;
    private $signup;
    private $login;
    private $dashboard;
    private $api;

    public function __construct()
    {
        $this->home = new Home();
        $this->about = new About();
        $this->faq = new Faq();
        $this->opportunity = new Opportunity();
        $this->contact = new Contact();
        $this->login = new Login();
        $this->signup = new Signup();
        $this->error = new Error404();
        $this->api = new Api();
        $this->dashboard = new Dashboard();
    }
// Getters from db using helper controller and model.
    public function getHome()
    {
        $this->home->get();
        $contract = $this->home->getContract();
        returnViewPage($contract);
    }

    public function getAbout()
    {
        $this->about->get();
        $contract = $this->about->getContract();
        returnViewPage($contract);
    }

    public function getFaq()
    {
        $this->faq->get();
        $contract = $this->faq->getContract();
        returnViewPage($contract);
    }

    public function getOpportunity()
    {
        $this->opportunity->get();
        $contract = $this->opportunity->getContract();
        returnViewPage($contract);
    }

    public function getContact()
    {
        $this->contact->get();
        $contract = $this->contact->getContract();
        returnViewPage($contract);
    }

    public function getSignup()
    {
        $this->signup->get();
        $contract = $this->signup->getContract();
        returnViewPage($contract);
    }

    public function getLogin()
    {
        $this->login->get();
        $contract = $this->login->getContract();
        returnViewPage($contract);
    }

    public function getDashboard()
    {
        $this->dashboard->get();
        $contract = $this->dashboard->getContract();
        returnViewPage($contract);
    }

    public function getError()
    {
        $this->error->get();
        $contract = $this->error->getContract();
        returnViewPage($contract);

    }

// Setters using 


public function postSignup($userInfo)
{
    $this->signup->setUser($userInfo);
    $contract = $this->signup->getContract();
    returnViewPage($contract);
}

public function authAdmin($adminInfo)
{
    $this->login->authAdmin($adminInfo);
    $contract = $this->login->getContract();
    returnViewPage($contract);
}

// apis
public function apiResponse() {
    $this->home->get();
    $contract = $this->home->getContract();
    $this->api->testApiResponse($contract);
}

}
