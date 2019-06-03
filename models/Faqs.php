<?php
class Faqs extends DBConnect
{
    public function selectFaqs()
    {
        $retrieve = $this->dbConnection()->query("SELECT * FROM faq");
        $result = $retrieve->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    
    public function selectFaqById($id)
    {
        $selectFaq = $this->dbConnection()->query("SELECT * FROM `faq` WHERE id ='$id'");
        $result = $selectFaq->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function insertFaq($faq)
    {
        $id = null;
        $questions = $faq['questions'];
        $answers = $faq['answers'];

        $insertFaq = $this->dbConnection()->prepare("INSERT INTO faq VALUES (?,?,?)");
        $insertFaq->execute(array($id, $questions, $answers));
    }

    public function updateFaqById($id, $body)
    {
        $questions = $body['questions'];
        $answers = $body['answers'];

        $update = $this->dbConnection()->query("UPDATE faq
        SET `questions` ='$questions',
            `answers` = '$answers'
            WHERE id='$id';");
    }

    public function deleteFaqById($id)
    {
        $delete = $this->dbConnection()->query(" DELETE FROM faq WHERE id='$id'");
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
