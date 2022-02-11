<?php

class ContactForm {

    // var $validform = true;
    // var $errorArray = array();
    var $firstName;
    var $lastName;
    var $dateOfBirth;
    var $emailAddress;
    var $middleName;
    var $message = "";

    public function __construct()
    {
        
    }

    public function getValidform(){
        return $this->validform;
    }

    public function setValidform($validform){
        $this->validform = $validform;
        return $this;
    }

    public function getFirstName(){
        return $this->firstName;
    }

    public function setFirstName($firstName){
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(){
        return $this->lastName;
    }

    public function setLastName($lastName){
        $this->lastName = $lastName;
        return $this;
    }
  
    public function getDateOfBirth(){
        return $this->dateOfBirth;
    }

    public function setDateOfBirth($dateOfBirth){
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    public function getEmailAddress(){
        return $this->emailAddress;
    }

    public function setEmailAddress($emailAddress){
        $this->emailAddress = $emailAddress;
        return $this;
    }

    public function getMiddleName(){
        return $this->middleName;
    }

    public function setMiddleName($middleName){
        $this->middleName = $middleName;
        return $this;
    }
 
    public function getMessage(){
        return $this->message;
    }

    public function setMessage($message){
        $this->message = $message;
        return $this;
    }

    /**
     * Sends an email response using key:value pairs from the contact form
     */
    function sendReponse($inFirstName, $inLastName, $inDateOfBirth, $inEmailAddress, $inMessage){
        $to = $inEmailAddress;        // email address
        $subject = "Contact Form Confirmation message";     // subject
        $message =  "<br>Hello,<br> 
                    This is a confirmation message that my contact form processed. 
                    All the contact form information is as follows:" . 
                    "<br>First Name: " . $inFirstName .
                    "<br>Last Name: " . $inLastName .
                    "<br>Date Of Birth: " . $inDateOfBirth .
                    "<br>Email Address: " . $to . 
                    "<br>Message: " . $inMessage .
                    "<br>Thank you.  
                    <br><br>Regards, 
                    <br> Jeremy Brannen";
        
        $headers = "From: jeremybrannen@jeremybrannen.info" . "\r\n";   // email address from host server
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";    // formats for http

        mail($to,$subject,$message,$headers);   // send out email
    }

    /**
     * Sanitizes string input, checks for empty value or string value
     * over 25 chars and sets appropiate error message.  Returns false if
     * string is not valid. Returns true if string is valid. 
     */
    function validateFirstName($inName){
        
        define("MAX_FNAME_LENGTH", 15);
        $inName = filter_var($inName, FILTER_SANITIZE_STRING);
        $inName = htmlspecialchars($inName, ENT_NOQUOTES);
        
        if($inName == ""){
            $this->errorArray[] = ("First name is required");
            $this->validform = false;
            return;
        }
        if(strlen($inName) > MAX_FNAME_LENGTH){
            $this->errorArray[] = ("First name cannot be more than 15 characters");
            $this->validform = false;
            return;
        }
    }

    /**
     * Sanitizes string input, checks for empty value or string value
     * over 15 chars and sets appropiate error message.  Returns false if
     * string is not valid. Returns true if string is valid. 
     */
    function validateLastName($inName){
        define("MAX_LNAME_LENGTH", 20);
        $inName = filter_var($inName, FILTER_SANITIZE_STRING);
        $inName = htmlspecialchars($inName, ENT_NOQUOTES);
        
        if($inName == ""){
            $this->errorArray[] = ("Last name is required");
            $this->validform = false;
            return;
        }
        if(strlen($inName) > MAX_LNAME_LENGTH){
            $this->errorArray[] = ("Last name cannot be more than 20 characters");
            $this->validform = false;
            return;
        }
    }

    /**
     * Checks date input variable for mm/dd/yyyy pattern and sets appropiate
     * error message.  Returns true if format is valid.  Returns false if 
     * format is not valid.
     */
    function validateDateOfBirth($inDate){
        define("MIN_MONTH", 1);
        define("MAX_MONTH", 12);
        define("MIN_DAY", 1);
        define("MAX_DAY", 31);
        define("MIN_YEAR", 1910);
        define("MAX_YEAR", 2021);
        $dateRegex = "/^\d{2}\/\d{2}\/\d{4}$/";

        if($inDate == ""){
            $this->errorArray[] = ("Date of birth is required");
            $this->validform = false;
            return;
        }
        if(preg_match($dateRegex, $inDate) === 0){
            $this->errorArray[] = ("Date must be in mm/dd/yyyy format");
            $this->validform = false;
            return;
        }
        if(substr($inDate, 0, 2) < MIN_MONTH || substr($inDate, 0, 2) > MAX_MONTH){
            $this->errorArray[] = ("Month must be between 1-12");
            $this->validform = false;
            return;
        }
        if(substr($inDate, 3, 2) < MIN_DAY || substr($inDate, 3, 2) > MAX_DAY){
            $this->errorArray[] = ("Day must be between 1-31");
            $this->validform = false;
            return;
        }
        if(substr($inDate, 6, 4) < MIN_YEAR || substr($inDate, 6, 4) > MAX_YEAR){
            $this->errorArray[] = ("Year must be between 1910-2021");
            $this->validform = false;
            return;
        }
    }

    /**
     * Validates email and sets correct error message. If email is 
     * valid returns true.  If not valid returns false.
     */
    function validateEmail($inEmail){
        $inEmail = filter_var($inEmail, FILTER_SANITIZE_EMAIL);
        
        if($inEmail == ""){
            $this->errorArray[] = ("Email is required");
            $this->validform = false;
            return;
        }
        if(filter_var($inEmail, FILTER_VALIDATE_EMAIL) === false){
            $this->errorArray[] = ("Email is invalid.  Please enter a valid email");
            $this->validform = false;
            return;
        }
    }

    /**
     * Sanitizes string input, checks for empty value or string value
     * over 150 chars and sets appropiate error message.  Returns false if
     * string is not valid. Returns true if string is valid. 
     */
    function validateMessage($inMessage){
        define("MAX_MESSAGE_LENGTH", 150);
        $inMessage = filter_var($inMessage, FILTER_SANITIZE_STRING);
        $inMessage = htmlspecialchars($inMessage, ENT_NOQUOTES);

        if($inMessage == ""){
            $this->errorArray[] = ("Message is required");
            $this->validform = false;
            return;
        }
        if(strlen($inMessage) > MAX_MESSAGE_LENGTH){
            $this->errorArray[] = ("Message length must be 150 characters or less");
            $this->validform = false;
            return;
        }
    }
}

?>