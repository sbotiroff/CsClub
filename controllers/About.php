<?php

class About extends ViewControllerContract
{
    private $page;
    private $title;
    private $status;
    private $payload;

    public function __construct()
    {
        $this->page = "about";
        $this->title = "About";
    }

    public function get()
    {
        $aboutModel = new AboutClub();
        $payload = $aboutModel->selectAbout();
        $status = "success";
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
