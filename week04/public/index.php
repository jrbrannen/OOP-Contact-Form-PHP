<?php
    // include Contact form class file
    require_once "../inc/ContactForm.php";

    $dataArray = $_POST;
    $successMessage = null;

    // if form is submitted
    if(isset($dataArray['submit'])){

        // honeypot validation
        $middleName = $dataArray['middleName'];
        
        // if $middleName is not empty refresh the page, else assign contact form properties 
        // and validate them
        if(!empty($middleName)){
            header("refresh:0");
        }else{
            // create a new contact form object
            $contactForm = new ContactForm();
            
            // assign $dataArray elements to the contact form object
            $contactForm->setFirstName($dataArray['firstName']);
            $contactForm->setLastName($dataArray['lastName']);
            $contactForm->setDateOfBirth($dataArray['dateOfBirth']);
            $contactForm->setEmailAddress($dataArray['emailAddress']);
            $contactForm->setMessage($dataArray['message']);

            /*  validate all input text fields ($dataArray element values).
                Validform property is set to true.  Validation function calls 
                will set property to false if a validation fails. If a field 
                or fields are not valid error message will be stored in an 
                errorArray and displayed to the view.
            */
            $contactForm->validform = true;
            $contactForm->validateFirstName($contactForm->getFirstName());
            $contactForm->validateLastName($contactForm->getLastName());
            $contactForm->validateDateOfBirth($contactForm->getDateOfBirth());
            $contactForm->validateEmail($contactForm->getEmailAddress());
            $contactForm->validateMessage($contactForm->getMessage());

            // if the form is valid an email response will be sent, success message will display
            // in the view, and contact form properties will be reset
            if($contactForm->validform === true){
                $contactForm->sendReponse($contactForm->firstName, $contactForm->lastName, $contactForm->dateOfBirth, $contactForm->emailAddress, $contactForm->message);
                $successMessage = "Form was submitted.  You will recieve an email soon";
                $contactForm->firstName = "";
                $contactForm->lastName = "";
                $contactForm->dateOfBirth = "";
                $contactForm->emailAddress = "";
                $contactForm->message = "";
            }   
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Week 4 Assignment</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatable" content="IE=edge">
        <meta name="description" content="Week One Assignment" keywords="Week two assignment">
        <meta name="Author" content="Jeremy Brannen">
        <meta name="viewport" content="width=device-width, intial-scale=1.0">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        
        <!--Jeremy Brannen WDV441 Week 4 assignment-->
        
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        
        <script>
        </script>
        
        <style> 
            body{
                color: #484c9b;
                background-color: cornsilk;
            }
            form div:nth-child(4){
                display: none;
            }
        </style>

    </head>

    <body class="container-fluid">

        <h1 class="text-center"> Week 4 Assignment</h1>

        <h2 class="text-center">Contact Form</h2>
       
        <div class="col-md-8 mx-auto">
            <form class="" id="contactForm" name="contactForm" method="post" action="index.php">
                <div class="text-center text-primary">
                    <?php if (!is_null($successMessage)) {?>
                        <b><?= $successMessage ?></b>
                    <?php } ?>
                </div>
                <div class="text-left text-danger">
                    <?php if(isset($dataArray['submit']) && count($contactForm->errorArray) > 0){ ?>
                        <ul>
                            <?php foreach ($contactForm->errorArray as $errorMessage){ ?>
                                <li><?= $errorMessage ?></li>
                            <?php } ?>
                        </ul></br>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="firstName">First Name: </label>
                    <input type="text" class="form-control form-control-sm" name="firstName" id="firstName" value="<?= isset($contactForm->firstName) ? $contactForm->firstName : ""; ?>">
                </div>

                <div class="form-group">
                    <?php //honeypot ?>
                    <label for="middleName">Middle Name: </label>
                    <input type="text" class="form-control form-control-sm" name="middleName" id="middleName" value="">
                </div>

                <div class="form-group">
                    <label for="lastName">Last Name: </label>
                    <input type="text" class="form-control form-control-sm" name="lastName" id="lastName" value="<?= isset($contactForm->lastName) ? $contactForm->lastName : ""; ?>">
                </div>

                <div class="form-group">
                    <label for="dateOfBirth">Date Of Birth: </label>
                    <input type="text" class="form-control form-control-sm" name="dateOfBirth" id="dateOfBirth" value="<?= isset($contactForm->dateOfBirth) ? $contactForm->dateOfBirth : ""; ?>" placeholder="mm/dd/yyyy">
                </div>

                <div class="form-group">
                    <label for="emailAddress">Email: </label>
                    <input type="text" class="form-control form-control-sm" name="emailAddress" id="emailAddress" value="<?= isset($contactForm->emailAddress) ? $contactForm->emailAddress : ""; ?>" placeholder="youremail@domain.com">
                </div>

                <div class="form-group">
                    <label for="message">Message: </label>
                    <textarea class="form-control" name="message" id="message" value="<?= isset($contactForm->message) ? $contactForm->message : ""; ?>"><?= isset($contactForm->message) ? $contactForm->message : ""; ?></textarea>
                </div>

                <div class="text-center">
                    <input type="submit" class="bg-primary text-light rounded-sm" name="submit" id="submit" value="Submit">      
                    <input type="reset" name="Reset" id="button" value="Clear Form">
                </div>
            </form>
        </div>
        
    </body>

</html>