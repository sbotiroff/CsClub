<?php

class Opportunity extends ViewControllerContract
{
    private $page;
    private $title;
    private $status;
    private $payload;

    public function __construct()
    {
        $this->page = "opportunity";
        $this->title = "Opportunity";
    }

    public function get()
    {
        $opportunity = new Opportunities();
        
        $payload = $opportunity->selectOpportunities();
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
