<?php
class Leaders extends DBConnect
{
    private $inputChecker;
    private $sanitizer;
    private $errorMessage;
    private $hasError;

    public function __construct()
    {
        $this->inputChecker = new InputChecker();
        $this->sanitizer = new Sanitizer();
        $this->errorMessage = [];
        $this->hasError = false;
    }
    public function selectLeaders()
    {
        $retrieve = $this->dbConnection()->query("SELECT * FROM club_leaders");
        $result = $retrieve->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function selectLeaderById($id)
    {
        $retrieve = $this->dbConnection()->query("SELECT * FROM club_leaders WHERE id ='$id'");
        $result = $retrieve->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function insertLeader($leader)
    {

        $id = null;
        $first_name = $this->sanitizer->sanitizeString($leader['first_name']);
        $last_name = $this->sanitizer->sanitizeString($leader['last_name']);
        $email = $this->sanitizer->sanitizeEmail($leader['email']);
        $image = isset($leader['image'])?$leader['image']:null;
        $position = $this->sanitizer->sanitizeString($leader['position']);
        $major = $this->sanitizer->sanitizeString($leader['major']);
        $contact = $this->sanitizer->sanitizeString($leader['contact']);
        $this->errorChecker($first_name,$last_name,$email,$position,$major,$contact);
        if ($this->hasError) {
            return [
                "status" => "failed",
                "statusCode"=>400,
                "payload" => $this->errorMessage,
            ];
        } else {

        $insertLeaders = $this->dbConnection()->prepare("INSERT INTO club_leaders VALUES (?,?,?,?,?,?,?,?)");
        $insertLeaders->execute(array($id, $first_name, $last_name, $email, $image, $position, $major,$contact));
        return [
            "status" => "success",
            "statusCode"=>200,
            "payload" => "inserted",
        ];

        }
    }

    public function updateLeaderById($id, $body)
    {
        $first_name = $this->sanitizer->sanitizeString($body['first_name']);
        $last_name = $this->sanitizer->sanitizeString($body['last_name']);
        $email = $this->sanitizer->sanitizeEmail($body['email']);
        $image = isset($body['image'])?$body['image']:null;
        $position = $this->sanitizer->sanitizeString($body['position']);
        $major = $this->sanitizer->sanitizeString($body['major']);
        $contact = $this->sanitizer->sanitizeString($body['contact']);
        $this->errorChecker($first_name,$last_name,$email,$position,$major,$contact);
        if ($this->hasError) {
            return [
                "status" => "failed",
                "statusCode"=>400,
                "payload" => $this->errorMessage,
            ];
        } else {

        $update = $this->dbConnection()->query("UPDATE club_leaders
        SET `first_name`= '$first_name',
            `last_name`= '$last_name',
            `email`= '$email',
            `image`='$image',
            `position`= '$position',
            `major`= '$major',
            `contact`= '$contact'
            WHERE id='$id';");
             return [
                "status" => "success",
                "statusCode"=>200,
                "payload" => "inserted",
            ];
    
            }
    }

    public function deleteLeaderById($id)
    {
        $delete = $this->dbConnection()->query(" DELETE FROM club_leaders WHERE id='$id'");
    }

    //------------------------Error Checker and Generator----------------------------
    public function errorChecker($first_name,$last_name,$email,$position,$major)
    {
        if (!$this->inputChecker->isValidString($first_name)) {
            $this->errorMessage += [
                "first_name" => "Enter first name",
            ];
            $this->hasError = true;
        }
        if (!$this->inputChecker->isValidString($last_name)) {
            $this->errorMessage += [
                "last_name" => "Enter last name",
            ];
            $this->hasError = true;
        }
        if (!$this->inputChecker->isValidEmail($email)) {
            $this->errorMessage += [
                "email" => "Enter valid email",
            ];
            $this->hasError = true;
        }
        if (!$this->inputChecker->isValidString($position)) {
            $this->errorMessage += [
                "position" => "Enter position",
            ];
            $this->hasError = true;
        }
        if (!$this->inputChecker->isValidString($major)) {
            $this->errorMessage += [
                "major" => "Enter major",
            ];
            $this->hasError = true;
        }
    }
    //******************************************************************************
}
