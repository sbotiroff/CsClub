<?php
class Announcements extends DBConnect
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

    //------------------------Select Announcements------------------------------
    public function selectAnnouncements()
    {
        $retrieve = $this->dbConnection()->query("SELECT * FROM announcement");
        $result = $retrieve->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    //******************************************************************************

    //------------------------Select Announcement By Id------------------------------
    public function selectAnnouncementById($id)
    {
        $retrieve = $this->dbConnection()->query("SELECT * FROM announcement WHERE id ='$id'");
        $result = $retrieve->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    //******************************************************************************

    //------------------------Insert Announcement-----------------------------------
    public function insertAnnouncement($announcement)
    {
        $id = null;
        $title = $this->sanitizer->sanitizeString($announcement['title']);
        $timestamp = $announcement['timestamp'];
        $description = $this->sanitizer->sanitizeString($announcement['description']);
        $this->errorChecker($title, $description);
        if ($this->hasError) {
            return [
                "status" => "failed",
                "statusCode"=>400,
                "payload" => $this->errorMessage,
            ];
        } else {
            $insertAnnouncement = $this->dbConnection()->prepare("INSERT INTO announcement VALUES (?,?,?,?)");
            $insertAnnouncement->execute(array($id, $title, $timestamp, $description));

            return [
                "status" => "success",
                "statusCode"=>200,
                "payload" => "inserted",
            ];

        }
    }
    //******************************************************************************

    //------------------------Update Announcement By Id------------------------------
    public function updateAnnouncementById($id, $body)
    {
        $title = $this->sanitizer->sanitizeString($body['title']);
        $timestamp = $body['timestamp'];
        $description = $this->sanitizer->sanitizeString($body['description']);
        $this->errorChecker($title, $description);
        if ($this->hasError) {
            return [
                "status" => "failed",
                "statusCode"=>400,
                "payload" => $this->errorMessage,
            ];
        } else {
            $update = $this->dbConnection()->query("UPDATE announcement
        SET `timestamp` ='$timestamp',
            `title` = '$title',
            `description` = '$description'
            WHERE id='$id';");
            return [
                "status" => "success",
                "statusCode"=>200,
                "payload" => "updated",
            ];
        }
    }

    //------------------------Delete Announcement By Id------------------------------
    public function deleteAnnouncementById($id)
    {
        $delete = $this->dbConnection()->query(" DELETE FROM announcement WHERE id='$id'");
    }
    //******************************************************************************

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
