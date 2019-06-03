<?php
class Opportunities extends DBConnect
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

    public function selectOpportunities()
    {
        $retrieve = $this->dbConnection()->query("SELECT * FROM opportunity");
        $result = $retrieve->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function selectOpportunityById($id)
    {
        $retrieve = $this->dbConnection()->query("SELECT * FROM opportunity WHERE id ='$id'");
        $result = $retrieve->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function insertOpportunity($opportunity)
    {
        $id = null;
        $type = $opportunity['type'];
        $title = $opportunity['title'];
        $description = $this->sanitizer->sanitizeString($opportunity['description']);
        $url = $opportunity['url'];

        $this->errorChecker($title, $description);
        if ($this->hasError) {
            return [
                "status" => "failed",
                "statusCode"=>400,
                "payload" => $this->errorMessage,
            ];
        } else {

            $insertOpportunity = $this->dbConnection()->prepare("INSERT INTO opportunity VALUES (?,?,?,?,?)");
            $insertOpportunity->execute(array($id, $type, $title, $description, $url));

            return [
                "status" => "success",
                "statusCode"=>200,
                "payload" => "inserted",
            ];
        }
    }

    public function updateOpportunityById($id, $body)
    {
        $type = $body['type'];
        $title = $body['title'];
        $description = $this->sanitizer->sanitizeString($body['description']);
        $url = $body['url'];

        $this->errorChecker($title, $description);
        if ($this->hasError) {
            return [
                "status" => "failed",
                "statusCode"=>400,
                "payload" => $this->errorMessage,
            ];
        } else {
            $update = $this->dbConnection()->query("UPDATE opportunity
        SET `type` ='$type',
            `title` = '$title',
            `description` = '$description',
            `url` = '$url'
            WHERE id='$id';");

            return [
                "status" => "success",
                "statusCode"=>200,
                "payload" => "updated",
            ];}
    }

    public function deleteOpportunityById($id)
    {
        $delete = $this->dbConnection()->query(" DELETE FROM opportunity WHERE id='$id'");
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
