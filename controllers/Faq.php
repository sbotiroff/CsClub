<?php

class Faq extends ViewControllerContract
{
    private $page;
    private $title;
    private $status;
    private $payload;

    public function __construct()
    {
        $this->page = "faq";
        $this->title = "Faq";
    }

    public function get()
    {
        $faq = new Faqs();

        $payload = $faq->selectFaqs();
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
