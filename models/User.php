<?php
class User extends DBConnect
{
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $emailUpdates;
    private $futureClubLeader;
    private $availability;

    public function __construct(
        $id,
        $firstName,
        $lastName,
        $email,
        $emailUpdates,
        $futureClubLeader
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->emailUpdates = $emailUpdates;
        $this->futureClubLeader = $futureClubLeader;
        $this->availability = [];
    }

    public function setAvailability($timestamp)
    {
        array_push($this->availability, strtotime($timestamp));
    }

    public function getUserData()
    {
        return [
            "id" => $this->id,
            "firstName" => $this->firstName,
            "lastName" => $this->lastName,
            "email" => $this->email,
            "emailUpdates" => $this->emailUpdates,
            "futureClubLeader" => $this->futureClubLeader,
            "availability" => $this->availability,
        ];
    }

  
}
