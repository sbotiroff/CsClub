<?php

class Dashboard extends ViewControllerContract
{
    private $page;
    private $title;
    private $status;
    private $payload;

    public function __construct()
    {
        $this->page = "dashboard";
        $this->title = "dashboard";
    }

    public function get()
    {
        $email = new Users();
        $payload = $email->selectUsers();
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
}
