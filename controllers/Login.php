<?php

class Login extends ViewControllerContract
{
    private $page;
    private $title;
    private $status;
    private $payload;

    public function __construct()
    {
        $this->page = "login";
        $this->title = "Login";
    }

    public function get()
    {   
        $payload = [

        ];
        $status = "failed";
        $this->createContract($status, $payload);
    }

    private function createContract($status, $payload)
    {
        $this->status = $status;
        $this->payload = $payload;

        parent::__construct(
            $this->page,
            $this->title,
            $this->status,
            $this->payload
        );
    }
    public function authAdmin($userInfo){
        $admin = new AdminModel();
        $modelResponse = $admin ->getAdmin($userInfo);
        $payload = $modelResponse['payload'];
        $status = $modelResponse['status'];
        $this->createContract($status, $payload);
    }
}
