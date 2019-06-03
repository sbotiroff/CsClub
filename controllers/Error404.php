<?php

class Error404 extends ViewControllerContract
{
    private $page;
    private $title;
    private $status;
    private $payload;

    public function __construct()
    {
        $this->page = "error404";
        $this->title = "Error 404";
    }

    public function get()
    {

        $payload = [
            [
                "id" => 1,
                "title" => "Awesome Book",
                "authorFirstName" => "Sardor",
                "authorLastName" => "Botirov",
            ],
            [
                "id" => 2,
                "title" => "More Awesome Book",
                "authorFirstName" => "Bakhrom",
                "authorLastName" => "Botirov",
            ],
        ];
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
