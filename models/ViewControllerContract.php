<?php

class ViewControllerContract
{
    private $page;
    private $title;
    private $status;
    private $payload;

    public function __construct($page, $title, $status, $payload)
    {
        $this->page = $page;
        $this->title = $title;
        $this->status = $status;
        $this->payload = $payload;
    }

    public function getContract()
    {
        return [
            "page" => $this->page,
            "title" => $this->title,
            "status" => $this->status,
            "payload" => $this->payload,
        ];
    }
}