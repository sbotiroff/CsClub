<?php
/* TODO: Refactor this class as PageController and
extend/implement all the single Controllers */

class Home extends ViewControllerContract
{
    private $page;
    private $title;
    private $status;
    private $payload;

    public function __construct()
    {
        $this->page = "home";
        $this->title = "Home";

    }
    
    public function get() {
        $events = new Events();
        $announcement = new Announcements();
        
        
        $payload = [
            "announcements"=>$announcement->selectAnnouncements(),
             "prevEvent"=>$events->prevEvents(),
             "upcomingEvents"=>$events->upcomingEvents(),
             "allEvents"=>$events->selectEvents(),
             "calendarEvents"=>$events->eventsCalendar()
        ];

        $status ="success";
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