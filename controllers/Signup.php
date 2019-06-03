<?php

class Signup extends ViewControllerContract
{
    private $page;
    private $title;
    private $status;
    private $payload;

    public function __construct()
    {
        $this->page = "signup";
        $this->title = "Signup";
    }

    public function get()
    {
        $usersObject = new Users();
        $payload = $usersObject->selectUsers();
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

    public function setUser($userInfo){
        $user = new Users();
        $modelResponse = $user ->insertUser($userInfo);
        $payload = $modelResponse['payload'];
        $status = $modelResponse['status'];
        $this->createContract($status, $payload);
    }
}
