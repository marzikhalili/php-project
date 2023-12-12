<?php

// Common includes for the main PHP pages (controllers)
require_once "includes/common.php";

// Config
$title = "contact";

// check i the form has been submitted
if (isset($_POST["submit"])) {

    //form has been submited - process form DATA

    //get DATA passed to this page (in the $_POST super global array)
    $firstName = trim($_POST["firstName"] ?? "");
    $lastName = trim($_POST["lastName"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $contactNumber = trim($_POST["contactNumber"] ?? "");
    //  Clean up input data (e.g trim)
// $firstName = trim($firstName);
// $lastName = trim($lastName);

    // Collection of all errors for this form (empty by default)
    $errors = [];



    //validate first name (2+ characters)
    if (strlen($firstName) < 2) {
        $errors["firstName"] = "First name Must be 2+ characters";
    }


    //check for invalid DATA(errors)
    if (!empty($errors)) {
        // if(count($errors) > 0) { }

        // Invalid: Display the registration form with error messages

        // Include the confirmation templete using the output buffering
        ob_start();
        include_once "templates/_registerForm.html.php";
        $output = ob_get_clean();

    } else {

        // Valid: Display registration confirmation

        //include the template using the output buffring
        ob_start();
        include_once "templates/_registerConfirmation.html.php";
        $output = ob_get_clean();

    }

} else {

    // Form has not been sbmited(first load of the page) - just show the form 

    //step 0. start output buffering (capture output, dont display it yet)
    ob_start();

    // 1. Include the tegistration form templete
    include_once "templates/_registerForm.html.php";

    // Stop output buffering - store output in the $output variable
    $output = ob_get_clean();

}


// 2. Include  the layout template (and inject content)  
include_once "templates/_layout.html.php";


