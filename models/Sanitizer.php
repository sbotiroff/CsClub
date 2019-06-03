<?php
class Sanitizer{

    public function sanitizeString($string){
        $clean = filter_var($string, FILTER_SANITIZE_STRING);
        return $clean;
    }

    public function sanitizeEmail($email){
        $clean = filter_var($email, FILTER_SANITIZE_EMAIL);
        return $clean;      
    }

    public function sanitizeNumber($number){
        $clean = filter_var($number, FILTER_SANITIZE_NUMBER_INT, FILTER_SANITIZE_NUMBER_FLOAT);
        return $clean;
    } 
}
?>