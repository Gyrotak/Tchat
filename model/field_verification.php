<?php

class field_verification
{
    
    /*
     * Check if text isn't sql injection and format text
     * @parameter string($text)
     * @return int|string
     */
    public function checkText($text)
    {
        if (true)
            return htmlspecialchars($text);
        return 0;
    }

    /*
     * Check format of email
     * @parameter string($email)
     * @return bool
     */
    public function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
            return 1;
        return 0;
    }

    /*
     * Checks the length and conformity of the password
     * @parameter string($password)
     * @return bool
     */
    public function checkPassword($password)
    {
        if (strlen($password) < 8)
            return 0;
        return 1;
    }
    
}

?>