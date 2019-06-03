<?php
class AboutClub extends DBConnect
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

    public function selectAbout()
    {
        $retrieve = $this->dbConnection()->query("SELECT * FROM about");
        $result = $retrieve->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function selectAboutById($id)
    {
        $retrieve = $this->dbConnection()->query("SELECT * FROM about WHERE id ='$id'");
        $result = $retrieve->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function insertAbout($about)
    {
        $id = null;
        $title = $this->sanitizer->sanitizeString($about['title']);
        $description = $this->sanitizer->sanitizeString($about['description']);

        $this->errorChecker($title, $description);
        if ($this->hasError) {
            return [
                "status" => "failed",
                "statusCode"=>400,
                "payload" => $this->errorMessage,

            ];
        } else {
            $insertAbout = $this->dbConnection()->prepare("INSERT INTO about VALUES (?,?,?)");
            $insertAbout->execute(array($id, $title, $description));

            return [
                "status" => "success",
                "statusCode"=>200,
                "payload" => "inserted",
            ];

        }

    }

    public function updateAboutById($id, $body)
    {
        $title = $this->sanitizer->sanitizeString($body['title']);
        $description = $this->sanitizer->sanitizeString($body['description']);
        $this->errorChecker($title, $description);
        if ($this->hasError) {
            return [
                "status" => "failed",
                "statusCode"=>400,
                "payload" => $this->errorMessage,

            ];

        } else {
            $update = $this->dbConnection()->query("UPDATE about
            SET `title` = '$title',
                `description` = '$description'
                WHERE id='$id';");

            return [
                "status" => "success",
                "statusCode"=>200,
                "payload" => "updated",

            ];
        }

    }

    public function deleteAboutById($id)
    {
        $delete = $this->dbConnection()->query(" DELETE FROM about WHERE id='$id'");
    }

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
}
