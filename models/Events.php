<?php
class Events extends DBConnect
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

    public function selectEvents()
    {
        $retrieve = $this->dbConnection()->query("SELECT * FROM events");
        $result = $retrieve->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function selectEventById($id)
    {
        $retrieve = $this->dbConnection()->query("SELECT * FROM events WHERE id ='$id'");
        $result = $retrieve->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function eventsCalendar()
    {
        $retrieve = $this->dbConnection()->query("SELECT title, timestamp FROM events");
        $result = $retrieve->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function upcomingEvents()
    {
        $retrieve = $this->dbConnection()->query("SELECT * FROM events WHERE timestamp>=CURRENT_TIMESTAMP ORDER BY timestamp ASC LIMIT 3");
        $result = $retrieve->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function prevEvents()
    {
        $retrieve = $this->dbConnection()->query("SELECT * FROM events WHERE timestamp<=CURRENT_TIMESTAMP ORDER BY timestamp ASC LIMIT 3");
        $result = $retrieve->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function insertEvent($event)
    {
        $id = null;
        $title = $this->sanitizer->sanitizeString($event['title']);
        $eventTime = $event['timestamp'];
        $description = $this->sanitizer->sanitizeString($event['description']);
        $base64Image =null;
        $this->errorChecker($title, $description);
        if ($this->hasError) {
            return [
                "status" => "failed",
                "statusCode" => 400,
                "payload" => $this->errorMessage,
            ];
        } else {
            
            $insertEvent = $this->dbConnection()->prepare("INSERT INTO events VALUES (?,?,?,?,?,?)");
            $insertEvent->execute(array($id, $title, $eventTime, $description, $base64Image, null));

            return [
                "status" => "success",
                "statusCode" => 200,
                "payload" => "inserted",
            ];
        }
    }

    public function updateEventById($id, $body)
    {
        $title = $this->sanitizer->sanitizeString($body['title']);
        $eventTime = $body['timestamp'];
        
        $description = $this->sanitizer->sanitizeString($body['description']);
        $base64Image = null;

        $this->errorChecker($title, $description);
        if ($this->hasError) {
            return [
                "status" => "failed",
                "statusCode" => 400,
                "payload" => $this->errorMessage,
            ];
        } else {
            $timestamp = strtotime($eventTime);
            $timestamp = date('Y-m-d H:i:s',$timestamp);
            $update = $this->dbConnection()->query("UPDATE events
            SET
            `title` = '$title',
            `timestamp` ='$timestamp',
            `description` = '$description',
            `image` = '$base64Image'
            WHERE id='$id';");
            return [
                "status" => "success",
                "statusCode" => 200,
                "payload" => "updated",
            ];

        }
    }

    public function deleteEventById($id)
    {
        $delete = $this->dbConnection()->query(" DELETE FROM events WHERE id='$id'");
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
        // if (!$this->inputChecker->isValidFormat($base64Image)) {
        //     $this->errorMessage += [
        //         "image" => "Upload have to be one of the following format: .JPG, JPEG or .PNG ",
        //     ];
        //     $this->hasError = true;
        // }
    }
    //******************************************************************************
}
