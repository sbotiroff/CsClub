<?php

class Contact extends ViewControllerContract
{
    private $page;
    private $title;
    private $status;
    private $payload;

    public function __construct()
    {
        $this->page = "contact";
        $this->title = "Contact";
    }

    public function get()
    {
        $leaders = new Leaders();
        $payload = $leaders->selectLeaders();
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
