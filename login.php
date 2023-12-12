<?php

//refereces
require_once "includes/common.php";
require_once "classes/Auth.php";

//check if the user is already logged in, redirect to protected/success page
if (Auth::isLoggedIn()) {

  //Redirect the user to the success/protected page (skip login)
  header("Location: " . Auth::SUCCESS_PAGE_URL);
  exit;
}

// Config
$title = "login";

// Start output buffering (trap output, don't display it yet)
ob_start();

if (isset($_POST["submitLogin"])) {

  //get data passed to this page 
  $username = trim($_POST["username"] ?? "");
  $password = $_POST["password"] ?? "";

  //check if either username or password NOT supplied
  if ($username === "" || $password === "") {

    //set error message
    $errorMessage = "username and password are required";

    //re-display the form with errors
    include_once "./templates/_loginPage.html.php";

    // both username and password supplied
  } else {


    try {
      //authenicate the user
      //NOTE: user will be redirected on success!

      //Note: login() is a static method, so we use class::method(),not  $object -> method() 
      Auth::login($username, $password);

      //if we reach here the login was not successful 

      $errorMessage = "Username or password Incorect";
    } catch (Exception $e) {

      $errorMessage = "Error Logging in: " . $ex->getMessage();
    }

    // re-Display login user form with messages
    include_once "./templates/_loginPage.html.php";
  }
} else {

  // Display login user form
  include_once "./templates/_loginPage.html.php";
}







// // Display login form
// include_once "./templates/_loginPage.html.php";

// Stop output buffering - store output into our $output variable
$output = ob_get_clean();

// Include layout template
include_once "./templates/_layout.html.php";




/**
 * Set an HTML-safe value of a form field from $_POST data.
 * @param string $fieldName The name of field to display.
 * @return string The HTML entity encoded output for the form field.
 */
function setValue($fieldName)
{
  return htmlspecialchars($_POST[$fieldName] ?? "");
}
