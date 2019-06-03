<?php
class Users extends DBConnect
{

    private $users = [];
    private $user;
    private $inputChecker;
    private $sanitizer;

    public function __construct()
    {
        $this->inputChecker = new InputChecker();
        $this->sanitizer = new Sanitizer();
    }
    //Select All users
    public function selectUsers()
    {
        $clearAvailability = $this->dbConnection()->query("DELETE FROM users_availability WHERE `availability` < CURRENT_TIMESTAMP");
        $retrieve = $this->dbConnection()->query("SELECT users.*, users_availability.availability FROM users LEFT JOIN users_availability ON users.id = users_availability.id");
        $result = $retrieve->fetchAll(PDO::FETCH_ASSOC);
        $users = $this->mergeUsersAvailability($result);
        return $users;
    }

    //Select single user
    public function selectUserById($id)
    {
        $retrieve = $this->dbConnection()->query("SELECT users.*, users_availability.availability FROM users LEFT JOIN users_availability ON users.id = users_availability.id WHERE users.id ='$id'");
        $result = $retrieve->fetchAll(PDO::FETCH_ASSOC);
        $user = $this->mergeUsersAvailability($result);
        return $user;
    }

    //Insert user
    public function insertUser($userInfo)
    {
        $id = null;
        $firstName = $userInfo['firstName'];
        $lastName = $userInfo['lastName'];
        $email = $userInfo['email'];
        $futureUpdates = (isset($userInfo['emailUpdates']) && $userInfo['emailUpdates']) ? 1 : 0;
        $futureClubLeader = (isset($userInfo['futureClubLeader'])&& $userInfo['futureClubLeader'])? 1 : 0;
        $availability = isset($userInfo['availability']) ? $userInfo['availability'] : [];

        $this->dbConnection()->beginTransaction();
        $insertUsers = $this->dbConnection()->query(
            "INSERT INTO users (`id`,`first_name`,`last_name`,`email`,`email_updates`,`future_club_leader`) VALUES
                                (null,'$firstName','$lastName','$email','$futureUpdates','$futureClubLeader') ON DUPLICATE KEY UPDATE
                                `first_name`='$firstName',`last_name`='$lastName',`email_updates`='$futureUpdates',`future_club_leader`='$futureClubLeader'");

        $result = $this->dbConnection()->query("SELECT id FROM `users` WHERE email='$email'");
        $id = $result->fetch(PDO::FETCH_ASSOC)["id"];
        foreach ($availability as $date) {
            $date = strtotime($date);
            $timestamp = date('Y-m-d H:i:s', $date);
            $insertAvailability = $this->dbConnection()->prepare("INSERT INTO users_availability VALUES (?,?)");
            $insertAvailability->execute(array($id, $timestamp));
        }
        return [
            "status" => "success",
            "payload" => $this->selectUserById($id),
        ];
    }

    public function updateUserById($id, $body)
    {
        // TODO: ERROR HANDALING
        $firstName = $body['firstName'];
        $lastName = $body['lastName'];
        $email = $body['email'];
        $futureUpdates = (!empty($body['emailUpdates']))? 1 : 0;
        $futureClubLeader = (!empty($body['futureClubLeader']))? 1 : 0;
        $availability = isset($body['availability']) ? $body['availability'] : [];
        $update = $this->dbConnection()->query("UPDATE users
        SET  `first_name`='$firstName',
             `last_name`='$lastName',
             `email`='$email',
             `email_updates`='$futureUpdates',
             `future_club_leader`='$futureClubLeader'
            WHERE id='$id';");
    }

    //delete user by id
    public function deleteUserById($id)
    {
        $deleteUser = $this->dbConnection()->query(" DELETE FROM users WHERE id = '$id'; DELETE FROM users_availability WHERE id = '$id';");
        return [
            "deleted" => "yes",
        ];
    }

    private function objectToArray()
    {
        $userArray = [];
        foreach ($this->users as $user) {
            array_push($userArray, $user->getUserData());
        }
        return $userArray;
    }

    private function mergeUsersAvailability($result)
    {
        $currentId = 0;
        foreach ($result as $key) {
            if ($currentId != $key['id']) {
                $this->user = new User(
                    $key['id'],
                    $key['first_name'],
                    $key['last_name'],
                    $key['email'],
                    $key['email_updates'],
                    $key['future_club_leader']
                );
                if (isset($key['availability'])) {
                    $this->user->setAvailability($key['availability']);
                    $currentId = $key['id'];
                }
                array_push($this->users, $this->user);
            } else {
                $this->user->setAvailability($key['availability']);
            }
        }
        return $this->objectToArray();
    }

    //------------------------Error Checker and Generator----------------------------
    public function errorChecker($title, $description)
    {
        if (!$this->inputChecker->isValidString($title)) {
            $this->errorMessage += [
                "title" => "Enter valid title",
            ];
            $this->hasError = true;
        }
        if (!$this->inputChecker->isValidString($description)) {
            $this->errorMessage += [
                "description" => "Enter valid description",
            ];
            $this->hasError = true;
        }
    }
    //******************************************************************************
}
