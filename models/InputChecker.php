<?php
class InputChecker
{
    public function isValidEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    public function isValidBoolean($boolean)
    {
        if (filter_var($boolean, FILTER_VALIDATE_BOOLEAN)) {
            return true;
        }
        return false;
    }

    public function isValidString($string)
    {
        if (!empty($string)) {
            return true;
        }
    }

    public function isValidNumber($number)
    {
        if (filter_var($number, FILTER_VALIDATE_INT, FILTER_VALIDATE_FLOAT)) {
            return true;
        }
        return false;
    }

    public function isValidFormat($base64)
    {
        $img = imagecreatefromstring(base64_decode($base64));
        if (!$img) {
            return false;
        }

        imagepng($img, 'tmp.png');
        $info = getimagesize('tmp.png');

        unlink('tmp.png');

        if ($info[0] > 0 && $info[1] > 0 && $info['mime']) {
            return true;
        }

        return false;
    }
}
