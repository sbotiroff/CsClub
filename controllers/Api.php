<?php
class Api
{
    private $reqUri;
    private $reqId;
    private $reqMethod;
    private $reqBody;
    private $response;

    //calling models
    private $modelEvents;
    private $modelOpportunities;
    private $modelFaqs;
    private $modelLeaders;
    private $modelUsers;
    private $modelAnnouncements;
    private $modelAboutClub;

    public function __construct()
    {
        $this->modelEvents = new Events();
        $this->modelOpportunities = new Opportunities();
        $this->modelFaqs = new Faqs();
        $this->modelLeaders = new Leaders();
        $this->modelUsers = new Users();
        $this->modelAnnouncements = new Announcements();
        $this->modelAboutClub = new AboutClub();
        $this->setMethod();
        $this->setRequestBody();
        $this->parseUriString();

        $this->router();
    }

    public function testApiResponse($contract)
    {
        if(isset($this->response['statusCode'])){
        http_response_code($this->response['statusCode']);
    }
        
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization, X-Auth-Token');
        header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS');
        header("content-type: application/json");
        header("token: username%password%md5");
        echo json_encode($this->response, true);
    }

    private function parseUriString()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : "";

        if (preg_match('/\bapi\b/', $url)) {

            $parsedUrl = explode("/", $url);
            $this->reqUri = $parsedUrl[1];
            $this->reqId = (isset($parsedUrl[2]))?$parsedUrl[2]:null;
        }
    }

    private function setRequestBody()
    {
        $this->reqBody = json_decode(file_get_contents('php://input'), true);
    }

    private function setMethod()
    {
        $this->reqMethod = $_SERVER['REQUEST_METHOD'];
    }

    private function router()
    {
        // route apis
        $uri = $this->reqUri;
        $method = $this->reqMethod;
        $id = $this->reqId;

        //----------------------Events--------------------------
        //Select all Events
        if ($uri === "events" && $method === "GET" && !isset($id)) {
            $this->response = $this->modelEvents->selectEvents();
            return;
        }
        //Select Event by Id
        if ($uri === "events" && $method === "GET" && isset($id)) {
            $this->response = $this->modelEvents->selectEventById($id);
            return;
        }
         //Insert Events
         if ($uri === "events" && $method === "POST" && !isset($id)) {
            $this->response = $this->modelEvents->insertEvent($this->reqBody);
            return;
        }
        //Delete Event by Id 
        if ($uri === "events" && $method === "DELETE" && isset($id)) {
            $this->response = $this->modelEvents->deleteEventById($id);
            return;
        }
        //Update Event by Id 
        if ($uri === "events" && $method === "PUT" && isset($id)) {
            $this->response = $this->modelEvents->updateEventById($id,$this->reqBody);
            return;
        }
        //----------------------------------------------------------


        //----------------------Opportunities--------------------------
        //Select all Opportunities
        if ($uri === "opportunities" && $method === "GET" && !isset($id)) {
            $this->response = $this->modelOpportunities->selectOpportunities();
            return;
        }
        //Select Opportunity by Id
        if ($uri === "opportunities" && $method === "GET" && isset($id)) {
            $this->response = $this->modelOpportunities->selectOpportunityById($id);
            return;
        }
         //Insert Opportunities
         if ($uri === "opportunities" && $method === "POST" && !isset($id)) {
            $this->response = $this->modelOpportunities->insertOpportunity($this->reqBody);
            return;
        }
        //Delete Opportunity by Id 
        if ($uri === "opportunities" && $method === "DELETE" && isset($id)) {
            $this->response = $this->modelOpportunities->deleteOpportunityById($id);
            return;
        }
        //Update Opportunity by Id 
        if ($uri === "opportunities" && $method === "PUT" && isset($id)) {
            $this->response = $this->modelOpportunities->updateOpportunityById($id,$this->reqBody);
            return;
        }
        //----------------------------------------------------------


        //----------------------Faqs---------------------------------
        //Select all faqs
        if ($uri === "faqs" && $method === "GET" && !isset($id)) {
            $this->response = $this->modelFaqs->selectFaqs();
            return;
        }
        //Select faq by Id
        if ($uri === "faqs" && $method === "GET" && isset($id)) {
            $this->response = $this->modelFaqs->selectFaqById($id);
            return;
        }
         //Insert faq
         if ($uri === "faqs" && $method === "POST" && !isset($id)) {
            $this->response = $this->modelFaqs->insertFaq($this->reqBody);
            return;
        }
        //Delete faq by Id 
        if ($uri === "faqs" && $method === "DELETE" && isset($id)) {
            $this->response = $this->modelFaqs->deleteFaqById($id);
            return;
        }
        //Update faq by Id 
        if ($uri === "faqs" && $method === "PUT" && isset($id)) {
            $this->response = $this->modelFaqs->updateFaqById($id,$this->reqBody);
            return;
        }
        //----------------------------------------------------------


        //----------------------Club Leaders-------------------------
         //Select all leaders
         if ($uri === "leaders" && $method === "GET" && !isset($id)) {
            $this->response = $this->modelLeaders->selectLeaders();
            return;
        }
        //Select leader by Id 
        if ($uri === "leaders" && $method === "GET" && isset($id)) {
            $this->response = $this->modelLeaders->selectLeaderById($id);
            return;
        }
        //Insert leader
        if ($uri === "leaders" && $method === "POST" && !isset($id)) {
            $this->response = $this->modelLeaders->insertLeader($this->reqBody);
            return;
        }
        //Delete leader by Id 
        if ($uri === "leaders" && $method === "DELETE" && isset($id)) {
            $this->response = $this->modelLeaders->deleteLeaderById($id);
            return;
        }
        //Update leader by Id 
        if ($uri === "leaders" && $method === "PUT" && isset($id)) {
            $this->response = $this->modelLeaders->updateLeaderById($id,$this->reqBody);
            return;
        }
        //----------------------------------------------------------


        //----------------------Users--------------------------------
        //Select all Users
        if ($uri === "users" && $method === "GET" && !isset($id)) {
            $this->response = $this->modelUsers->selectUsers();
            return;
        }
        //Select user by Id 
        if ($uri === "users" && $method === "GET" && isset($id)) {
            $this->response = $this->modelUsers->selectUserById($id);
            return;
        }
        //Insert User
        if ($uri === "users" && $method === "POST" && !isset($id)) {
            $this->response = $this->modelUsers->insertUser($this->reqBody);
            return;
        }
        //Delete user by Id 
        if ($uri === "users" && $method === "DELETE" && isset($id)) {
            $this->response = $this->modelUsers->deleteUserById($id);
            return;
        }
        //Update user by Id 
        if ($uri === "users" && $method === "PUT" && isset($id)) {
            $this->response = $this->modelUsers->updateUserById($id,$this->reqBody);
            return;
        }
        //----------------------------------------------------------


        //----------------------Announcements-------------------------
         //Select all Announcements
         if ($uri === "announcements" && $method === "GET" && !isset($id)) {
            $this->response = $this->modelAnnouncements->selectAnnouncements();
            return;
        }
        //Select Announcement by Id 
        if ($uri === "announcements" && $method === "GET" && isset($id)) {
            $this->response = $this->modelAnnouncements->selectAnnouncementById($id);
            return;
        }
        //Insert Announcement
        if ($uri === "announcements" && $method === "POST" && !isset($id)) {
            $this->response = $this->modelAnnouncements->insertAnnouncement($this->reqBody);
            return;
        }
        //Delete Announcement by Id 
        if ($uri === "announcements" && $method === "DELETE" && isset($id)) {
            $this->response = $this->modelAnnouncements->deleteAnnouncementById($id);
            return;
        }
        //Update Announcement by Id 
        if ($uri === "announcements" && $method === "PUT" && isset($id)) {
            $this->response = $this->modelAnnouncements->updateAnnouncementById($id,$this->reqBody);
            return;
        }
        //----------------------------------------------------------


        //----------------------About-------------------------------
         //Select all About
         if ($uri === "about" && $method === "GET" && !isset($id)) {
            $this->response = $this->modelAboutClub->selectAbout();
            return;
        }
        //Select About by Id 
        if ($uri === "about" && $method === "GET" && isset($id)) {
            $this->response = $this->modelAboutClub->selectAboutById($id);
            return;
        }
        //Insert About
        if ($uri === "about" && $method === "POST" && !isset($id)) {
            $this->response = $this->modelAboutClub->insertAbout($this->reqBody);
            return;
        }
        //Delete About by Id 
        if ($uri === "about" && $method === "DELETE" && isset($id)) {
            $this->response = $this->modelAboutClub->deleteAboutById($id);
            return;
        }
        //Update About by Id 
        if ($uri === "about" && $method === "PUT" && isset($id)) {
            $this->response = $this->modelAboutClub->updateAboutById($id,$this->reqBody);
            return;
        }
        //----------------------------------------------------------
        // $this->response = [
        //     "statusCode"=>400,
        //     "payload"=>"Bad Request"
        // ];
    }
}
