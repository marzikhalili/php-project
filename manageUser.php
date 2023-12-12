<?php

//refereces
require_once "includes/common.php";
require_once "classes/Auth.php";

//protect this page against unathorised access (non-logged-in user)
//users will be redirected if they do NOT have valid data in the PHP session
Auth::protect();

// Config
$title = "Home";

// Start output buffering (trap output, don't display it yet)
ob_start();

//check if the form has been submited 
if (isset($_POST["submitManageUser"])) {

  $errors = [];

  // Grab the current password and the new password
  $username = $_POST["username"];
  $currentPassword = $_POST["currentPassword"];
  $newPassword = $_POST["newPassword"];
  $confirmPassword = $_POST["confirmPassword"];


  // validate them (empty, etc)
  if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
    $errors[] = "fill all the fields";
  }

  // if they're fine, then check if the user's current password is accurate
  if (!empty($errors)) {

    $sql = <<<SQL
      SELECT userId
      FROM user
      WHERE username = :currentUser AND password = :currentPassword
    SQL;
    $stmt = self::$_db->prepareStatement($sql);
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);

    // check for match
    $result = $changePassword->changePassword($username, $currentPassword, $newPassword, $confirmPassword);
  }

  // if it's accurate, replace the password
  $changePassword = new ChangePassword($db);


  // Assuming $db is the existing DBAccess instance
  // $changePassword = new ChangePassword();

  // Call the changePassword method with the necessary parameters
  $result = $changePassword->changePassword($username, $currentPassword, $newPassword, $confirmPassword);

  // Handle the result as needed
  if ($result === true) {
    // Password changed successfully
    $successMessage = "Password changed successfully and the new Password is : $newPassword";
    // include_once "templates/_success.html.php";
  } else {
    // Password change failed, handle the error
    $errorMessage = "Password could not be updated, try again." . $result;
    // include_once "templates/_error.html.php";
  }


  // re-Display create user form with messages
  include_once "./templates/_manageUserPage.html.php";
} else {

  // Display create user form
  include_once "./templates/_manageUserPage.html.php";
}




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
